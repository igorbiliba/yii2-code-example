<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 25.02.16
 * Time: 18:43
 */

namespace app\modules\acms\models;


use gilek\gtreetable\models\TreeQuery;

/**
 * active query, который разрешает tree видеть
 * записи, которые нужны только для деревьев
 *
 * Class ForTreeQuery
 * @package app\modules\acms\models
 */
class ForTreeQuery extends TreeQuery
{
    public function onlyForTree()
    {
        return $this->andWhere([
            'is_system' => 0,
        ]);
    }
}