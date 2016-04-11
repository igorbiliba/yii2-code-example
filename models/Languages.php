<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "languages".
 *
 * @property integer $id
 * @property integer $enable
 * @property string $key
 * @property string $title
 * @property integer $is_default
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Pages[] $pages
 */
class Languages extends \yii\db\ActiveRecord
{
    const LANG_RU = 'RU';
    const ROOT_ID = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages';
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
            [['enable', 'is_default'], 'integer'],
            [['key', 'title'], 'required'],
            [['key'], 'match', 'pattern' => '/^[a-zA-Z-]+$/', 'message' => \Yii::$app->translate->get('only_latin_chars')],
            [['created_at', 'updated_at'], 'safe'],
            [['key'], 'string', 'max' => 7],
            [['title'], 'string', 'max' => 31],
            [['key'], 'unique'],
            [['title'], 'unique'],
            [['key'], 'unique'],
            [['title'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'enable' => \Yii::$app->translate->get('is_active'),
            'key' => \Yii::$app->translate->get('the_code'),
            'title' => \Yii::$app->translate->get('the_name'),
            'is_default' => \Yii::$app->translate->get('is_default'),
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Pages::className(), ['language_id' => 'id']);
    }

    /**
     * @return LanguagesQuery
     */
    public static function find()
    {
        return new LanguagesQuery(get_called_class());
    }
    
    /**
     * возвращает красивое имя ключа
     */
    public function getName() {
        if(strpos($this->key, '-') > -1) {
            $list = explode('-', $this->key);
            
            if(isset($list[1])) {
                return $list[1];
            }
            elseif(isset($list[0])) {
                return $list[0];
            }
        }
        
        return $this->key;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostSettings()
    {
        return $this->hasOne(PostEventsSettings::className(), ['language_id' => 'id']);
    }
}
