<?php
/**
 * AMEZA: structured editable content. No demo values or automatic field defaults.
 * ACF tabs are always vertical (left).
 */
defined('ABSPATH') || exit;

add_filter('acf/settings/save_json', static fn($path) => get_template_directory() . '/acf-json');
add_filter('acf/settings/load_json', static function (array $paths): array {
    $paths[] = get_template_directory() . '/acf-json';
    return array_values(array_unique($paths));
});

function ameza_acf_field(string $name, string $label, string $type = 'text', int $width = 100, array $extra = []): array {
    return array_merge([
        'key' => 'field_ameza_' . $name,
        'name' => $name,
        'label' => $label,
        'type' => $type,
        'wrapper' => ['width' => $width === 100 ? '' : (string)$width],
    ], $extra);
}

function ameza_acf_tab(string $name, string $label): array {
    return ameza_acf_field($name, $label, 'tab', 100, ['placement' => 'left']);
}

function ameza_acf_repeater(string $name, string $label, array $fields, string $layout = 'row'): array {
    foreach ($fields as &$field) {
        $field['key'] = 'field_ameza_' . $name . '_' . $field['name'];
    }
    unset($field);
    return ameza_acf_field($name, $label, 'repeater', 100, [
        'layout' => $layout,
        'button_label' => 'Добавить',
        'sub_fields' => $fields,
    ]);
}

function ameza_acf_image(string $name, string $label, int $width = 100): array {
    return ameza_acf_field($name, $label, 'image', $width, ['return_format' => 'id', 'preview_size' => 'thumbnail']);
}

function ameza_acf_short_text(string $name, string $label, int $width = 50): array {
    return ameza_acf_field($name, $label, 'text', $width);
}

function ameza_acf_intro(string $name, string $label = 'Описание', int $width = 100): array {
    return ameza_acf_field($name, $label, 'textarea', $width, ['rows' => 3, 'new_lines' => '']);
}

