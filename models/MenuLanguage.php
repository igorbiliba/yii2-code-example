<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu_language".
 *
 * @property integer $id
 * @property integer $language_id
 * @property integer $menu_id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Languages $language
 * @property Menu $menu
 */
class MenuLanguage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language_id', 'menu_id', 'name'], 'required'],
            [['language_id', 'menu_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 63],
            [['name'], 'unique'],
            [['language_id', 'menu_id'], 'unique', 'targetAttribute' => ['language_id', 'menu_id'], 'message' => 'The combination of Language ID and Menu ID has already been taken.']
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
            'menu_id' => 'Menu ID',
            'name' => \Yii::$app->translate->get('acms_name'),
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
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }
}
