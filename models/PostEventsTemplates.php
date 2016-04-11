<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_events_templates".
 *
 * @property integer $id
 * @property integer $is_active
 * @property string $type_event
 * @property integer $delay
 * @property string $content_type
 * @property string $from_email
 *
 * @property PostEventsTemplatesLanguages[] $postEventsTemplatesLanguages
 */
class PostEventsTemplates extends \yii\db\ActiveRecord
{
    const CONT_TEXT_HTML  = 'text/html';
    const CONT_TEXT_PLAIN = 'text/plain';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_events_templates';
    }

    /**
     * список типов контента
     *
     * @var type 
     */
    public static $contentTypes = [
        'text/html'  => 'text/html',
        'text/plain' => 'text/plain',
    ];
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        
        /**
         * если есть шаблоны такого типа
         * а наш шаблон активный, то остальные декативируем
         */        
        if($this->is_active) {
            $models = self::find()
                    ->where(['type_event' => $this->type_event])
                    ->andWhere(['is_active' => 1])
                    ->andWhere(' id <> :my_id ', [
                        ':my_id' => $this->id,
                    ])
                    ->all();
            
            if(!empty($models)) {
                foreach ($models as $model) {
                    $model->is_active = 0;
                    $model->save();
                }
            }
        }
    }


    /**
     * типы событий
     * 
     * примеры переводов событий:
     * 'type_event_registration' => [
            'ru-RU' => 'Регистрация'
        ],
        'type_event_remember_password' => [
            'ru-RU' => 'Напоминание пароля'
        ],
     * 
     * @return type
     */
    public static function getEventsTypes() {
        $list = [];
        
        $all = self::find()
                ->groupBy('type_event')
                ->all();
        
        foreach ($all as $item) {
            $list[$item->type_event] = $item->name;
        }
        
        return $list;
    }

    /**
     * имя события, если оно переведено
     * 
     * если не переведено, вермен как есть
     * 
     * @return type
     */
    public function getName() {
        if(isset(\Yii::$app->params['post_events'][$this->type_event])) {
            $event = \Yii::$app->params['post_events'][$this->type_event];
            
            if(isset($event['title'])) {
                return \Yii::$app->translate->get($event['title']);
            }
        }
        
        return $this->type_event;
    }

        /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active', 'delay'], 'integer'],
            [['from_email'], 'email'],
            [['type_event', 'delay', 'content_type'], 'required'],
            [['content_type'], 'string'],
            [['type_event'], 'string', 'max' => 31],
            [['from_email'], 'string', 'max' => 63],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => \Yii::$app->translate->get('is_active'),
            'type_event' => \Yii::$app->translate->get('type_event'),
            'delay' => \Yii::$app->translate->get('delay_before_send'),
            'content_type' => \Yii::$app->translate->get('content_type'),
            'from_email' => \Yii::$app->translate->get('from_email'),
            'subject' => \Yii::$app->translate->get('subject'),
            'from_name' => \Yii::$app->translate->get('from_name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostEventsTemplatesLanguages()
    {
        return $this->hasMany(PostEventsTemplatesLanguages::className(), ['template_id' => 'id']);
    }
    
    /**
     * вернет мультиязычный шаблон для текущего типа шаблонов
     * 
     * если null, то берем язык из текущей сессии
     * 
     * @param type $languageCode
     * @return \app\models\PostEventsTemplatesLanguages
     */
    public function getLanguageTemplate($languageCode) {        
        return $this->
            getPostEventsTemplatesLanguages()
            ->innerJoin('languages', 'languages.id = post_events_templates_languages.language_id')
            ->where(['languages.key' => $languageCode])
            ->one();
    }
    
    /**
     * @return PostEventsTemplatesQuery
     */
    public static function find()
    {
        return new PostEventsTemplatesQuery(get_called_class());
    }
    
    /**
     * отдаст email,
     * если отсутствует тут, запросим из настроек
     * 
     * если $languageCode null,
     * то берем язык по умолчанию
     * 
     * @param type $languageCode
     * @return type
     */
    public function getFromEmail($languageCode = null) {
        if(empty($this->from_email)) {            
            if($languageCode == null) {
                $languageCode = \Yii::$app->translate->getLanguageCode();
            }
            
            //запросим настройки по этому языку
            $settings = PostEventsSettings::getByLanguageKey($languageCode);
            if($settings) {
                return $settings->from_email;
            }
        }
        
        return $this->from_email;
    }
    
    public function getSubject() {        
        $languageCode = \Yii::$app->translate->getLanguageCode();
        $model = $this
                ->getPostEventsTemplatesLanguages()
                ->join('INNER JOIN', 'languages', 'languages.id = post_events_templates_languages.language_id')
                ->where([
                    'languages.key' => $languageCode
                ])
                ->one();
        
        if($model) {
            return $model->subject;
        }
        
        return null;
    }
    
    /**
     * вернет имя отправителя из языковых настроек,
     * в противном случае и общих настроек
     * 
     * @return type
     */
    public function getFrom_name() {
        $languageCode = \Yii::$app->translate->getLanguageCode();
        
        $model = $this
                ->getPostEventsTemplatesLanguages()
                ->join('INNER JOIN', 'languages', 'languages.id = post_events_templates_languages.language_id')
                ->where([
                    'languages.key' => $languageCode
                ])
                ->one();
        
        if($model && !empty($model->from_name)) {
            return $model->from_name;
        }
        else {
            //запросим настройки по этому языку
            $settings = PostEventsSettings::getByLanguageKey($languageCode);
            if($settings) {
                return $settings->from_name;
            }
        }
        
        return null;
    }
}
