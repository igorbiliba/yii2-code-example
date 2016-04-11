<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "link_contents".
 *
 * @property integer $id
 * @property integer $link_id
 * @property integer $widget_id
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property string $content_type
 * @property string $key
 * @property string $template
 * @property integer $sort
 * @property integer $menu_id
 * @property integer $text_block_id
 *
 * @property Widgets $widget
 * @property Links $link
 */
class LinkContents extends \yii\db\ActiveRecord
{
    /**
     * сорттировка по умолчанию
     */
    const DEFAULT_SORT = 1000;
    
    const NO_PHOTO = '/images/no-photo.gif';

    //типы котента
    const CONTENT_TYPE_WIDGET         = 'widget';
    const CONTENT_TYPE_HTML           = 'html';
    const CONTENT_TYPE_TEXT           = 'text';
    const CONTENT_TYPE_IMAGE          = 'image';
    const CONTENT_TYPE_OTHER          = 'other';
    const CONTENT_TYPE_CONTENT_BLOCK  = 'content_block';
    const CONTENT_TYPE_TEXT_BLOCK     = 'text_block';
    const CONTENT_TYPE_MENU           = 'menu';
    //************

    const IMAGE_DEFAULT_EXTEND = 'jpg';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'link_contents';
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
            [['link_id', 'content_type'], 'required'],
            [['link_id', 'widget_id', 'sort', 'menu_id', 'text_block_id'], 'integer'],
            [['content', 'content_type', 'key', 'template'], 'string'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link_id' => 'Link ID',
            'widget_id' => \Yii::$app->translate->get('the_widget'),
            'content' => \Yii::$app->translate->get('the_content'),
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'content_type' => \Yii::$app->translate->get('type_block'),            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWidget()
    {
        return $this->hasOne(Widgets::className(), ['id' => 'widget_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLink()
    {
        return $this->hasOne(Links::className(), ['id' => 'link_id']);
    }

    /**
     * url к картинке
     */
    public function getImgSrc() {
        if(is_file($this->getInternalImgPath())) {
            return '/images/content_blocks/'.$this->id . '.' . self::IMAGE_DEFAULT_EXTEND;
        }

        return self::NO_PHOTO;
    }

    /**
     * внутренний путь к картинке
     *
     * @return string
     */
    protected function getInternalImgPath() {
        return \Yii::$app->basePath . '/web/images/content_blocks/' . $this->id . '.' . self::IMAGE_DEFAULT_EXTEND;// . $this->imageFile->extension;
    }

    public function beforeDelete()
    {
        $ret = parent::beforeDelete();

        //если тип контента изображение- то нужно удалить и картинку
        if($this->content_type == self::CONTENT_TYPE_IMAGE) {
            $file = $this->getInternalImgPath();

            if(is_file($file)) {
                unlink($file);
            }
        }

        return $ret;
    }
    
    /**
     * вернет вид ключа, как он выглядит в шаблоне
     */
    public function getHtmlTemplateKey() {
        return \app\components\render\RenderDynamicTemplate::getHtmlTemplateKey($this->key);
    }
    
    /**
     * или ключ элемента массив
     */
    public function getIsArray() {
        return (strpos($this->key, '[') > -1) ? 1 : 0;
    }
}