add_action('acf/init', static function (): void {
    if (!function_exists('acf_add_options_page') || !function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_options_page([
        'page_title' => 'Настройки AMEZA',
        'menu_title' => 'Настройки сайта',
        'menu_slug' => 'ameza-settings',
        'capability' => 'manage_options',
        'redirect' => false,
        'position' => 3,
        'icon_url' => 'dashicons-store',
    ]);

    acf_add_local_field_group([
        'key' => 'group_ameza_options',
        'title' => 'AMEZA — настройки сайта',
        'fields' => [
            ameza_acf_tab('site_tab_brand', 'Бренд и контакты'),
            ameza_acf_short_text('brand_name', 'Название бренда', 50),
            ameza_acf_image('brand_logo', 'Логотип', 50),
            ameza_acf_intro('footer_description', 'Короткое описание в подвале', 100),
            ameza_acf_short_text('phone', 'Телефон', 50),
            ameza_acf_field('email', 'Email', 'email', 50),
            ameza_acf_field('telegram', 'Telegram (URL)', 'url', 50),
            ameza_acf_field('whatsapp', 'WhatsApp (URL)', 'url', 50),
            ameza_acf_short_text('whatsapp_phone', 'Номер в WhatsApp', 50),
            ameza_acf_short_text('telegram_label', 'Подпись Telegram', 50),
            ameza_acf_short_text('address', 'Адрес', 100),
            ameza_acf_short_text('header_cta_text', 'Текст кнопки в шапке', 50),
            ameza_acf_field('map_url', 'Ссылка на карту', 'url', 50),

            ameza_acf_tab('site_tab_legal', 'Документы и реквизиты'),
            ameza_acf_short_text('company_name', 'Юридическое название', 100),
            ameza_acf_short_text('inn', 'ИНН', 50),
            ameza_acf_short_text('ogrn', 'ОГРН / ОГРНИП', 50),
            ameza_acf_field('offer_page', 'Страница публичной оферты', 'post_object', 50, ['post_type'=>['page'], 'return_format'=>'id', 'allow_null'=>1]),
            ameza_acf_field('consent_page', 'Страница согласия на обработку ПД', 'post_object', 50, ['post_type'=>['page'], 'return_format'=>'id', 'allow_null'=>1]),

            ameza_acf_tab('site_tab_forms', 'Формы Contact Form 7'),
            ameza_acf_short_text('b2b_form_shortcode', 'Шорткод формы прайс-листа', 50),
            ameza_acf_short_text('contacts_form_shortcode', 'Шорткод формы контактов', 50),

            ameza_acf_tab('site_tab_social', 'Соцсети и маркетплейсы'),
            ameza_acf_field('instagram', 'Instagram (URL)', 'url', 50),
            ameza_acf_field('wildberries', 'Wildberries (URL)', 'url', 50),
            ameza_acf_field('ozon', 'Ozon (URL)', 'url', 50),
        ],
        'location' => [[['param'=>'options_page', 'operator'=>'==', 'value'=>'ameza-settings']]],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
    ]);

    acf_add_local_field_group([
        'key' => 'group_ameza_home',
        'title' => 'AMEZA — главная страница',
        'fields' => [
            ameza_acf_tab('home_tab_hero', 'Первый экран'),
            ameza_acf_short_text('hero_title', 'Заголовок H1', 100),
            ameza_acf_intro('hero_text'),
            ameza_acf_image('hero_image', 'Изображение фона', 100),
            ameza_acf_short_text('hero_primary_text', 'Кнопка «Продукция»', 50),
            ameza_acf_short_text('hero_secondary_text', 'Кнопка «Опт»', 50),
            // Three adjacent compact columns per entry instead of big vertical cards.
            ameza_acf_repeater('hero_features', 'Преимущества под кнопками', [
                ameza_acf_image('icon_image', 'Иконка', 35),
                ameza_acf_short_text('text', 'Подпись', 65),
            ], 'table'),

            ameza_acf_tab('home_tab_advantages', 'Преимущества'),
            ameza_acf_short_text('advantages_title', 'Заголовок', 100),
            ameza_acf_intro('advantages_subtitle', 'Подзаголовок'),
            ameza_acf_repeater('advantages', 'Карточки преимуществ', [
                ameza_acf_image('icon_image', 'Иконка', 35),
                ameza_acf_short_text('title', 'Заголовок', 65),
                ameza_acf_intro('text', 'Описание'),
            ]),

            ameza_acf_tab('home_tab_products', 'Продукция'),
            ameza_acf_short_text('products_title', 'Заголовок', 100),
            ameza_acf_intro('products_subtitle', 'Подзаголовок'),
            ameza_acf_repeater('products', 'Карточки продукции', [
                ameza_acf_image('image', 'Фотография', 25),
                ameza_acf_short_text('title', 'Название', 40),
                ameza_acf_short_text('button_text', 'Текст кнопки', 35),
                ameza_acf_intro('text', 'Описание'),
            ]),

            ameza_acf_tab('home_tab_about', 'Производство'),
            ameza_acf_short_text('about_title', 'Заголовок', 100),
            ameza_acf_field('about_content', 'Текст', 'wysiwyg', 100, ['toolbar'=>'basic', 'media_upload'=>false, 'tabs'=>'visual']),
            ameza_acf_image('about_image', 'Фотография производства', 50),
            ameza_acf_short_text('about_caption', 'Подпись к фото', 50),

            ameza_acf_tab('home_tab_b2b', 'Опт'),
            ameza_acf_short_text('b2b_title', 'Заголовок', 100),
            ameza_acf_intro('b2b_text', 'Описание'),
            ameza_acf_repeater('b2b_bullets', 'Условия опта', [
                ameza_acf_image('icon_image', 'Иконка', 30),
                ameza_acf_short_text('text', 'Условие', 70),
            ], 'table'),
            ameza_acf_short_text('b2b_form_title', 'Заголовок формы', 100),

            ameza_acf_tab('home_tab_reviews', 'Отзывы'),
            ameza_acf_short_text('reviews_title', 'Заголовок', 100),
            ameza_acf_intro('reviews_subtitle', 'Подзаголовок'),
            ameza_acf_repeater('reviews', 'Отзывы клиентов', [
                ameza_acf_field('rating', 'Оценка / 5', 'number', 20, ['min'=>1, 'max'=>5, 'step'=>1]),
                ameza_acf_short_text('author', 'Имя', 40),
                ameza_acf_short_text('company', 'Компания / город', 40),
                ameza_acf_intro('quote', 'Текст отзыва'),
            ]),

            ameza_acf_tab('home_tab_faq', 'Вопросы и ответы'),
            ameza_acf_short_text('faq_title', 'Заголовок', 100),
            ameza_acf_short_text('faq_subtitle', 'Подзаголовок', 100),
            ameza_acf_repeater('faqs', 'FAQ', [
                ameza_acf_short_text('question', 'Вопрос', 45),
                ameza_acf_intro('answer', 'Ответ', 55),
            ], 'table'),

            ameza_acf_tab('home_tab_contacts', 'Контакты'),
            ameza_acf_short_text('contacts_title', 'Заголовок', 100),
            ameza_acf_intro('contacts_subtitle', 'Подзаголовок'),
            ameza_acf_short_text('contacts_info_title', 'Заголовок над контактами', 50),
            ameza_acf_short_text('contacts_form_title', 'Заголовок формы', 50),
        ],
        'location' => [[['param'=>'page_type', 'operator'=>'==', 'value'=>'front_page']]],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
    ]);
});
