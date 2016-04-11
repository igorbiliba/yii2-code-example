<?php

namespace app\modules\acms\models\modelform;

use app\components\Modules\ConsoleGenerator\AcsmGeneratorModule;
use Yii;
use yii\base\Model;

/**
 * форма для валидации при генерации модуля
 *
 * Class ModuleGeneratorForm
 * @package app\modules\acms\models\modelform
 */
class ModuleGeneratorForm extends Model
{
    /**
     * Имя модуля
     *
     * @var string
     */
    public $name;

    /**
     * Имя втджета
     *
     * @var string
     */
    public $widget_name;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name'], 'required' , 'message' => \Yii::$app->translate->get('acms_input_module_name')],
            [['widget_name', 'name'], 'string', 'max' => 63],
            [['widget_name', 'name'], 'match', 'pattern' => '/^[a-zA-Z_]+$/', 'message' =>  \Yii::$app->translate->get('acms_only_latin_word_and_somechar')],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => \Yii::$app->translate->get('acms_module_name'),
            'widget_name' => \Yii::$app->translate->get('acms_widget_name'),
        ];
    }

    public function generate()
    {
        //класс генерации
        $moduleGenerator = new AcsmGeneratorModule($this->name, $this->widget_name);
        //создание скилета
        $moduleGenerator->giiGenerateModule();
        //создание дирректории assets
        $moduleGenerator->createAssetsDir();
        //создание дирректории для миграций
        $moduleGenerator->createMigrationsDir();
        /**
         * создание дирректории компонентов
         * создание виджетов
         * создание файла сценария установки
         */
        $moduleGenerator->createComponentsScope();
        //генерация инструкции установки
        $moduleGenerator->createInstallFile();

        return true;
    }
}
