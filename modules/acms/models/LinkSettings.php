<?php
/**
 * Created by PhpStorm.
 * User: igorb
 * Date: 26.02.16
 * Time: 09:46
 */

namespace app\modules\acms\models;


use app\models\Languages;
use app\models\LinkCredentials;
use app\models\LinkLanguages;
use app\models\Links;
use app\models\Roles;
use yii\base\Exception;
use yii\rbac\Role;

class LinkSettings extends Links
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['show_in_menu', 'show_in_breadcrumbs', 'is_serch'], 'integer'],
            [['redirect_link'], 'string', 'max' => 255],
            [['action', 'template', 'layout'], 'string', 'max' => 127],
            [['action'], 'match', 'pattern' => '/^[a-zA-Z0-9\\\]+$/', 'message' => \Yii::$app->translate->get('acms_allow_validation_rules_only_type_0')],
            [['redirect_link'], 'match', 'pattern' => '/^[a-zA-Zа-яА-Я0-9\-\/]+$/', 'message' => \Yii::$app->translate->get('acms_allow_validation_rules_only_type_1')],
        ];
    }

    /**
     * Возвращает разрешения для этого урла,
     * если нужно, то досоздает недостающие
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAllCredentials() {
        $list = $this->getLinkCredentials()->all();

        //ищем недостающие
        $rolesQuery = Roles::find();

        foreach($list as $credential) {
            /* @var \app\models\LinkCredentials $credential */
            $rolesQuery->andWhere('id <> :id_role', [
                ':id_role' => $credential->role_id,
            ]);
        }

        //добавляем недостающие настройки
        $addRoles = $rolesQuery->all();

        //если недостающих настроек нету, возвращем найденные
        if(count($addRoles) == 0) {
            return $list;
        }
        else {
            foreach ($addRoles as $addRole) {
                /* @var \app\models\Roles $addRole */
                $credential = new LinkCredentials();
                $credential->role_id = $addRole->id;
                $credential->link_id = $this->id;

                $credential->save();
            }
        }

        return $this->getLinkCredentials()->all();
    }

    /**
     * Возвращает языковые настройки для этой страницы.
     * если настройки нет, а язык актуален, то настройка создается сама
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getLinkLanguagesAll() {
        //доступные настройки
        $all = $this->getLinkLanguages()->all();

        //активные языки на добавление, в случае отсутствия
        $otherLanguagesQuery = Languages::find()->active();
        foreach($all as $item) {
            $otherLanguagesQuery
                ->andWhere('id <> :id_lang', [
                    ':id_lang' => $item->language_id,
                ]);
        }

        //не добавленные языки
        $otherLanguages = $otherLanguagesQuery->all();

        if(count($otherLanguages) > 0) {
            //языки, которые трубуется добавить
            foreach($otherLanguages as $item) {
                try {
                    $newLinkLanguage = new LinkLanguages();
                    $newLinkLanguage->link_id = $this->id;
                    $newLinkLanguage->language_id = $item->id;

                    $newLinkLanguage->save();
                }
                catch(Exception $e) {
                    //если что-то не добавилось, значит оно уже есть.
                }
            }

            return $this->getLinkLanguages()->all();
        }

        return $all;
    }
}