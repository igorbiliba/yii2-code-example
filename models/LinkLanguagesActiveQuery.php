<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 25.02.16
 * Time: 18:43
 */

namespace app\models;
use yii\db\ActiveQuery;

/**
 * active query, который разрешает видеть
 * языковые настройки только по активным языкам
 *
 * Class LinkLanguagesActiveQuery
 * @package app\models
 */
class LinkLanguagesActiveQuery extends ActiveQuery
{
    /**
     * лишь яактивные языки
     *
     * @return $this
     */
    public function activeLanguages()
    {
        return $this
            ->andWhere('languages.enable=1')
            ->innerJoin('languages', 'languages.id=link_languages.language_id');
    }

    /**
     * настройка языка по умолчанию
     *
     * @return $this
     */
    public function getDefault() {
        return $this
            ->andWhere('languages.is_default=1');
    }
}