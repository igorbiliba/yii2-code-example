<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "link_credentials".
 *
 * @property integer $id
 * @property integer $link_id
 * @property integer $role_id
 * @property integer $access
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Roles $role
 * @property Pages $link
 */
class LinkCredentials extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'link_credentials';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link_id', 'role_id'], 'required'],
            [['link_id', 'role_id', 'access'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['link_id', 'role_id'], 'unique', 'targetAttribute' => ['link_id', 'role_id']]
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link_id' => 'Link ID',
            'role_id' => 'Role ID',
            'access' => 'Access',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Roles::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLink()
    {
        return $this->hasOne(Links::className(), ['id' => 'link_id']);
    }
}
