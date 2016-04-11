<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "layout_menu".
 *
 * @property integer $id
 * @property string $layout_path
 * @property integer $is_default
 * @property string $created_at
 * @property string $updated_at
 *
 * @property LayoutMenuItems[] $layoutMenuItems
 */
class LayoutMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'layout_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['layout_path'], 'required'],
            [['layout_path'], 'unique'],
            [['is_default'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['layout_path'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'layout_path' => \Yii::$app->translate->get('the_template'),
            'is_default' => 'Is System',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLayoutMenuItems()
    {
        return $this->hasMany(LayoutMenuItems::className(), ['layout_menu_id' => 'id']);
    }
    
    /**
     * вернет, или создаст контент для переменной
     * в этом шаблоне
     * 
     * @return LinkContents
     */
    public function getVariable($key) {
        $model = $this
                ->getLayoutMenuItems()
                ->where([
                    'variable' => $key
                ])
                ->one();
        
        if(!$model) {
            $model = new LayoutMenuItems;
            $model->layout_menu_id = $this->id;
            $model->variable = $key;
            $model->save();
        }
        
        return $model;
    }
    
    /**
     * вернем шаблон по умолчанию,
     * либо первый из списка шаблонов
     */
    public static function getDefaultTeplPath() {
        $model = self::find()
                ->where([
                    'is_default' => 1,
                ])->one();
        
        if($model) {
            return $model->layout_path;
        }
        else {
            $templates = \app\models\DymanicTemplates::getListTemplates(\app\models\DymanicTemplates::FOLDER_DYNAMIC_LAYOUTS);
            if(is_array($templates) && count($templates) > 0) {
                $first = array_shift($templates);                
                return '@app'.\app\models\DymanicTemplates::FOLDER_DYNAMIC_LAYOUTS.'/'.$first;                
            }
        }
        
        return null;
    }
}
