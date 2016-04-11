<?php
return [
    'components' => [
        'urlManager' => [
            'rules' => [
                '/acms/modules/module_one/settings/index' => '/module_one/settings/index',
            ],
        ],
    ],
    'params' => [
        /*'post_events' => [//список почтовых событий
            'module_one_registration' => [//тип события
                'variables' => [//переменные в шаблон
                    'username',
                    'login',
                ],
                'title' => 'module_one_post_event_registration'//имя для мультиязычности
            ],
        ],*/
        //статические переводы
        'translate' => [
            'module_one' => [
                'ru-RU' => 'Мой модуль',
            ],
            'module_one_widget_one' => [
                'ru-RU' => 'Мой виджет',
            ],
            'module_one_settings' => [
                'ru-RU' => 'Настройки',
            ],
        ],
    ],
];