<?php
namespace app\modules\acms\components\virtualTemplate\replaces;

use app\models\LinkContents;

/**
 * Заменяет одиночные переменные в шаблоне
 *
 * @author igorb
 */
class Variable extends BaseReplace {
    use FreeTemplateTrait;
    
    /**
     * 
     * @param string $html
     * @param LinkContents $model
     */
    public function __construct($html, LinkContents $model) {
        $this->html = $html;
        $this->model = $model;                
    }
    
    /**
     * вернет html
     * 
     * @return string
     */
    public function replace() {
        return str_replace($this->model->getHtmlTemplateKey(),
            self::getFreeContent($this->model), $this->html);
    }
}
