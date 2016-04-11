<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "post_events".
 *
 * @property integer $id
 * @property string $email
 * @property string $subject
 * @property string $text
 * @property integer $expire
 * @property string $status
 * @property integer $is_copy
 * @property string $created_at
 * @property string $updated_at
 * @property string $from_name
 * @property string $from_email
 * @property string $content_type
 * @property string $type_event
 */
class PostEvents extends \yii\db\ActiveRecord
{   
    /**
     * ожидает
     */
    const STATUS_WAIT = "wait";
    
    /**
     * отправлен
     */
    const STATUS_IS_SEND = "is_send";
    
    /**
     * есть проблеммы
     */
    const STATUS_TROUBLE = "trouble";
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_events';
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
     * Возвращает список почтовых событий
     */
    public static function getListEvents() {
        $list = [];
        
        foreach (\Yii::$app->params['post_events'] as $key => $val) {
            $list[$key] = \Yii::$app->translate->get($val['title']);
        }
        
        return $list;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'subject', 'text', 'status', 'from_name', 'from_email', 'content_type', 'type_event'], 'required'],
            [['text', 'status', 'type_event'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_copy', 'expire'], 'integer'],
            [['email'], 'string', 'max' => 127],
            [['subject'], 'string', 'max' => 255],
            [['from_name'], 'string', 'max' => 127],
            [['from_email'], 'string', 'max' => 63],
            [['content_type'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => \Yii::$app->translate->get('email_for_send'),
            'subject' => \Yii::$app->translate->get('subject'),
            'text' => \Yii::$app->translate->get('text'),
            'expire' => \Yii::$app->translate->get('expire'),            
            'status' => \Yii::$app->translate->get('status'),
            'is_copy' => \Yii::$app->translate->get('is_copy'),
            'created_at' => \Yii::$app->translate->get('created_at'),
            'updated_at' => \Yii::$app->translate->get('updated_at'),
            'from_name' => \Yii::$app->translate->get('from_name'),
            'from_email' => \Yii::$app->translate->get('from_email'),
            'content_type' => \Yii::$app->translate->get('content_type'),
            'type_event' => \Yii::$app->translate->get('type_event'),
        ];
    }
    
    /**
     * @return LanguagesQuery
     */
    public static function find()
    {
        return new PostEventsQuery(get_called_class());
    }
    
    /**
     * вернет активный шаблон по типу события
     */
    public function getTemplate() {
        return PostEventsTemplates::find()
            ->where(['is_active' => 1])
            ->andWhere([
                'type_event' => $this->type_event,
            ]);
    }
    
    /**
     * отдаст ид события по переведенному названию
     * или части названия
     * 
     * @return array
     */
    public static function getTypeEventsByLikeTranslateName($partName) {
        $list = [];
        $all = \Yii::$app->event->all;
        
        foreach ($all as $key => $value) {
            
            if(strpos(mb_strtolower(trim($value), 'UTF-8'), mb_strtolower(trim($partName), 'UTF-8')) > -1) {
                $list[] = $key;
            }
        }
        
        return $list;
    }
}
