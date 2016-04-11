<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 23.02.16
 * Time: 17:47
 */

namespace app\modules\acms\models;


use app\models\Roles;

class WidgetCredentials extends \app\models\WidgetCredentials
{
    /**
     * создает парава для виджета
     *
     * @param Widgets $widget
     * @param $role
     * @param $access
     * @return WidgetCredentials|null
     */
    public static function createCredential(\app\modules\acms\models\Widgets $widget, $role, $access) {
        $model = new self;
        $model->widget_id = $widget->id;
        $model->role_id = Roles::getRoleId($role);
        $model->access = (int)$access;

        if($model->save()) {
            return $model;
        }

        return null;
    }
}