<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image_sizes".
 *
 * @property integer $id
 * @property string $key
 * @property integer $is_system
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ImageSizesItem[] $imageSizesItems
 */
class ImageSizes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image_sizes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['is_system'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['key'], 'string', 'max' => 63],
            [['key'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'is_system' => 'Is System',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageSizesItems()
    {
        return $this->hasMany(ImageSizesItem::className(), ['image_size_id' => 'id']);
    }
    
    /**
     * удалим сначала адаптивные разпешения
     * 
     * @return boolean
     */
    public function beforeDelete() {
        if(parent::beforeDelete()) {
            
            ImageSizesItem::deleteAll([
                'image_size_id' => $this->id,
            ]);
            
            return true;
        }
        
        return false;
    }
}
