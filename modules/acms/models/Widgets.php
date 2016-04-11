<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 23.02.16
 * Time: 16:48
 */

namespace app\modules\acms\models;

class Widgets extends \app\models\Widgets
{
    /**
     * возвращает настроенный виджет от конфигурации
     *
     * @param $itemWidgetConf
     * @param install_module\Modules $module
     * @return null
     */
    public static function createWidget($itemWidgetConf, $module) {
        //если валидный конфиг виджета
        if(isset($itemWidgetConf['@attributes']['name']) &&
            isset($itemWidgetConf['@attributes']['class']) &&
            isset($itemWidgetConf['@attributes']['version'])) {

            //добавляем виджет
            $model = new self;
            $model->name = $itemWidgetConf['@attributes']['name'];
            $model->version = $itemWidgetConf['@attributes']['version'];
            $model->path = $itemWidgetConf['@attributes']['class'];
            $model->module_id = $module->id;

            //сохраняем виджет
            if($model->save()) {                
                //если есть настройки прав
                if(isset($itemWidgetConf['credentials'])) {
                    //добавляем права
                    foreach($itemWidgetConf['credentials'] as $role => $access) {
                        $model->addCredential($role, $access);
                    }
                }

                return true;
            }
            
        }

        return false;
    }

    /**
     * добавить парава на виджет
     *
     * @param $role
     * @param $access
     */
    public function addCredential($role, $access) {
        return WidgetCredentials::createCredential($this, $role, $access);
    }

    /**
     * возвращает список виджетов для селекта
     */
    public static function getListWidgets() {
        $list = [null => ''];

        $models = self::find()
            ->orderBy('name ASC')
            ->all();

        if($models) {
            foreach($models as $model) {
                $list[$model->id] = $model->name . ' (v. '.$model->version.')';
            }
        }

        return $list;
    }
}