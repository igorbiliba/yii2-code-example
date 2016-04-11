<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "widget_credentials".
 *
 * @property integer $id
 * @property integer $widget_id
 * @property integer $role_id
 * @property integer $access
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Widgets $widget
 * @property Roles $role
 */
class WidgetCredentials extends \yii\db\ActiveRecord
{
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
    public static function tableName()
    {
        return 'widget_credentials';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['widget_id', 'role_id'], 'required'],
            [['widget_id', 'role_id', 'access'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['widget_id', 'role_id'], 'unique', 'targetAttribute' => ['widget_id', 'role_id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'widget_id' => 'Widget ID',
            'role_id' => 'Role ID',
            'access' => 'Access',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    public function getRole()
    {
        return $this->hasOne(Roles::className(), ['id' => 'role_id']);
    }
}
