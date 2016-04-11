<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 22.02.16
 * Time: 19:47
 */

namespace app\modules\acms\components;


use app\modules\acms\models\Modules;
use app\modules\acms\Module;
use yii\base\Exception;
use yii\data\ActiveDataProvider;

/**
 * хитрый ActiveProvider, который знает о дирректориях модулей и свзяви с базой
 *
 * Class MixFileActiveDataProvider
 * @package app\modules\acms\components
 */
class MixFileActiveDataProvider extends ActiveDataProvider
{
    /**
     * дирректории модулей
     * и кофигурации
     *
     * @var null
     */
    public $directories = null;

    /**
     * модели модули на фаловой системе+в базе
     *
     * @return array
     */
    public function getModels()
    {
        $modules = [];

        //модули, которые есть в фаловой сисеме
        if(is_array($this->directories) && count($this->directories) > 0) {
            foreach($this->directories as $item) {
                $module = null;
                try {
                    $module = new Modules();
                    $module->name = $item['@attributes']['name'];
                    $module->version = $item['@attributes']['version'];
                    $module->folder = $item['folder'];
                    $module->path = Modules::MODULES_DIR.$item['folder'];
                }
                catch(Exception $e) {
                    $module = new Modules();
                    $module->errorInstall = Modules::ERROR_INSTALL_BAD_CONFIG;
                }

                $modules[] = $module;
            }
        }

        //ищем случайно удаленные модули
        $all = $this->query->all();
        foreach($all as $model) {
            $fullPath = \Yii::$app->basePath . $model->path;
            if(!is_dir($fullPath)) {
                $modules[] = $model;
            }
        }

        return $modules;
    }
}