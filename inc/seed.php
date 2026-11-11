<?php
defined('ABSPATH') || exit;

/**
 * One-time migration SOURCE, not a frontend fallback. The HTML content is a
 * user-provided mockup, not verified facts about the business.
 * Once seeded, all content lives in editable ACF postmeta.
 */
function ameza_seed_source(): array {
    return [
        'hero_title' => 'Носки от производителя AMEZA — качество, проверенное временем',
        'hero_text' => 'Собственное производство полного цикла. Опт от 100 пар. Современные материалы и бесшовная технология.',
        'hero_primary_text' => 'Смотреть продукцию',
        'hero_secondary_text' => 'Получить прайс',
        'hero_features' => [
            ['icon'=>'factory','text'=>'Собственная фабрика'],
            ['icon'=>'check-circle','text'=>'100% контроль качества'],
            ['icon'=>'tags','text'=>'Гибкие условия для опта'],
            ['icon'=>'certificate','text'=>'Сертифицированная продукция'],
        ],
        'advantages_title' => 'Почему выбирают AMEZA',
        'advantages_subtitle' => 'Мы контролируем каждый этап — от отбора сырья до упаковки готовой продукции.',
        'advantages' => [
            ['icon'=>'factory','title'=>'Собственное производство','text'=>'Современное оборудование для бесшовного вязания. Полный цикл на одной площадке.'],
            ['icon'=>'search','title'=>'Контроль качества','text'=>'ОТК на каждом этапе. Предварительная барабанная стирка и сушка сырья.'],
            ['icon'=>'palette','title'=>'Широкий ассортимент','text'=>'Размеры 36–41, более 10 цветов, разная плотность и состав (хлопок, бамбук, шерсть).'],
            ['icon'=>'handshake','title'=>'Гибкие условия для опта','text'=>'Минимальная партия от 100 пар. Персонализация: логотип, упаковка, ароматическое саше.'],
            ['icon'=>'certificate','title'=>'Сертификаты соответствия','text'=>'Вся продукция соответствует стандартам качества. Предоставляем документы по запросу.'],
            ['icon'=>'chart','title'=>'Опыт и объёмы','text'=>'Более 5 000 довольных клиентов. Ежемесячный объём — свыше 10 000 пар.'],
        ],
        'products_title' => 'Ассортимент продукции',
        'products_subtitle' => 'Выберите категорию или запросите индивидуальный дизайн.',
        'products' => [
            ['title'=>'Классические','text'=>'Хлопок 90%, бесшовные, размеры 36–41. Идеальны для повседневной носки.','image_asset'=>'img/product-classic.svg','button_text'=>'Запросить прайс'],
            ['title'=>'Спортивные','text'=>'Усиленная пятка и носок, влагоотводящие волокна. Для активного образа жизни.','image_asset'=>'img/product-sport.svg','button_text'=>'Запросить прайс'],
            ['title'=>'С логотипом на заказ','text'=>'Нанесение вашего логотипа. Персонализированная упаковка. Для корпоративных подарков.','image_asset'=>'img/product-brand.svg','button_text'=>'Узнать цену'],
            ['title'=>'Детские','text'=>'Гипоаллергенные материалы, яркие цвета. Размеры 18–34. Опт от 100 пар.','image_asset'=>'img/product-kids.svg','button_text'=>'Запросить прайс'],
        ],
        'about_title' => 'Собственное производство полного цикла',
        'about_content' => '<p>AMEZA — это не просто бренд. Это фабрика, где рождается забота. Мы контролируем каждый этап: от отбора мягкого китайского хлопка до предварительной барабанной стирки и упаковки.</p><p>Наше оборудование для бесшовного вязания позволяет создавать носки без грубых швов, которые натирают кожу. Мы используем только сертифицированные материалы.</p><p><strong>Если вещь недостаточно хороша для нас самих — она не попадёт в упаковку.</strong></p><p>Ежемесячно мы выпускаем более 10 000 пар носков. Работаем с оптовыми покупателями, маркетплейсами и корпоративными клиентами.</p>',
        'about_caption' => 'Производственный цех AMEZA',
        'b2b_title' => 'Оптовым покупателям',
        'b2b_text' => 'Работаем с магазинами, маркетплейсами (WB, Ozon), корпоративными клиентами и дистрибьюторами.',
        'b2b_bullets' => [
            ['text'=>'Минимальная партия — от 100 пар'],
            ['text'=>'Сроки изготовления — 5–14 дней'],
            ['text'=>'Персонализация: логотип, упаковка, саше'],
            ['text'=>'Гибкая система скидок'],
            ['text'=>'Доставка по России и СНГ'],
        ],
        'b2b_form_title' => 'Получить прайс-лист',
        'reviews_title' => 'Отзывы наших клиентов',
        'reviews_subtitle' => 'Нам доверяют магазины и корпоративные клиенты по всей России.',
        'reviews' => [
            ['quote'=>'Заказываем носки AMEZA для своего магазина уже полгода. Качество стабильно высокое, клиенты возвращаются. Отдельное спасибо за гибкие условия и быструю доставку.','author'=>'Анна Петрова','company'=>'Магазин «Тепло», г. Москва'],
            ['quote'=>'Заказывали корпоративные подарки с логотипом. Всё сделали в срок, упаковка премиальная, сотрудники в восторге. Будем сотрудничать ещё.','author'=>'Дмитрий Соколов','company'=>'ООО «ТехноПром», г. Санкт-Петербург'],
            ['quote'=>'Работаем через маркетплейсы, поставляем носки AMEZA на WB. Бренд хорошо продаётся, возвратов почти нет. Рекомендую как надёжного производителя.','author'=>'Игорь Волков','company'=>'ИП Волков, г. Екатеринбург'],
        ],
        'faq_title' => 'Часто задаваемые вопросы',
        'faq_subtitle' => 'Не нашли ответ? Свяжитесь с нами.',
        'faqs' => [
            ['question'=>'Какая минимальная партия?','answer'=>'Минимальная партия для оптовых покупателей — от 100 пар. Для розничных заказов — от 1 пары (через маркетплейсы).'],
            ['question'=>'Какие сроки производства и доставки?','answer'=>'Срок производства — 5–14 рабочих дней в зависимости от объёма и персонализации. Доставка по России — от 3 до 7 дней.'],
            ['question'=>'Можно ли нанести логотип?','answer'=>'Да, мы предлагаем нанесение логотипа на носки, упаковку и бирки. Возможна разработка индивидуального дизайна.'],
            ['question'=>'Какие материалы вы используете?','answer'=>'Основные материалы: хлопок (90%), бамбук, шерсть, эластан. Вся продукция проходит предварительную стирку и сушку.'],
            ['question'=>'Как получить образцы?','answer'=>'Оставьте заявку на сайте или свяжитесь с нами по телефону. Мы вышлем образцы продукции для ознакомления.'],
        ],
        'contacts_title' => 'Свяжитесь с нами',
        'contacts_subtitle' => 'Оставьте заявку, и мы ответим в течение 15 минут в рабочее время.',
        'contacts_form_title' => 'Оставить заявку',
    ];
}



