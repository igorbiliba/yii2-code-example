<?php

namespace app\modules\acms\models;

class ImageSizes extends \app\models\ImageSizes {    
    /**
     * разрешения по умолчанию
     * 
     * @return type
     */
    public static function getDefaultSizes() {
        return [
            '480x280' => [
                'width' => 480,
                'height' => 280,
                'min_width' => 0,
            ],
            '768x480' => [
                'width' => 768,
                'height' => 480,
                'min_width' => 481,
            ],
            '1024x640' => [
                'width' => 1024,
                'height' => 640,
                'min_width' => 769,
            ],
            '1280x800' => [
                'width' => 1280,
                'height' => 800,
                'min_width' => 1025,
            ],
            '1440x943' => [
                'width' => 1440,
                'height' => 943,
                'min_width' => 1281,
            ],
        ];
    }

    /**
     * создает адаптивность
     */
    public static function create($key, $sizes) {
        $model = new self;
        $model->is_system = 1;
        $model->key = $key;

        if ($model->save()) {
            foreach ($sizes as $name => $val) {
                //или валидный параметр
                if( isset($val['width']) && isset($val['height'])
                        && isset($val['min_width'])) {
       
                    //создаст параметр разрешения
                    $model->createChildren($val['width'], $val['height'], $val['min_width'], $name);
                    
                }
            }

            return true;
        }

        return false;
    }

    /**
     * создаст параметр разрешения
     * 
     * @param type $width
     * @param type $height
     * @param type $min_width
     * @param string $name
     */
    public function createChildren($width, $height, $min_width, $name = null) {
        if ($name === null) {
            $name = $width . 'x' . $height;
        }
        
        //добавим разрешение
        $model = new \app\models\ImageSizesItem;
        $model->image_size_id = $this->id;
        $model->width = $width;
        $model->height = $height;
        $model->min_width = $min_width;
        $model->name = $name;
        
        return $model->save();
    }

    /**
     * вернет массив разрешений
     */
    public function getChildrens() {
        $list = [];
        
        //запросим списор разрешений
        $models = $this
                ->getImageSizesItems()
                ->orderBy('width')
                ->all();
        
        if($models) {
            /* @var $model \app\models\ImageSizesItem */
            foreach ($models as $model) {
                $list[$model->name] = [
                    'width' => $model->width,
                    'height' => $model->height,
                    'min_width' => $model->min_width,
                ];
            }
        }
        
        return $list;
    }

    /**
     * возвращаем размеры изображений для адаптивности
     * по ключу
     * в виде массив
     * 
     * @param type $key
     */
    public static function get($key) {
        //если не найдем адаптивность
        //по этому ключу, вернем значения по умолчанию.

        $model = self::find()->where([
            'key' => $key
        ])->one();
        
        if($model) {
            return $model->childrens;
        }
        
        return self::getDefaultSizes();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageSizesItems()
    {
        return $this->hasMany(ImageSizesItem::className(), ['image_size_id' => 'id']);
    }
    
    /**
     * вернет все размеры
     * текущего ключа
     * 
     * @return type
     */
    public function getSizes() {
        return $this->getImageSizesItems()
                ->orderBy('width ASC')
                ->all();
    }
}
