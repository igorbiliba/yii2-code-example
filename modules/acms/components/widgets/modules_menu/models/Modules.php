<?php
namespace app\modules\acms\components\widgets\modules_menu\models;

/**
 * Меню списка модулей
 * 
 * делаем выборку из базы по модулям используя сортировку.
 * смотрим файлы конфигурации модуля, ищем там админские экшены
 */
class Modules extends \app\modules\acms\models\Modules {
    
    const DEFAULT_URL_MODULE = '/acms/modules';
    
    /**
     * элемент из меню, отвечающий за установку модулей
     */
    public static function getInstallModuleItems() {
        return [
            'text' => \Yii::$app->translate->get('acms_install_module_in_menu'),
            'href' => '/acms/modules',
        ];
    }

    /**
     * ищем в файле конфигурации модуля урлы в админку
     * 
     * @return type
     */
    public function getAdminUrls() {
        $urls = [];
        
        $xml = $this->xmlCurrentModule;
        
        if(isset($xml['admin_urls'])) {
            foreach ($xml['admin_urls'] as $key => $value) {
                if(!is_array($value)) {
                    $urls[] = [
                        'text' => \Yii::$app->translate->get($key),
                        'href' => self::DEFAULT_URL_MODULE.$value,
                    ];
                }
            }
        }
        
        return $urls;
    }
}