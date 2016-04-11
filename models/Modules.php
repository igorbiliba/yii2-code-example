<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "modules".
 *
 * @property integer $id
 * @property integer $sort
 * @property string $name
 * @property double $version
 * @property string $created_at
 * @property string $updated_at
 * @property string $path
 *
 * @property Widgets[] $widgets
 */
class Modules extends \yii\db\ActiveRecord
{
    /**
     * порядок сортировки- обозначающий,
     * без сортировки
     */
    const DEFAULT_SORT = 1000;
    
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
        return 'modules';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'version'], 'required'],
            [['version', 'sort'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 63],
            [['path'], 'string', 'max' => 255],
            [['path'], 'unique'],
            [['name', 'version'], 'unique', 'targetAttribute' => ['name', 'version']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => \Yii::$app->translate->get('module_name'),
            'version' => \Yii::$app->translate->get('the_version'),
            'created_at' => \Yii::$app->translate->get('created_at'),
            'updated_at' => \Yii::$app->translate->get('updated_at'),
            'path' => \Yii::$app->translate->get('path_by_module'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWidgets()
    {
        return $this->hasMany(Widgets::className(), ['module_id' => 'id']);
    }

    /**
     * удаляем виджеты и свзязи с ними
     *
     * @return bool
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete()) {
            $widgets = $this->getWidgets()->all();
            foreach($widgets as $widget) {
                /* @var \app\models\Widgets $widget */
                $widget->removeCredentials();
                $widget->delete();
            }

            return true;
        }

        return false;
    }
}
