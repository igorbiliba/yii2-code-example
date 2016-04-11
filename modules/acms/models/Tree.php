<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 25.02.16
 * Time: 15:22
 */

namespace app\modules\acms\models;


use yii\db\ActiveQuery;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * микс таблицы links и составляющие от расширения TreeModel
 *
 * Class Tree
 * @package app\modules\acms\models
 */
class Tree extends \gilek\gtreetable\models\TreeModel
{
    public static function tableName()
    {
        return 'links';
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['url', 'redirect_link'], 'string', 'max' => 255],
            [['name'], 'match', 'pattern' => '/^[a-zA-Zа-яА-Я0-9]+$/', 'message' => \Yii::$app->translate->get('acms_only_char_and_numbers')],
        ]);
    }

    /**
     *   создадим url от потомков
     *
     * @param Tree $model
     * @return Tree
     */
    public function rewriteNameByPath() {
        $pathArr = explode('/', $this->getPath('/'));
        $pathArr = array_reverse($pathArr);
        $this->url = implode('/', $pathArr);
        $this->url = str_replace('//', '/', $this->url);
    }

    /**
     * перепишем урлы
     */
    public static function rewriteAllUrlsByNewPath() {
        $models = self::find()->orderBy('lft ASC')->all();

        foreach($models as $model) {
            $model->rewriteNameByPath();
            $model->save();
        }
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            $this->rewriteNameByPath();

            return true;
        }

        return false;
    }

    public function onlyForTree(Query $query) {
        return $query->andWhere([]);
    }

    /**
     * default scope, который разрешает tree видеть
     * записи, которые нужны только для деревьев
     *
     * @return \gilek\gtreetable\models\TreeQuery|ActiveQuery
     */
    public static function find()
    {
        return (new ForTreeQuery(get_called_class()))->onlyForTree();
    }
}