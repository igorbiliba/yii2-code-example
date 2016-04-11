<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image_sizes_item".
 *
 * @property integer $id
 * @property integer $image_size_id
 * @property string $name
 * @property integer $width
 * @property integer $height
 * @property integer $min_width
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ImageSizes $imageSize
 */
class ImageSizesItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image_sizes_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_size_id', 'name', 'width', 'height', 'min_width'], 'required'],
            [['image_size_id', 'width', 'height', 'min_width'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 63]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_size_id' => 'Image Size ID',
            'name' => 'Name',
            'width' => 'Width',
            'height' => 'Height',
            'min_width' => 'Min Width',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageSize()
    {
        return $this->hasOne(ImageSizes::className(), ['id' => 'image_size_id']);
    }
}
