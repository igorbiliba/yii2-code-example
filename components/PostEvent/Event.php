<?php

namespace app\components\PostEvent;

/**
 * Регистрация почтовых событий
 * 
 * мгновенная, либо отложенная отправка
 */
class Event extends \yii\base\Component {
    /**
     * Добавляем письмо в стек на отправку
     * 
     * @param type $to              "email для отправки"
     * @param type $type_event      "тип события"
     * @param type $params          "переменные в шаблон"
     * @param type $languageCode    "если null, то берем язык из текущей сессии"
     */
    public function push($to, $type_event, $params, $languageCode = null) {        
        //если null, то берем язык из текущей сессии
        if($languageCode == null) {
            $languageCode = \Yii::$app->translate->languageCode;
        }
        
        //если email не верный, не продолжаем
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        //запросим шаблон по типу события
        $template = $this->getTemplate($type_event);
        
        //не существует такого шаблона
        if(!$template) {
            return false;
        }
        
        //запросим мультиязычный шаблон
        $languageTemplate = $template->getLanguageTemplate($languageCode);
        
        //не существует такого мультиязычного шаблона
        if(!$languageTemplate) {
            return false;
        }
        
        $settings = $this->getSettings($languageCode);
        
        //если нет настройки для этого языка
        if(!$settings) {
            return false;
        }
        
        //отрендерим шаблон
        $html = $this->render($languageTemplate, $settings, $params);
        
        //добавим с стек событий
        /**
         * тут проверяем есть ли юзеры, поставленные в копию, на это событие
         * 
         * и обязательно ставим пометку $is_copy
         */
        return $this->addInStack($to, $languageTemplate->subject, $html,
                $template->delay, $languageTemplate->getFromName(),
                $template->getFromEmail($languageCode), $template->content_type,
                $type_event);
    }
    
    /**
     * перевод типа события
     * 
     * @param type $type_event
     * @param type $language
     */
    public function translate($type_event, $language = null) {
        //если null, то берем язык из текущей сессии
        if($languageCode == null) {
            $languageCode = \Yii::$app->translate->languageCode;
        }
        
        $post_events = \Yii::$app->params['post_events'];
        
        //поиск события в параметрах
        if(isset($post_events[$type_event])) {
            if(isset($post_events[$type_event]['title'])) {
                $title = $post_events[$type_event]['title'];                
                if(!empty($title)) {//перевод из списка
                    return \Yii::$app->translate->get($title);
                }
            }
        }
        
        return $type_event;
    }
    
    /**
     * покажет все события с переводами в value
     */
    public function getAll($language = null) {
        $list = [];
        
        $post_events = \Yii::$app->params['post_events'];
        
        if(is_array($post_events)) {
            foreach ($post_events as $key => $value) {
                $list[$key] = $this->translate($key, $language);
            }
        }
        
        return $list;
    }

    /**
     * вернем настройки в по коду языка
     * 
     * @param type $languageCode
     * @return \app\models\PostEventsSettings
     */
    protected function getSettings($languageCode) {        
        return \app\models\PostEventsSettings::getByLanguageKey($languageCode);
    }

    /**
     * загрузим шаблон
     * 
     * @param type $type_event
     * @return \app\models\PostEventsTemplates
     */
    protected function getTemplate($type_event) {
        return \app\models\PostEventsTemplates::find()
            ->active
            ->where([
                'type_event' => $type_event
            ])
            ->andWhere([
                'is_active' => 1,
            ])
            ->one();
    }

    /**
     * отрендерим письмо
     * 
     * @param \app\models\PostEventsTemplatesLanguages $languageTemplate
     * @param type $params
     * @return string
     */
    protected function render(\app\models\PostEventsTemplatesLanguages $languageTemplate,
            \app\models\PostEventsSettings $settings, $params = []) {
        
        //соберем шаблон письма
        $content = $settings->header . $languageTemplate->content . $settings->footer;
        
        //просим у твига перевести в html
        $loader = new \Twig_Loader_String();
        $twig = new \Twig_Environment($loader);
        
        return $twig->loadTemplate($content)->render($params);                
    }
    
    /**
     * добавим в стек, где он 
     * сохранит письмо у себя и решит когда его отправлять.
     * 
     * @param type $email
     * @param type $subject
     * @param type $text
     * @param type $expire
     */
    protected function addInStack($email, $subject, $text, $expire, $from_name, $from_email, $content_type, $type_event, $is_copy = false) {        
        $sender = new \app\models\Sender;
        $sender->email = $email;
        $sender->subject = $subject;
        $sender->text = $text;        
        $sender->expire = $expire+time();
        $sender->is_copy;
        $sender->from_email = $from_email;
        $sender->from_name = $from_name;
        $sender->status = \app\models\Sender::STATUS_WAIT;
        $sender->content_type = $content_type;
        $sender->type_event = $type_event;
        
        $sender->check();        
        return $sender->save();        
    }
}