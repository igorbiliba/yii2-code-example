<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "roles".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property WidgetCredentials[] $widgetCredentials
 */
class Roles extends \yii\db\ActiveRecord
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
        return 'roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 15],
            [['name'], 'unique'],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWidgetCredentials()
    {
        return $this->hasMany(WidgetCredentials::className(), ['role_id' => 'id']);
    }

    /**
     * вернет id роли, в противном случае создаст ее
     *
     * @param $roleName
     * @return int
     */
    public static function getRoleId($roleName) {
        $model = self::findOne(['name' => $roleName]);

        if(!$model) {
            $model = new self;
            $model->name = $roleName;
            $model->save();
        }

        if($model->id < 1) {
            $model = self::findOne(['name' => $roleName]);
        }

        return $model->id;
    }
}
