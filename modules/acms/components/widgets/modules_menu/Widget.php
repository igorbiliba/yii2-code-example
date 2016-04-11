<?php
namespace app\modules\acms\components\widgets\modules_menu;

use execut\widget\TreeView;

/**
 * Меню списка модулей
 * 
 * делаем выборку из базы по модулям используя сортировку.
 * смотрим файлы конфигурации модуля, ищем там админские экшены
 */
class Widget extends \yii\base\Widget {    
    private $groupsContent=null;

    /**
     * устанавливаем значения согласно
     * инструкции расширения http://www.yiiframework.com/extension/yii2-widget-bootstraptreeview/
     */
    public function init() {
        $onSelect = new \yii\web\JsExpression(<<<JS
function (undefined, item) {
    if((typeof item.href) != "undefined") {
        window.location = item.href;
    }
}
JS
);
        $this->groupsContent = TreeView::widget([
            'data' => $this->getItems(),
            'size' => TreeView::SIZE_SMALL,
            'clientOptions' => [
                'onNodeSelected' => $onSelect,
                'selectedBackColor' => 'rgb(40, 153, 57)',
                'borderColor' => '#fff',
            ],
            'header' => \Yii::$app->translate->get('acms_select_from_tree')
        ]);
    }

    /**
     * выборка установленных виджетов
     */
    protected function getItems() {
        $items = [];
        
        //элемент из меню, отвечающий за установку модулей
        $items[] = \app\modules\acms\components\widgets\modules_menu\models\Modules::getInstallModuleItems();
        
        //установленные модули
        $models = \app\modules\acms\components\widgets\modules_menu\models\Modules::find()
                ->orderBy('sort ASC')
                ->all();
        
        //флаг на закладку
        $isBookmarks = true;
        
        foreach ($models as $model) {
            /* @var \app\modules\acms\components\widgets\modules_menu\models\Modules $model */            
            $item = [
                'text' => \Yii::$app->translate->get($model->name),
                'nodes' => $model->adminUrls,
            ];
            
            //значит этот элемент не попадет в избранное
            if($model->sort >= \app\modules\acms\components\widgets\modules_menu\models\Modules::DEFAULT_SORT) {                
                //ставим пробел
                if($isBookmarks) {
                    $isBookmarks = false;
                    
                    //если есть избранно, отделяем пустым элементом
                    if(count($items) > 0) {
                        $items[] = [
                            'text' => \yii\bootstrap\Html::tag('hr'),
                        ];
                    }
                }
            }
            
            $items[] = $item;
        }
        
        return $items;
    }
    
    public function run() {
        return $this->groupsContent;
    }
}