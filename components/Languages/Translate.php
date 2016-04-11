<?php
namespace app\components\Languages;


use Yii;
use yii\base\Component;
use yii\web\Cookie;

/**
 * (!!только для статики!!)
 * Переводчик статических данных
 *
 * Компонент, который берет переводы из params
 * в зависимости от выбранного языка.
 *
 * В инициализации компонента указывается язык из
 * сессии / или куки / url
 *
 * Class Translate
 * @package app\components\Languages
 */
class Translate extends Component
{
    /**
     * ключ языка в куки
     */
    const TRANSLATE_KEY_LANGUAGE = 'translate_key_language';

    /**
     * время хранения настройки языка в куках
     */
    const DEFAULT_EXPIRE = 31536000;//60*60*24*365;

    /**
     * место, где восстанавливаем язык из куки
     */
    public function init()
    {
        //если язык сохранен в куки
        if($value = \Yii::$app->getRequest()->getCookies()->getValue(self::TRANSLATE_KEY_LANGUAGE)) {
            \Yii::$app->language = $value;
        }
    }

    /**
     * вернет код языка для текущей сессии
     */
    public function getLanguageCode() {
        return \Yii::$app->language;
    }


    /**
     * устанавливаем язык в куки
     *
     * @param $language
     */
    public function setCookieLanguage($language) {
        $cookie = new Cookie([
            'name' => self::TRANSLATE_KEY_LANGUAGE,
            'value' => $language,
            'expire' => time() + self::DEFAULT_EXPIRE,
        ]);
        \Yii::$app->getResponse()->getCookies()->add($cookie);
        \Yii::$app->language = $language;
    }

    /**
     * вернет перевод по ключу
     * для текущего выбранного языка
     *
     * в $replaces передаются шаблоны для замены в строке
     *
     * @param string $key
     * @param array $replaces "передаются шаблоны для замены в строке"
     * @return int|mixed|string
     */
    public function get($key, $replaces = null) {
        if(isset(\Yii::$app->params['translate']) &&
            isset(\Yii::$app->params['translate'][$key]) &&
            isset(\Yii::$app->params['translate'][$key][\Yii::$app->language])) {

                $str = \Yii::$app->params['translate'][$key][\Yii::$app->language];

                //если есть шаблоны для замены в строке
                if(is_array($replaces) && count($replaces) > 0) {
                    foreach($replaces as $key=>$val) {
                        $str = str_replace($key, $val, $str);
                    }
                }

                return $str;
        }

        return $key;
    }
}