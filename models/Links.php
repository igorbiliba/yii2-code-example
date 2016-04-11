<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "links".
 *
 * @property integer $id
 * @property string $url
 * @property string $redirect_link
 * @property integer $show_in_menu
 * @property integer $is_serch
 * @property string $created_at
 * @property string $updated_at
 * @property integer $show_in_breadcrumbs
 * @property string $action
 * @property string $template
 * @property string $layout
 *
 * @property Links $parent
 * @property Links[] $links
 * @property Pages[] $pages
 */
class Links extends \yii\db\ActiveRecord
{
    const DEFAULT_PATH = 'main';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'links';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['template', 'layout'], 'string', 'max' => 127],
            [['show_in_menu', 'show_in_breadcrumbs', 'is_serch'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['url', 'redirect_link'], 'string', 'max' => 255],
            [['action'], 'string', 'max' => 127],
            [['url'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => \Yii::$app->translate->get('full_link'),
            'redirect_link' => \Yii::$app->translate->get('redirect_by_other_link'),
            'show_in_menu' => \Yii::$app->translate->get('show_in_menu'),
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'show_in_breadcrumbs' => \Yii::$app->translate->get('show_in_breadcrumbs'),
            'action' => \Yii::$app->translate->get('link_by_action'),
            'template' => \Yii::$app->translate->get('the_template'),
            'layout' => \Yii::$app->translate->get('the_layout'),
            'is_serch' => \Yii::$app->translate->get('is_serch'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Pages::className(), ['link_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinkCredentials()
    {
        return $this->hasMany(LinkCredentials::className(), ['link_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinkLanguages()
    {
        return $this->hasMany(LinkLanguages::className(), ['link_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinkContents()
    {
        return $this->hasMany(LinkContents::className(), ['link_id' => 'id']);
    }
    
    /**
     * вернет, или создаст контент для переменной
     * в этом шаблоне
     * 
     * @return LinkContents
     */
    public function getVariable($key) {
        $model = $this
                ->getLinkContents()
                ->where([
                    'key' => $key
                ])
                ->one();
        
        if(!$model) {
            $model = new LinkContents;
            $model->link_id = $this->id;
            $model->key = $key;
            $model->content_type = LinkContents::CONTENT_TYPE_OTHER;
            $model->save();
        }
        
        return $model;
    }
    
    /**
     * если путь шаблона пустой.
     * установим шаблон по умолчанию
     */
    public function afterFind() {
        parent::afterFind();
        
        if(empty($this->layout)) {
            $this->layout = LayoutMenu::getDefaultTeplPath();
        }
        
        if(empty($this->template)) {
            $templates = \app\models\DymanicTemplates::getListTemplates(\app\models\DymanicTemplates::FOLDER_DYNAMIC_TEMPLATES);
            if(is_array($templates) && count($templates) > 0) {
                $first = array_shift($templates);                
                $this->template = '@app'.\app\models\DymanicTemplates::FOLDER_DYNAMIC_TEMPLATES.'/'.$first;                
            }
        }
    }
}