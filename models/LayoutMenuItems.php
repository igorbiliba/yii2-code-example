<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "layout_menu_items".
 *
 * @property integer $id
 * @property integer $layout_menu_id
 * @property string $variable
 * @property string $menu_template
 * @property string $menu_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property LayoutMenu $layoutMenu
 */
class LayoutMenuItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'layout_menu_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['layout_menu_id', 'variable'], 'required'],
            [['layout_menu_id', 'menu_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['variable'], 'string', 'max' => 63],
            [['menu_template'], 'string', 'max' => 255],
            //[['layout_menu_id', 'variable'], 'unique', 'targetAttribute' => ['layout_menu_id', 'variable'], 'message' => 'The combination of Layout Menu ID and Variable has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'layout_menu_id' => 'Layout Menu ID',
            'variable' => 'Variable',
            'menu_template' => 'Menu Template',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLayoutMenu()
    {
        return $this->hasOne(LayoutMenu::className(), ['id' => 'layout_menu_id']);
    }
}
