<?php
/**
 * Idempotent page provisioning.
 * Legal pages are created as drafts. Their actual legal wording must be approved.
 */
defined('ABSPATH') || exit;

function ameza_ensure_page(string $slug, string $title, string $status): array {
    $found = get_page_by_path($slug, OBJECT, 'page');
    if ($found instanceof WP_Post && $found->post_status !== 'trash') {
        return [(int)$found->ID, false];
    }
    $id = wp_insert_post([
        'post_type' => 'page',
        'post_status' => $status,
        'post_name' => $slug,
        'post_title' => $title,
        'post_content' => '',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
    ], true);
    return is_wp_error($id) ? [0, false] : [(int)$id, true];
}

function ameza_seed_home_fields(int $home_id): void {
    if (!$home_id || !function_exists('update_field')) { return; }
    $seeded = absint(get_option('ameza_home_fields_seeded', 0));
    if ($seeded === $home_id) { return; }

    $defaults = ameza_defaults();
    $product_id = ameza_media_attachment_id('product');
    $defaults['products'] = array_map(static function (array $row) use ($product_id): array {
        unset($row['image_asset']);
        $row['image'] = $product_id;
        return $row;
    }, $defaults['products']);
    $defaults['hero_image'] = ameza_media_attachment_id('hero');
    $defaults['about_image'] = ameza_media_attachment_id('production');

    foreach ($defaults as $field => $value) {
        // Never erase any manually entered content.
        if (metadata_exists('post', $home_id, $field)) { continue; }
        update_field('field_ameza_' . $field, $value, $home_id);
    }
    update_option('ameza_home_fields_seeded', $home_id, false);
}

function ameza_provision_pages(): void {
    if (!is_admin() || !current_user_can('manage_options')) { return; }
    [$home_id] = ameza_ensure_page('glavnaya', 'Главная', 'publish');
    [$privacy_id] = ameza_ensure_page('privacy-policy', 'Политика конфиденциальности', 'draft');
    [$offer_id] = ameza_ensure_page('public-offer', 'Публичная оферта', 'draft');
    [$consent_id] = ameza_ensure_page('personal-data-consent', 'Согласие на обработку персональных данных', 'draft');

    // WordPress may already ship a draft named "Privacy Policy".
    // Rename only that untouched draft title; never overwrite a customized page.
    if ($privacy_id) {
        $privacy = get_post($privacy_id);
        if ($privacy instanceof WP_Post && $privacy->post_status === 'draft' && $privacy->post_title === 'Privacy Policy') {
            wp_update_post(['ID' => $privacy_id, 'post_title' => 'Политика конфиденциальности']);
        }
    }

    if ($home_id && !absint(get_option('page_on_front', 0))) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_id);
    }
    if ($privacy_id && !absint(get_option('wp_page_for_privacy_policy', 0))) {
        update_option('wp_page_for_privacy_policy', $privacy_id);
    }
    if (function_exists('update_field')) {
        if ($offer_id && !get_field('offer_page', 'option')) {
            update_field('field_ameza_offer_page', $offer_id, 'option');
        }
        if ($consent_id && !get_field('consent_page', 'option')) {
            update_field('field_ameza_consent_page', $consent_id, 'option');
        }
        if ($home_id) { ameza_seed_home_fields($home_id); }
    }
}
add_action('admin_init', 'ameza_provision_pages', 30);

/** Attach imported images to blank seeded ACF image fields without overwriting user images. */
function ameza_fill_home_media_fields(): void {
    if (!current_user_can('manage_options') || !function_exists('get_field') || !function_exists('update_field')) { return; }
    $home_id = absint(get_option('page_on_front', 0));
    if (!$home_id) { return; }
    foreach (['hero_image'=>'hero','about_image'=>'production'] as $field=>$asset) {
        $id = ameza_media_attachment_id($asset);
        if ($id && !absint(get_post_meta($home_id, $field, true))) {
            update_field('field_ameza_' . $field, $id, $home_id);
        }
    }
    $product_id = ameza_media_attachment_id('product');
    if (!$product_id) { return; }
    $products = get_field('products', $home_id);
    if (!is_array($products)) { return; }
    $updated = false;
    foreach ($products as &$item) {
        if (empty($item['image'])) {
            $item['image'] = $product_id;
            $updated = true;
        }
    }
    unset($item);
    if ($updated) {
        update_field('field_ameza_products', $products, $home_id);
    }
}
add_action('admin_init', 'ameza_fill_home_media_fields', 40);

add_action('admin_notices', static function (): void {
    if (!current_user_can('manage_options') || get_option('ameza_legal_notice_dismissed')) { return; }
    $pages = [];
    foreach (['privacy-policy', 'public-offer', 'personal-data-consent'] as $slug) {
        $page = get_page_by_path($slug, OBJECT, 'page');
        if ($page && $page->post_status === 'draft') {
            $pages[] = '<a href="' . esc_url(get_edit_post_link($page->ID)) . '">' . esc_html($page->post_title) . '</a>';
        }
    }
    if ($pages) {
        echo '<div class="notice notice-warning"><p>AMEZA: юридические страницы созданы как черновики. Заполни согласованными документами и опубликуй: ' . implode(', ', $pages) . '.</p></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
});
