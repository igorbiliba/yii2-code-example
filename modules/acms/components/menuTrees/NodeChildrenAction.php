<?php

/**
* @link https://github.com/gilek/yii2-gtreetable
* @copyright Copyright (c) 2015 Maciej Kłak
* @license https://github.com/gilek/yii2-gtreetable/blob/master/LICENSE
*/

namespace app\modules\acms\components\menuTrees;

use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use yii\validators\NumberValidator;

/**
 * экшен для отображения дерева 
 * в редактровании меню
 */
class NodeChildrenAction extends \gilek\gtreetable\actions\NodeChildrenAction {

    public function run($id) {
        $validator = new NumberValidator();
        $validator->integerOnly = true;
        if (!$validator->validate($id, $error)) {
            throw new HttpException(500, $error);
        }

        $query = (new $this->treeModelName)->find();
        
        $parent = $query->roots()->one();
        if ($parent === null) {
            throw new NotFoundHttpException(Yii::t('gtreetable', 'Position indicated by parent ID is not exists!'));
        }
        $nodes = $parent->children(999)->all();

        $result = [];
        foreach ($nodes as $node) {
            $result[] = [
                'id' => $node->getPrimaryKey(),
                'name' => $node->getName(),
                'level' => $node->getDepth(),
                'type' => $node->getType()
            ];
        }
        echo Json::encode(['nodes' => $result]);
    }
}