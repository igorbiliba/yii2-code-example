<?php

namespace app\components\render;

/**
 * рендер динамических темплейтов для админки
 * с загрзкой layout
 */
class RenderDynamicTemplate extends \yii\base\Component {   
    const VARIABLE_REGULAR       = '/<!--@[\w]+-->/';
    const VARIABLE_ARRAY_REGULAR = '/<!--@[\w]+[\[\]]+-->/';
    
    /**
     *
     * @var \yii\web\View
     */
    private $view = null;
    
    /**
     * путь к layout
     *
     * @var string
     */
    private $layout = null;

    /**
     * путь к шаблону
     *
     * @var string
     */
    public $template = null;
    
    /**
     * замена блоков для подстановки, если админ
     *
     * @var type 
     */
    private $isAdmin = false;

    /**
     * заносим путь к layout
     * 
     * @param type $layout
     */
    public function __construct($layout = null, $isAdmin = false) {
        //вью для динамисеского рендера
        $this->view = \Yii::$app->getView();
        $this->layout = $layout;       
        $this->isAdmin = $isAdmin;
    }

    /**
     * вернет неоработанный html шаблона
     */
    public function render() {
        $content = '';
        
        if(!empty($this->template)) {
            $content = $this->view->render($this->template);
        }
        
        if(!empty($this->layout)) {
            return $this->view->render($this->layout, [
                'content' => $content,
            ]);
        }
        else {
            return $content;
        }
    }
    
    /**
     * замена одиночных вставок
     * 
     * @param type $list
     * @param type $html
     * @return type
     */
    protected function replaceVariable($list, $html) {        
        return $html;
    }
    
    /**
     * замена множественных вставок
     * 
     * @param type $list
     * @param type $html
     * @return type
     */
    protected function replaceVariableArray($list, $html) {
        return $html;
    }

    /**
     * возвращает переменные из шаблона
     * 
     * @return type
     */
    public function getMatches($html=null) {
        if($html == null) {
            $html = $this->render();
        }
        
        $variables = [];
        $variablesArray = [];
        
        if(preg_match_all(self::VARIABLE_REGULAR, $html, $matches)) {                        
            $variables = $matches;            
        }
        
        if(preg_match_all(self::VARIABLE_ARRAY_REGULAR, $html, $matches)) {                        
            $variablesArray = $matches;
        }
        
        return [
            'variables'      => is_array($variables)      ? end($variables)      : [],
            'variablesArray' => is_array($variablesArray) ? end($variablesArray) : [],
        ];
    }

    /**
     * отдаст имя переменной
     * 
     * @param type $variable
     */
    public static function getName($variable, $is_translate = false) {
        $str = str_replace([
            '<!--@', '-->'
        ], [
            '', ''
        ], $variable);
        
        if($is_translate) {
            $str = \Yii::$app->translate->get($str);
        }
        
        return $str;
    }
    
    /**
     * вернет вид ключа, как он выглядит в шаблоне
     * @param string $key
     */
    public static function getHtmlTemplateKey($key) {
        return '<!--@' . $key . '-->';
    }
}