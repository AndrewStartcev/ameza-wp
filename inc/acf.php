<?php
defined('ABSPATH') || exit;
add_filter('acf/settings/save_json', static fn($path) => get_template_directory() . '/acf-json');
add_filter('acf/settings/load_json', static function (array $paths): array {
    $paths[] = get_template_directory() . '/acf-json';
    return array_values(array_unique($paths));
});
function ameza_acf_simple(string $name, string $label, string $type = 'text', array $extra = []): array {
    return array_merge(['key'=>'field_ameza_' . $name,'name'=>$name,'label'=>$label,'type'=>$type], $extra);
}
function ameza_acf_tab(string $name, string $label): array {
    return ameza_acf_simple($name, $label, 'tab', ['placement'=>'top']);
}
function ameza_acf_repeater(string $name, string $label, array $sub, array $extra = []): array {
    return ameza_acf_simple($name,$label,'repeater',array_merge(['layout'=>'block','button_label'=>'Добавить запись','sub_fields'=>$sub],$extra));
}
function ameza_acf_icon(): array {
    $icons=['factory'=>'Производство','check-circle'=>'Качество','tags'=>'Цены','certificate'=>'Сертификат','search'=>'Лупа','palette'=>'Ассортимент','handshake'=>'Рукопожатие','chart'=>'График','check'=>'Галочка','star'=>'Звезда'];
    return ameza_acf_simple('icon','Иконка','select',['choices'=>$icons,'default_value'=>'check-circle','ui'=>1]);
}
add_action('acf/init', static function (): void {
    if (!function_exists('acf_add_options_page') || !function_exists('acf_add_local_field_group')) { return; }
    acf_add_options_page([
        'page_title'=>'Настройки AMEZA','menu_title'=>'Настройки сайта','menu_slug'=>'ameza-settings',
        'capability'=>'manage_options','redirect'=>false,'position'=>3,'icon_url'=>'dashicons-store',
    ]);
    acf_add_local_field_group([
        'key'=>'group_ameza_options','title'=>'AMEZA — глобальные настройки',
        'fields'=>[
            ameza_acf_tab('site_tab_brand','Бренд и контакты'),
            ameza_acf_simple('brand_name','Текст логотипа','text',['default_value'=>'AMEZA']),
            ameza_acf_simple('brand_logo','Логотип (изображение)','image',['return_format'=>'id','preview_size'=>'medium']),
            ameza_acf_simple('footer_description','Описание в подвале','textarea',['rows'=>3,'default_value'=>'Производство и продажа премиальных носков. Опт и розница. Собственная фабрика полного цикла.']),
            ameza_acf_simple('phone','Телефон','text',['instructions'=>'В HTML-прототипе указан демонстрационный номер; перед запуском замени на реальный.','default_value'=>'+7 (495) 123-45-67']),
            ameza_acf_simple('email','Email','email',['default_value'=>'info@ameza.ru']),
            ameza_acf_simple('telegram','Telegram (https://t.me/...)','url',['default_value'=>'https://t.me/ameza_brand']),
            ameza_acf_simple('whatsapp','WhatsApp (https://wa.me/...)','url',['default_value'=>'https://wa.me/74951234567']),
            ameza_acf_simple('address','Адрес','text',['default_value'=>'г. Москва, ул. Производственная, д. 10 (офис/склад)']),
            ameza_acf_tab('site_tab_legal','Документы и реквизиты'),
            ameza_acf_simple('company_name','Юридическое название'),
            ameza_acf_simple('inn','ИНН'),
            ameza_acf_simple('ogrn','ОГРН'),
            ameza_acf_simple('offer_page','Страница публичной оферты','post_object',['post_type'=>['page'],'return_format'=>'id','allow_null'=>1]),
            ameza_acf_simple('consent_page','Страница согласия на обработку ПД','post_object',['post_type'=>['page'],'return_format'=>'id','allow_null'=>1]),
            ameza_acf_tab('site_tab_forms','Формы Contact Form 7'),
            ameza_acf_simple('b2b_form_shortcode','Шорткод формы прайс-листа','text',['instructions'=>'Например: [contact-form-7 id="123" title="Прайс-лист"]']),
            ameza_acf_simple('contacts_form_shortcode','Шорткод формы контактов','text',['instructions'=>'Например: [contact-form-7 id="124" title="Контакты"]']),
            ameza_acf_tab('site_tab_social','Дополнительные ссылки'),
            ameza_acf_simple('wildberries','Ссылка Wildberries','url'),
            ameza_acf_simple('ozon','Ссылка Ozon','url'),
        ],
        'location'=>[[['param'=>'options_page','operator'=>'==','value'=>'ameza-settings']]],
        'menu_order'=>0,'position'=>'normal','style'=>'default','label_placement'=>'top',
    ]);
    acf_add_local_field_group([
        'key'=>'group_ameza_home','title'=>'AMEZA — главная страница',
        'fields'=>[
            ameza_acf_tab('home_tab_hero','Первый экран'),
            ameza_acf_simple('hero_title','Заголовок H1'),
            ameza_acf_simple('hero_text','Описание','textarea',['rows'=>3]),
            ameza_acf_simple('hero_image','Фоновая фотография','image',['return_format'=>'id','preview_size'=>'medium']),
            ameza_acf_simple('hero_primary_text','Первая кнопка'),
            ameza_acf_simple('hero_secondary_text','Вторая кнопка'),
            ameza_acf_repeater('hero_features','Преимущества под кнопками',[
                ameza_acf_icon(),ameza_acf_simple('text','Подпись')
            ]),
            ameza_acf_tab('home_tab_advantages','Преимущества'),
            ameza_acf_simple('advantages_title','Заголовок'),
            ameza_acf_simple('advantages_subtitle','Подзаголовок','textarea',['rows'=>2]),
            ameza_acf_repeater('advantages','Карточки',[
                ameza_acf_icon(),ameza_acf_simple('title','Заголовок'),ameza_acf_simple('text','Описание','textarea',['rows'=>3])
            ]),
            ameza_acf_tab('home_tab_products','Продукция'),
            ameza_acf_simple('products_title','Заголовок'),
            ameza_acf_simple('products_subtitle','Подзаголовок','textarea',['rows'=>2]),
            ameza_acf_repeater('products','Карточки продукции',[
                ameza_acf_simple('image','Фотография','image',['return_format'=>'id']),
                ameza_acf_simple('title','Название'),
                ameza_acf_simple('text','Описание','textarea',['rows'=>3]),
                ameza_acf_simple('button_text','Текст кнопки'),
            ]),
            ameza_acf_tab('home_tab_about','Производство'),
            ameza_acf_simple('about_title','Заголовок'),
            ameza_acf_simple('about_content','Текст','wysiwyg',['toolbar'=>'basic','media_upload'=>false]),
            ameza_acf_simple('about_image','Фотография производства','image',['return_format'=>'id']),
            ameza_acf_simple('about_caption','Подпись'),
            ameza_acf_tab('home_tab_b2b','Опт'),
            ameza_acf_simple('b2b_title','Заголовок'),
            ameza_acf_simple('b2b_text','Описание','textarea',['rows'=>3]),
            ameza_acf_repeater('b2b_bullets','Условия опта',[ameza_acf_simple('text','Пункт')]),
            ameza_acf_simple('b2b_form_title','Заголовок формы'),
            ameza_acf_tab('home_tab_reviews','Отзывы'),
            ameza_acf_simple('reviews_title','Заголовок'),
            ameza_acf_simple('reviews_subtitle','Подзаголовок','textarea',['rows'=>2]),
            ameza_acf_repeater('reviews','Отзывы',[
                ameza_acf_simple('quote','Отзыв','textarea',['rows'=>4]),
                ameza_acf_simple('author','Автор'),
                ameza_acf_simple('company','Компания'),
            ]),
            ameza_acf_tab('home_tab_faq','Вопросы и ответы'),
            ameza_acf_simple('faq_title','Заголовок'),
            ameza_acf_simple('faq_subtitle','Подзаголовок'),
            ameza_acf_repeater('faqs','Вопросы',[
                ameza_acf_simple('question','Вопрос'),
                ameza_acf_simple('answer','Ответ','textarea',['rows'=>3]),
            ]),
            ameza_acf_tab('home_tab_contacts','Контакты'),
            ameza_acf_simple('contacts_title','Заголовок'),
            ameza_acf_simple('contacts_subtitle','Подзаголовок','textarea',['rows'=>2]),
            ameza_acf_simple('contacts_form_title','Заголовок формы'),
        ],
        'location'=>[[['param'=>'page_type','operator'=>'==','value'=>'front_page']]],
        'menu_order'=>0,'position'=>'normal','style'=>'default','label_placement'=>'top',
    ]);
});
