<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 26.02.16
 * Time: 13:34
 */

namespace app\modules\acms\models\form;

use app\models\LinkCredentials;
use app\modules\acms\models\LinkSettings;
use yii\base\Model;
use yii\helpers\Json;

class LinkCredentialsForm extends Model
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'roles' => \Yii::$app->translate->get('acms_roles'),
        ];
    }

    public $roles = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roles'], 'string', 'max' => 255],
        ];
    }

    /**
     * @var LinkSettings
     */
    private $link = null;

    public function __construct(LinkSettings $_link)
    {
        $this->link = $_link;
    }

    public static function getCredentialsParam() {
        return [
            1 => \Yii::$app->translate->get('acms_allow_access'),
            2 => \Yii::$app->translate->get('acms_access_denied'),
            //3 => 'Запретить доступ со вложенными страницами',
        ];
    }

    /**
     * @return LinkSettings
     */
    public function getLink() {
        return $this->link;
    }

    public function save() {
        $listCredentials = Json::decode($this->roles);

        if(is_array($listCredentials) && count($listCredentials) > 0) {

            foreach($listCredentials as $item) {
                if(isset($item['credential_id']) && isset($item['val'])) {
                    LinkCredentials::updateAll([
                        'access' => $item['val'],
                    ], [
                        'id' => $item['credential_id'],
                    ]);
                }
            }
        }

        return true;
    }
}