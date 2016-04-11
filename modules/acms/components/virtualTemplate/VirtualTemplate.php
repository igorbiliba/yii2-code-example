<?php

namespace app\modules\acms\components\virtualTemplate;

use \app\components\render\RenderDynamicTemplate;

/**
 * Класс делает рендер страницы и подставляет
 * места для добавления виджетов и добавленные
 * виджеты
 *
 * @author igorb
 */
class VirtualTemplate extends RenderDynamicTemplate{
    /**
     * @var \app\models\Links
     */
    private $link = null;
    
    /**
     * возвращает переменные из шаблона
     * 
     * модифицируем их приводя к чистому виду
     * 
     * @return type
     */
    public function getMatches($html = null) {
        $list = [];        
        $matches = parent::getMatches($html);
        
        foreach ($matches as $mk => $mvals) {//обычная переменная/массив
            if(is_array($mvals)) {                            
                foreach ($mvals as $mval) {//ключи переменных                    
                    $list[$mk][self::getName($mval)] = $mval;
                }
            }
        }
        
        return $list;
    }

    /**
     * вернет оработанный html шаблона c подстановками
     */
    public function render() {
        $html = parent::render();
        
        $matches = $this->getMatches($html);
        
        //замена одиночных переменных
        if(isset($matches['variables']) && is_array($matches['variables'])) {
            foreach ($matches['variables'] as $key => $strKey) {
                $variable = new replaces\Variable($html, $this->link->getVariable($key));
                $html = $variable->replace();                
            }            
        }
        
        //замена переменных массива
        if(isset($matches['variablesArray']) && is_array($matches['variablesArray'])) {
            foreach ($matches['variablesArray'] as $key => $strKey) {
                $variables = new replaces\Variables($html, $this->link->getVariable($key));
                $html = $variables->replace();
            }
        }
        
        return $html;
    }

    /**
     * @param \app\models\Links $link
     */
    public function setLink(\app\models\Links $link) {
        $this->link = $link;
    }
}