/**
 * The user explicitly approved complete re-population, including already-filled ACF data.
 * Single version-gated import, never on every page load. Back up existing fields first.
 * This rewrites only fields owned by the AMEZA theme, not other pages or legal documents.
 */
function ameza_rebuild_home_from_html_v4(): void {
    if (!is_admin() || !current_user_can('manage_options') ||
        !function_exists('get_field') || !function_exists('update_field') ||
        get_option('ameza_html_rebuild_v4') === 'complete') {
        return;
    }
    $home_id = absint(get_option('page_on_front'));
    if (!$home_id || get_post_type($home_id) !== 'page') {
        return;
    }

    // Media is already in WordPress; importer at admin_init:15 resolves these IDs.
    // Defer instead of writing empty images when deployment hasn't imported media yet.
    $required = ['hero','production','product','icon-factory','icon-check-circle',
        'icon-tags','icon-certificate','icon-search','icon-palette',
        'icon-handshake','icon-chart','icon-check'];
    $images = [];
    foreach ($required as $key) {
        $id = function_exists('ameza_media_attachment_id') ? ameza_media_attachment_id($key) : 0;
        if (!$id) {
            return;
        }
        $images[$key] = $id;
    }

    $source = ameza_seed_source();
    $source['contacts_info_title'] = 'Контакты';
    $source['hero_image'] = $images['hero'];
    $source['about_image'] = $images['production'];
    foreach ($source['hero_features'] as &$item) {
        $name = (string)($item['icon'] ?? '');
        $item['icon_image'] = $name ? ($images['icon-' . $name] ?? 0) : 0;
        unset($item['icon']);
    }
    unset($item);
    foreach ($source['advantages'] as &$item) {
        $name = (string)($item['icon'] ?? '');
        $item['icon_image'] = $name ? ($images['icon-' . $name] ?? 0) : 0;
        $item['advantage_title'] = (string)($item['title'] ?? '');
        unset($item['icon'], $item['title']);
    }
    unset($item);
    foreach ($source['b2b_bullets'] as &$item) {
        $item['icon_image'] = $images['icon-check'];
    }
    unset($item);
    foreach ($source['products'] as &$item) {
        unset($item['image_asset']);
        $item['product_title'] = (string)($item['title'] ?? '');
        unset($item['title']);
        $item['image'] = $images['product'];
    }
    unset($item);
    foreach ($source['reviews'] as &$item) {
        $item['rating'] = 5;
    }
    unset($item);

    // Existing contacts from the HTML prototype, not verified company information.
    // Never write fake legal identity, INN or OGRN.
    $options = [
        'brand_name' => 'AMEZA',
        'footer_description' => 'Производство и продажа премиальных носков. Опт и розница. Собственная фабрика полного цикла.',
        'phone' => '+7 (495) 123-45-67',
        'email' => 'info@ameza.ru',
        'telegram' => 'https://t.me/ameza_brand',
        'telegram_label' => '@ameza_brand',
        'whatsapp' => 'https://wa.me/74951234567',
        'whatsapp_phone' => '+7 (495) 123-45-67',
        'address' => 'г. Москва, ул. Производственная, д. 10 (офис/склад)',
        'header_cta_text' => 'Оставить заявку',
    ];

    // Snapshot of only the values that are about to be overwritten.
    if (!get_option('ameza_html_rebuild_backup_v4')) {
        $backup = [
            'at' => current_time('mysql'),
            'home_id' => $home_id,
            'post_fields' => [],
            'options' => [],
        ];
        foreach ($source as $key => $value) {
            $backup['post_fields'][$key] = get_field($key, $home_id);
        }
        foreach ($options as $key => $value) {
            $backup['options'][$key] = get_field($key, 'option');
        }
        add_option('ameza_html_rebuild_backup_v4', $backup, '', 'no');
    }

    foreach ($source as $key => $value) {
        update_field('field_ameza_' . $key, $value, $home_id);
    }
    foreach ($options as $key => $value) {
        update_field('field_ameza_' . $key, $value, 'option');
    }

    update_option('ameza_html_rebuild_v4', 'complete', false);
}
add_action('admin_init', 'ameza_rebuild_home_from_html_v4', 65);

