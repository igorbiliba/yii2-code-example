<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "link_languages".
 *
 * @property integer $id
 * @property integer $link_id
 * @property integer $language_id
 * @property string $title
 * @property string $h1
 * @property string $description
 * @property string $head_tags
 * @property string $canonical_link
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Languages $language
 * @property Links $link
 */
class LinkLanguages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'link_languages';
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
            [['link_id', 'language_id'], 'required'],
            [['link_id', 'language_id'], 'integer'],
            [['head_tags'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'h1', 'description'], 'string', 'max' => 127],
            [['canonical_link'], 'string', 'max' => 255],
            [['link_id', 'language_id'], 'unique', 'targetAttribute' => ['link_id', 'language_id']]
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
            'language_id' => 'Language ID',
            'title' => 'Title',
            'h1' => 'H1',
            'description' => 'Description',
            'head_tags' => \Yii::$app->translate->get('tags_in_head'),
            'canonical_link' => \Yii::$app->translate->get('canonical_link'),
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
     * @return \yii\db\ActiveQuery
     */
    public function getLink()
    {
        return $this->hasOne(Links::className(), ['id' => 'link_id']);
    }

    public static function find() {
        return (new LinkLanguagesActiveQuery(get_called_class()))->activeLanguages();
    }
}
