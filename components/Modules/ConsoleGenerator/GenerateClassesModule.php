<?php

namespace app\components\Modules\ConsoleGenerator;

/**
 * копирует классы из шаблонов
 *
 * Class GenerateClassesModule
 * @package app\components\Modules\ConsoleGenerator
 */
class GenerateClassesModule
{
    /**
     * путь, в какой файл копировать
     *
     * @var string
     */
    private $path = null;

    /**
     * шаблон
     *
     * @var null
     */
    private $template = null;

    /**
     * устанвливаем путь, в какой файл копировать
     *
     * GenerateClassesModule constructor.
     * @param $path
     */
    public function __construct($_path)
    {
        $this->path = $_path;
    }

    /**
     * загружаем шаблон, применяем аргументы
     *
     * @param $path
     * @param $args
     */
    public function loadTempalte($_path, $args=[]) {
        $content = file_get_contents($_path);

        if(is_array($args) && count($args) > 0) {
            foreach($args as $key=>$val) {
                $content = str_replace($key, $val, $content);
            }
        }

        $this->template = $content;

        return $this->template;
    }

    /**
     * генерируем файл
     */
    public function generate() {
        $myfile = fopen($this->path, "w") or die("Unable to open file!");
        fwrite($myfile, $this->template);
        fclose($myfile);
    }
}