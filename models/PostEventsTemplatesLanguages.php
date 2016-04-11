<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_events_templates_languages".
 *
 * @property integer $id
 * @property integer $language_id
 * @property integer $template_id
 * @property string $subject
 * @property string $from_name
 * @property string $content
 *
 * @property PostEventsTemplates $template
 * @property Languages $language
 */
class PostEventsTemplatesLanguages extends \yii\db\ActiveRecord
{   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_events_templates_languages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language_id', 'template_id', 'content'], 'required'],
            [['language_id', 'template_id'], 'integer'],
            [['content'], 'string'],
            [['subject', 'from_name'], 'string', 'max' => 127],
            [['language_id', 'template_id'], 'unique', 'targetAttribute' => ['language_id', 'template_id'], 'message' => \Yii::$app->translate->get('post_events_templates_languages_idx')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'language_id' => 'Language ID',
            'template_id' => 'Template ID',
            'subject' => \Yii::$app->translate->get('subject'),
            'from_name' => \Yii::$app->translate->get('from_name'),
            'content' => \Yii::$app->translate->get('content_email'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(PostEventsTemplates::className(), ['id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Languages::className(), ['id' => 'language_id']);
    }
    
    /**
     * отдаст "от кого",
     * если отсутствует тут, запросим из настроек
     * 
     * @return string
     */
    public function getFromName() {
        if(empty($this->from_name)) {
            $settings = PostEventsSettings::findOne([
                'language_id' => $this->language_id,
            ]);
            
            if($settings) {
                return $settings->from_name;
            }
        }
        
        return $this->from_name;
    }
    
    /**
     * Возвращает список переменных,
     * доступных для этого шаблона
     * 
     * @return type
     */
    public function getVariablesTemplate() {
        $template = $this->getTemplate()->one();
        
        $list = [];
        
        $event = (isset(\Yii::$app->params['post_events'][$template->type_event])) ? 
                \Yii::$app->params['post_events'][$template->type_event] : null;
        
        if($event) {
            if(isset($event['variables'])) {
                foreach ($event['variables'] as $item) {                    
                    $list[] = $item;
                }
            }
        }
        
        return $list;
    }
}
