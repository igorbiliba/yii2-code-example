<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 27.02.16
 * Time: 12:07
 */

namespace app\models;


use yii\db\ActiveQuery;

class LanguagesQuery extends ActiveQuery
{
    /**
     * активыне языки
     *
     * @return $this
     */
    public function active() {
        return $this->andWhere('languages.enable=1');
    }

    /**
     * язык по умолчанию
     *
     * @return $this
     */
    public function getDefault() {
        return $this->andWhere('languages.is_default=1');
    }
}