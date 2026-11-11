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
 * One-time content migration for the currently assigned homepage.
 * Only fills empty fields, never overwrites nonempty fields.
 * Existing ACF repeater rows are migrated in place to media-image icons.
 */
function ameza_seed_landing_content(): void {
    if (!is_admin() || !current_user_can('manage_options') ||
        !function_exists('update_field') || !function_exists('get_field')) {
        return;
    }
    $home_id = (int)get_option('page_on_front', 0);
    if (!$home_id || get_post_type($home_id) !== 'page') {
        return;
    }

    $source = ameza_seed_source();
    $source['contacts_info_title'] = 'Контакты';
    $source['hero_image'] = ameza_media_attachment_id('hero');
    $source['about_image'] = ameza_media_attachment_id('production');
    $source['products'] = array_map(static function (array $row): array {
        unset($row['image_asset']);
        $row['image'] = ameza_media_attachment_id('product');
        return $row;
    }, $source['products']);

    foreach (['hero_features', 'advantages'] as $key) {
        foreach ($source[$key] as &$row) {
            $icon = (string)($row['icon'] ?? '');
            $row['icon_image'] = $icon !== '' ? ameza_media_attachment_id('icon-' . $icon) : 0;
            unset($row['icon']);
        }
        unset($row);
    }
    foreach ($source['b2b_bullets'] as &$row) {
        $row['icon_image'] = ameza_media_attachment_id('icon-check');
    }
    unset($row);
    foreach ($source['reviews'] as &$row) {
        $row['rating'] = 5;
    }
    unset($row);

    // Text and list migration only once. Keeps changes the editor has already made.
    if (get_option('ameza_landing_content_seeded_v3') !== '1') {
        foreach ($source as $name => $value) {
            $existing = get_field($name, $home_id);
            if ($existing !== null && $existing !== false && $existing !== '' && $existing !== []) {
                continue;
            }
            // Media fields are handled below after the image importer has finished.
            if (in_array($name, ['hero_image', 'about_image'], true)) {
                continue;
            }
            update_field('field_ameza_' . $name, $value, $home_id);
        }
        $options = [
            'brand_name' => 'AMEZA',
            'footer_description' => 'Производство и продажа премиальных носков. Опт и розница. Собственная фабрика полного цикла.',
            'phone' => '+7 (495) 123-45-67',
            'email' => 'info@ameza.ru',
            'telegram' => 'https://t.me/ameza_brand',
            'whatsapp' => 'https://wa.me/74951234567',
            'address' => 'г. Москва, ул. Производственная, д. 10 (офис/склад)',
            'header_cta_text' => 'Оставить заявку',
        ];
        foreach ($options as $name => $value) {
            if (!get_field($name, 'option')) {
                update_field('field_ameza_' . $name, $value, 'option');
            }
        }
        update_option('ameza_landing_content_seeded_v3', '1', false);
    }

    // Migrate pre-existing repeater rows once. Never re-add an icon or rating
    // the editor intentionally cleared after this upgrade.
    if (get_option('ameza_landing_repeaters_migrated_v3') !== '1') {
    foreach (['hero_features','advantages','b2b_bullets','reviews'] as $key) {
        $rows = get_field($key, $home_id);
        if (!is_array($rows)) {
            continue;
        }
        $changed = false;
        foreach ($rows as $i => &$row) {
            if (!is_array($row)) {
                continue;
            }
            if ($key === 'reviews') {
                $match = $source[$key][$i] ?? [];
                if (empty($row['rating']) && ($row['author'] ?? '') === ($match['author'] ?? null)) {
                    $row['rating'] = 5;
                    $changed = true;
                }
                continue;
            }
            $expected = $source[$key][$i] ?? null;
            $match_field = $key === 'advantages' ? 'title' : 'text';
            if (!$expected || ($row[$match_field] ?? '') !== ($expected[$match_field] ?? null)) {
                continue;
            }
            if (empty($row['icon_image'])) {
                $original_icon = $key === 'b2b_bullets' ? 'check' :
                    (string)(ameza_seed_original_icon($key, $i));
                $id = ameza_media_attachment_id('icon-' . $original_icon);
                if ($id) {
                    $row['icon_image'] = $id;
                    $changed = true;
                }
            }
        }
        unset($row);
        if ($changed) {
            update_field('field_ameza_' . $key, $rows, $home_id);
        }
    }

    if (ameza_media_attachment_id('icon-factory') && ameza_media_attachment_id('icon-check')) {
        update_option('ameza_landing_repeaters_migrated_v3', '1', false);
    }
    }

    // Retry until the media importer has completed. Do not change already chosen pictures.
    $images_ready = true;
    foreach (['hero_image'=>'hero','about_image'=>'production'] as $field=>$media) {
        $id = ameza_media_attachment_id($media);
        if (!$id) {
            $images_ready = false;
            continue;
        }
        if (!get_field($field, $home_id) && get_option('ameza_landing_media_seeded_v3') !== '1') {
            update_field('field_ameza_' . $field, $id, $home_id);
        }
    }
    $product_image = ameza_media_attachment_id('product');
    if (!$product_image) {
        $images_ready = false;
    } elseif (get_option('ameza_landing_media_seeded_v3') !== '1') {
        $products = get_field('products', $home_id);
        if (is_array($products)) {
            $changed = false;
            foreach ($products as $i=>&$row) {
                if (is_array($row) && empty($row['image']) &&
                    ($row['title']??'') === ($source['products'][$i]['title']??null)) {
                    $row['image'] = $product_image;
                    $changed = true;
                }
            }
            unset($row);
            if ($changed) {
                update_field('field_ameza_products', $products, $home_id);
            }
        }
    }
    if ($images_ready) {
        update_option('ameza_landing_media_seeded_v3', '1', false);
    }
}
add_action('admin_init', 'ameza_seed_landing_content', 65);

/** Legacy icon mapping only for upgrading rows copied from the original mockup. */
function ameza_seed_original_icon(string $group, int $index): string {
    $icons = [
        'hero_features' => ['factory','check-circle','tags','certificate'],
        'advantages' => ['factory','search','palette','handshake','certificate','chart'],
        'b2b_bullets' => ['check','check','check','check','check'],
    ];
    return (string)($icons[$group][$index] ?? '');
}

/**
 * Create two editable navigation menus when the site's respective location is empty.
 * Do not alter a menu that the site administrator has already assigned.
 */
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
