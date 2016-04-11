<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "widgets".
 *
 * @property integer $id
 * @property integer $module_id
 * @property string $name
 * @property double $version
 * @property string $created_at
 * @property string $updated_at
 * @property string $path
 *
 * @property WidgetCredentials[] $widgetCredentials
 * @property Modules $module
 */
class Widgets extends \yii\db\ActiveRecord
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
        return 'widgets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module_id', 'name', 'version'], 'required'],
            [['module_id'], 'integer'],
            [['version'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 63],
            [['path'], 'string', 'max' => 255],
            [['path'], 'unique'],
            [['module_id', 'name', 'version'], 'unique', 'targetAttribute' => ['module_id', 'name', 'version']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_id' => \Yii::$app->translate->get('the_module'),
            'name' => \Yii::$app->translate->get('the_name'),
            'version' => \Yii::$app->translate->get('the_version'),
            'created_at' => \Yii::$app->translate->get('created_at'),
            'updated_at' => 'Updated At',
            'path' => \Yii::$app->translate->get('path_by_widget'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWidgetCredentials()
    {
        return $this->hasMany(WidgetCredentials::className(), ['widget_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Modules::className(), ['id' => 'module_id']);
    }

    /**
     * удаляем настройки доспупа к виджету
     *
     * @return bool
     */
    public function removeCredentials() {
        WidgetCredentials::deleteAll([
            'widget_id' => $this->id,
        ]);

        return true;
    }
}
