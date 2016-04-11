<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "text_block_languages".
 *
 * @property integer $id
 * @property integer $text_block_id
 * @property integer $language_id
 * @property string $title
 * @property string $text
 *
 * @property TextBlock $textBlock
 * @property Languages $language
 */
class TextBlockLanguages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'text_block_languages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text_block_id', 'language_id'], 'required'],
            [['text_block_id', 'language_id'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 127]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text_block_id' => 'Text Block ID',
            'language_id' => 'Language ID',
            'title' => \Yii::$app->translate->get('title'),
            'text' => \Yii::$app->translate->get('content'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTextBlock()
    {
        return $this->hasOne(TextBlock::className(), ['id' => 'text_block_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Languages::className(), ['id' => 'language_id']);
    }
}
