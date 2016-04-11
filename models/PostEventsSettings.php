<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_events_settings".
 *
 * @property integer $id
 * @property integer $language_id
 * @property string $from_name
 * @property string $from_email
 * @property string $header
 * @property string $footer
 *
 * @property Languages $language
 */
class PostEventsSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_events_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language_id', 'from_name', 'from_email', 'header', 'footer'], 'required'],
            [['from_email'], 'email'],
            [['language_id'], 'integer'],
            [['header', 'footer'], 'string'],
            [['from_name'], 'string', 'max' => 127],
            [['from_email'], 'string', 'max' => 63],
            [['language_id'], 'unique'],
            [['language_id'], 'unique']
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
            'from_name' => \Yii::$app->translate->get('from_name'),
            'from_email' => \Yii::$app->translate->get('from_email'),
            'header' => \Yii::$app->translate->get('header'),
            'footer' => \Yii::$app->translate->get('footer'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Languages::className(), ['id' => 'language_id']);
    }
    
    /**
     * вернет настройки для языка по умолчанию
     * 
     * @return type
     */
    public static function getDefaultSettings() {
        return self::find()->
            innerJoin('languages', 'languages.id = post_events_settings.language_id')
            ->where('languages.is_default = 1')
            ->one();
    }
    
    /**
     * вернет настройки в по коду языка
     * 
     * @param type $key
     * @return \app\models\PostEventsSettings
     */
    public static function getByLanguageKey($key) {
        return self::find()
            ->innerJoin('languages', 'languages.id = post_events_settings.language_id')
            ->where([
                'languages.key' => $key,
            ])
            ->one();
    }
}
