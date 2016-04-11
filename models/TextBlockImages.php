<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "text_block_images".
 *
 * @property integer $id
 * @property integer $text_block_id
 * @property string $name
 * @property string $align
 * @property integer $width
 * @property integer $height
 * @property integer $min_width
 * @property string $image
 *
 * @property TextBlock $textBlock
 */
class TextBlockImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'text_block_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text_block_id', 'name', 'width', 'height'], 'required'],
            [['text_block_id', 'width', 'height', 'min_width'], 'integer'],
            [['name'], 'string', 'max' => 31],
            [['align'], 'string', 'max' => 63],
            [['image'], 'string', 'max' => 127]
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
            'name' => 'Name',
            'align' => 'Align',
            'width' => 'Width',
            'height' => 'Height',
            'min_width' => 'Min Width',
            'image' => 'Image',
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
     * вернет картинку, или заглушку под картинку
     */
    public function getImg() {
        if(!empty($this->image) && is_file($this->image)) {
            $names = explode('/', $this->image);
            $name = end($names);
            
            if(strpos($name, '.') > -1) {
                return '/images/content_blocks/'.$this->name.'/' . $name;
            }
        }
        
        return LinkContents::NO_PHOTO;
    }
}