function ameza_seed_navigation_menus(): void {
    if (!is_admin() || !current_user_can('manage_options')) { return; }
    if (get_option('ameza_navigation_seeded_v1') === '1') { return; }
    $locations = (array)get_theme_mod('nav_menu_locations', []);
    foreach ([
        'primary' => 'AMEZA — основное меню',
        'footer' => 'AMEZA — меню подвала',
    ] as $location=>$label) {
        if (!empty($locations[$location])) { continue; }
        $menu = wp_get_nav_menu_object($label);
        $menu_id = $menu ? (int)$menu->term_id : wp_create_nav_menu($label);
        if (is_wp_error($menu_id) || !$menu_id) { continue; }
        if (!wp_get_nav_menu_items($menu_id)) {
            foreach ([
                'advantages'=>'Преимущества',
                'assortment'=>'Продукция',
                'about'=>'О производстве',
                'b2b'=>'Опт',
                'contacts'=>'Контакты',
            ] as $anchor=>$title) {
                wp_update_nav_menu_item($menu_id, 0, [
                    'menu-item-title' => $title,
                    'menu-item-url' => home_url('/#' . $anchor),
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'custom',
                ]);
            }
        }
        $locations[$location] = $menu_id;
    }
    set_theme_mod('nav_menu_locations', $locations);
    update_option('ameza_navigation_seeded_v1', '1', false);
}
add_action('admin_init', 'ameza_seed_navigation_menus', 70);


