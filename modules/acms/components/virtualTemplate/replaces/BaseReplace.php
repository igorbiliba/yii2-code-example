<?php

namespace app\modules\acms\components\virtualTemplate\replaces;

/**
 * базовый класс для подмены контента
 *
 * @author igorb
 */
abstract class BaseReplace {
    /**
     * @var string
     */
    
    protected $html;
    /**
     * @var \app\models\LinkContents
     */
    protected $model;
    
    /**
     * заменяет контент подстновкой
     */
    abstract public function replace();
}
