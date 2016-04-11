<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 25.02.16
 * Time: 10:49
 */

namespace app\modules\acms\models;


class Languages extends \app\models\Languages
{
    /**
     * установка активации по id
     *
     * @param $id
     */
    public static function setIsActiveById($id, $enable) {
        $model = self::findOne(['id' => $id]);
        if(!$model) return false;

        if($enable == 0 && $model->is_default) {
            \Yii::$app->session->setFlash('error', \Yii::$app->translate->get('acms_error_edit_default_language'));
            return false;
        }

        $model->enable = $enable;

        return $model->save();
    }

    /**
     * установка значения по умолачанию по id
     *
     * @param $id
     * @throws \yii\db\Exception
     */
    public static function setIsDefaultById($id) {
        $transaction = static::getDb()->beginTransaction();

        self::updateAll([
            'is_default' => 0,
        ]);

        $model = self::findOne(['id' => $id, 'enable' => 1]);

        if(!$model) {
            $transaction->rollBack();
            return false;
        }

        $model->is_default = 1;

        if($model->save()) {
            $transaction->commit();
            return true;
        }
        else {
            $transaction->rollBack();
        }

        return false;
    }
    
    /**
     * вернет выбранный язык по умолчанию
     */
    public static function getDefaultLanguage() {
        $languageCode = \Yii::$app->translate->languageCode;
        
        $model = self::find()
                ->where([
                    'key' => $languageCode,
                ])
                ->one();
        
        if($model) {
            return $model;
        }
        
        //если нет выбранного языка, вернем по умолчанию из базы
        $model = self::find()->getDefault()->one();
        
        return $model;
    }
}