/**
 * One-time upgrade of legacy repeater "title" fields.
 * The old raw postmeta contains the correct titles even if new ACF schema
 * no longer exposes their old subfield names in formatted get_field().
 */
function ameza_migrate_card_titles_v5(): void {
    if (!is_admin() || !current_user_can('manage_options') ||
        !function_exists('get_field') || !function_exists('update_field') ||
        get_option('ameza_card_titles_migrated_v5') === 'complete') {
        return;
    }
    $page_id = absint(get_option('page_on_front', 0));
    if (!$page_id || get_post_type($page_id) !== 'page') {
        return;
    }
    $source = ameza_seed_source();
    foreach ([
        'products' => 'product_title',
        'advantages' => 'advantage_title',
    ] as $group => $new_field) {
        $rows = get_field($group, $page_id);
        if (!is_array($rows) || !$rows) {
            continue;
        }
        $updated = false;
        foreach ($rows as $index => &$row) {
            if (!is_array($row) || trim((string)($row[$new_field] ?? '')) !== '') {
                continue;
            }
            $value = get_post_meta($page_id, $group . '_' . $index . '_title', true);
            if (!is_scalar($value) || trim((string)$value) === '') {
                $value = $source[$group][$index]['title'] ?? '';
            }
            if (is_scalar($value) && trim((string)$value) !== '') {
                $row[$new_field] = trim((string)$value);
                unset($row['title']);
                $updated = true;
            }
        }
        unset($row);
        if ($updated) {
            update_field('field_ameza_' . $group, $rows, $page_id);
        }
    }
    update_option('ameza_card_titles_migrated_v5', 'complete', false);
}
add_action('admin_init', 'ameza_migrate_card_titles_v5', 90);

/**
 * Migrate four legacy social URLs into a single editable ACF repeater.
 * Old "#" placeholders never become clickable URLs.
 */
function ameza_migrate_social_links_v5(): void {
    if (!is_admin() || !current_user_can('manage_options') ||
        !function_exists('get_field') || !function_exists('update_field') ||
        get_option('ameza_social_links_migrated_v5') === 'complete') {
        return;
    }
    $existing = get_field('social_links', 'option');
    if (is_array($existing) && $existing) {
        update_option('ameza_social_links_migrated_v5', 'complete', false);
        return;
    }
    $items = [];
    foreach ([
        'telegram' => 'Telegram',
        'instagram' => 'Instagram',
        'wildberries' => 'Wildberries',
        'ozon' => 'Ozon',
    ] as $key=>$label) {
        $value = get_field($key, 'option');
        if (!is_scalar($value) || $value === '') {
            $value = get_option('options_' . $key, '');
        }
        $url = is_scalar($value) ? trim((string)$value) : '';
        if ($url === '#' || !preg_match('~^https?://~i', $url)) {
            $url = '';
        }
        $items[] = ['label'=>$label, 'url'=>$url];
    }
    update_field('field_ameza_social_links', $items, 'option');
    update_option('ameza_social_links_migrated_v5', 'complete', false);
}
add_action('admin_init', 'ameza_migrate_social_links_v5', 95);
