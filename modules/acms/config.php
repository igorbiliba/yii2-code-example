<?php
return [
    'components' => [
        'urlManager' => [
            'rules' => [

            ],
        ],
    ],
    'params' => [
        //статические переводы
        //\Yii::$app->translate->get('')
        'translate' => [
            'acms_hello' => [
                'ru-RU' => 'Привет!',
                'en-EN' => 'Hello!',
            ],
            'acms_success' => [
                'ru-RU' => 'Успешно!',
            ],
            'acms_error' => [
                'ru-RU' => 'Не удачно!',
            ],
            'acms_success_add_language' => [
                'ru-RU' => 'Язык успешно добавлен',
            ],
            'acms_error_on_add_language' => [
                'ru-RU' => 'Ошибка при добавлении языка',
            ],
            'acms_module_is_install' => [
                'ru-RU' => 'Модуль установлен',
            ],
            'acms_module_is_not_install' => [
                'ru-RU' => 'Модуль не установлен',
            ],
            'acms_module_is_delete' => [
                'ru-RU' => 'Модуль удален',
            ],
            'acms_module_is_not_delete' => [
                'ru-RU' => 'Модуль удален',
            ],
            'acms_module_is_delete_in_filesystem' => [
                'ru-RU' => 'Модуль удален из фаловой системы',
            ],
            'acms_module_is_not_delete_in_filesystem' => [
                'ru-RU' => 'Модуль не удален из фаловой системы',
            ],
            'acms_module_is_generated' => [
                'ru-RU' => 'Модуль {module_name} сгенерирован',
            ],
            'acms_content_block_successfully_added' => [
                'ru-RU' => 'Контентный блок успешно добавлен.',
            ],
            'acms_edit_successfully_saved' => [
                'ru-RU' => 'Изменения успешно сохранены.',
            ],
            'acms_error_edit_default_language' => [
                'ru-RU' => 'Нельзя деактивировать язык по умолчанию!',
            ],
            'acms_add_language' => [
                'ru-RU' => 'Добавить язык:',
            ],
            'acms_is_active' => [
                'ru-RU' => 'Активен',
            ],
            'acms_is_not_active' => [
                'ru-RU' => 'Не активен',
            ],
            'acms_the_activation' => [
                'ru-RU' => 'Активация'
            ],
            'acms_is_deactivate' => [
                'ru-RU' => 'Деактивировать',
            ],
            'acms_is_activate' => [
                'ru-RU' => 'Активировать',
            ],
            'acms_selected_by_default' => [
                'ru-RU' => 'Выбран по умолчанию',
            ],
            'acms_select_by_default' => [
                'ru-RU' => 'Выбрать по умолчанию',
            ],
            'acms_generate' => [
                'ru-RU' => 'Сгенерировать',
            ],
            'acms_view_installed_widgets' => [
                'ru-RU' => 'Просмотр установленных виджетов',
            ],
            'acms_generation_module' => [
                'ru-RU' => 'Генерация модуля',
            ],
            'acms_installed' => [
                'ru-RU' => 'Установлен',
            ],
            'acms_not_installed' => [
                'ru-RU' => 'Не установлен'
            ],
            'acms_not_installed' => [
                'ru-RU' => 'Не установлен'
            ],
            'acms_is_not_valid' => [
                'ru-RU' => 'Поврежден'
            ],
            'acms_installation_process' => [
                'ru-RU' => 'Установка'
            ],
            'acms_is_installed' => [
                'ru-RU' => 'Установлен'
            ],
            'acms_is_reinstalled' => [
                'ru-RU' => 'Требует переустановки'
            ],
            'acms_to_install' => [
                'ru-RU' => 'Установить'
            ],
            'acms_if_install_module' => [
                'ru-RU' => 'Установить модуль?'
            ],
            'acms_delete' => [
                'ru-RU' => 'Удаление'
            ],
            'acms_if_delete_module' => [
                'ru-RU' => 'Удалить модуль?'
            ],
            'acms_to_delete' => [
                'ru-RU' => 'Удалить'
            ],
            'acms_to_delete_by_filesystem' => [
                'ru-RU' => 'Удалить из фаловой системы'
            ],
            'acms_if_delete_by_filesystem_module' => [
                'ru-RU' => 'Удалить из фаловой системы модуль?'
            ],
            'acms_if_delete_content_block' => [
                'ru-RU' => 'Удалить контентный блок?'
            ],
            'acms_for_edit_content_block' => [
                'ru-RU' => 'Редактирование контентного блока'
            ],
            'acms_for_add_content_block' => [
                'ru-RU' => 'Добавление контентного блока'
            ],
            'acms_edit' => [
                'ru-RU' => 'Изменить'
            ],
            'acms_add' => [
                'ru-RU' => 'Добавить'
            ],
            'acms_settings_access' => [
                'ru-RU' => 'Настройки доступа'
            ],
            'acms_contents_blocks_pages' => [
                'ru-RU' => 'Блоки страницы'
            ],
            'acms_language_settings' => [
                'ru-RU' => 'Языковые настройки'
            ],
            'acms_close' => [
                'ru-RU' => 'Закрыть'
            ],
            'acms_full_settings' => [
                'ru-RU' => 'Общие настройки'
            ],
            'acms_allow_access' => [
                'ru-RU' => 'Разрешить доступ'
            ],
            'acms_access_denied' => [
                'ru-RU' => 'Запретить доступ'
            ],
            'acms_roles' => [
                'ru-RU' => 'Роли'
            ],
            'acms_input_module_name' => [
                'ru-RU' => 'Введите название модуля!'
            ],
            'acms_only_latin_word_and_somechar' => [
                'ru-RU' => 'Только латинские буквы и подчеркивание'
            ],            
            'acms_module_name' => [
                'ru-RU' => 'Название модуля'
            ],
            'acms_widget_name' => [
                'ru-RU' => 'Название виджета'
            ],
            'acms_widget' => [
                'ru-RU' => 'Виджет'
            ],
            'acms_html' => [
                'ru-RU' => 'Html'
            ],
            'acms_text' => [
                'ru-RU' => 'Текст'
            ],
            'acms_image' => [
                'ru-RU' => 'Изображение'
            ],
            'acms_other' => [
                'ru-RU' => 'Прочее'
            ],
            'acms_allow_validation_rules_only_type_0' => [
                'ru-RU' => 'Pазрешаеся только латинские буквы, цифры и \\'
            ],
            'acms_allow_validation_rules_only_type_1' => [
                'ru-RU' => 'Pазрешаеся только буквы, цифры, -, и /'
            ],
            'acms_action' => [
                'ru-RU' => 'Действие'
            ],
            'acms_status' => [
                'ru-RU' => 'Статус'
            ],
            'acms_only_char_and_numbers' => [
                'ru-RU' => 'Только буквы и цифры!'
            ],
            'acms_select_from_tree' => [
                'ru-RU' => 'Поиск по модулям:'
            ],
            'acms_install_module_in_menu' => [
                'ru-RU' => 'Установка модулей'
            ],
            'acms_post_params_for_lang_is_updated' => [
                'ru-RU' => 'Параметры для языка {lang} успешно изменены!'
            ],            
            'acms_is_default_email' => [
                'ru-RU' => 'E-Mail по умолчанию ({email})'
            ],  
            'acms_create_post_events_templates' => [
                'ru-RU' => 'Добавить новый шаблон'
            ],  
            'acms_module_reinstall_is_not_need' => [
                'ru-RU' => 'Переустановка модуля не требудется'
            ],  
            'acms_module_is_not_reinstall' => [
                'ru-RU' => 'Модуль не переустановлен'
            ],  
            'acms_module_is_reinstall' => [
                'ru-RU' => 'Модуль переустановлен',
            ],  
            'acms_params' => [
                'ru-RU' => 'Параметры'
            ], 
            'acms_no_delay' => [
                'ru-RU' => 'Да'
            ], 
            'acms_n_min_delay' => [
                'ru-RU' => 'Задержка {n} мин.'
            ], 
            'acms_menu' => [
                'ru-RU' => 'Меню'
            ], 
            'acms_create' => [
                'ru-RU' => 'Создать'
            ], 
            'acms_type' => [
                'ru-RU' => 'Тип'
            ], 
            'acms_name' => [
                'ru-RU' => 'Название'
            ], 
            'acms_yes' => [
                'ru-RU' => 'Да'
            ], 
            'acms_no' => [
                'ru-RU' => 'Нет'
            ], 
            'acms_struckt_site' => [
                'ru-RU' => 'Структура сайта'
            ],
            'acms_struckt_menu' => [
                'ru-RU' => 'Структура меню'
            ],
            'acms_the_setup_menu' => [
                'ru-RU' => 'Установка меню'
            ],            
            'acms_template' => [
                'ru-RU' => 'Шаблон'
            ],            
            'acms_select_menu' => [
                'ru-RU' => 'Выбор меню'
            ],
            'acms_settings_menu_layout' => [
                'ru-RU' => 'Настройка меню в макетах'
            ],
            'acms_add_new_block' => [
                'ru-RU' => 'Добавить новый блок'
            ],
            'acms_images_for_adapty' => [
                'ru-RU' => 'Изображения для адаптивности',
            ],
            'acms_size' => [
                'ru-RU' => 'Размер',
            ],
            'acms_align' => [
                'ru-RU' => 'Выравнивание',
            ],
            'acms_save' => [
                'ru-RU' => 'Сохранить',
            ],
            'acms_add_text_page' => [
                'ru-RU' => 'Добавить текстовую страницу',
            ],
            'acms_add_content_block' => [
                'ru-RU' => 'Добавить контентный блок',
            ],            
            'acms_adapty_for' => [
                'ru-RU' => 'Адаптивность для',
            ],
            'CONTENT_BLOCK' => [
                'ru-RU' => 'Контентные боки',
            ],
            'TEXT_PAGE' => [
                'ru-RU' => 'Текстовые страницы',
            ],
            'acms_width' => [
                'ru-RU' => 'Ширина',
            ],
            'acms_height' => [
                'ru-RU' => 'Высота',
            ],
            'acms_min_width' => [
                'ru-RU' => 'Минимальная ширина',
            ],
            'acms_if_delete_size' => [
                'ru-RU' => 'Удалить разрешение {name}?',
            ],
            'acms_size_success' => [
                'ru-RU' => 'Разрешение {name} успешно добавлено',
            ],
            'acms_size_error' => [
                'ru-RU' => 'Ошибка при добавлении разрешения',
            ],
            'acms_add_size' => [
                'ru-RU' => 'Добавить разрешение:',
            ],
            'acms_all_sizes' => [
                'ru-RU' => 'Все разрешения:',
            ],
            'acms_button_edit_adapty_imgs' => [
                'ru-RU' => 'Редактировать разрешения адаптивности',
            ],
            'acms_set_layout_default' => [
                'ru-RU' => 'Установить по умолчанию при создании страницы',
            ],
            'acms_clear_block' => [
                'ru-RU' => 'Очистить блок',
            ],
        ],
    ],
];