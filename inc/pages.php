<?php
/**
 * Only create WordPress pages, not sample ACF values.
 * Existing pages, content and ACF metadata are preserved.
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

function ameza_provision_pages(): void {
    if (!is_admin() || !current_user_can('manage_options')) {
        return;
    }

    [$home_id] = ameza_ensure_page('glavnaya', 'Главная', 'publish');
    [$privacy_id] = ameza_ensure_page('privacy-policy', 'Политика конфиденциальности', 'draft');
    [$offer_id] = ameza_ensure_page('public-offer', 'Публичная оферта', 'draft');
    [$consent_id] = ameza_ensure_page('personal-data-consent', 'Согласие на обработку персональных данных', 'draft');

    if ($privacy_id) {
        $privacy = get_post($privacy_id);
        if ($privacy instanceof WP_Post && $privacy->post_status === 'draft' && $privacy->post_title === 'Privacy Policy') {
            wp_update_post(['ID'=>$privacy_id, 'post_title'=>'Политика конфиденциальности']);
        }
    }

    if ($home_id && !absint(get_option('page_on_front', 0))) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_id);
    }
    if ($privacy_id && !absint(get_option('wp_page_for_privacy_policy', 0))) {
        update_option('wp_page_for_privacy_policy', $privacy_id);
    }
    if (function_exists('update_field') && function_exists('get_field')) {
        if ($offer_id && !get_field('offer_page', 'option')) {
            update_field('field_ameza_offer_page', $offer_id, 'option');
        }
        if ($consent_id && !get_field('consent_page', 'option')) {
            update_field('field_ameza_consent_page', $consent_id, 'option');
        }
    }
}
add_action('admin_init', 'ameza_provision_pages', 30);

add_action('admin_notices', static function (): void {
    if (!current_user_can('manage_options')) {
        return;
    }
    $pages = [];
    foreach (['privacy-policy', 'public-offer', 'personal-data-consent'] as $slug) {
        $page = get_page_by_path($slug, OBJECT, 'page');
        if ($page && $page->post_status === 'draft') {
            $pages[] = '<a href="' . esc_url(get_edit_post_link($page->ID)) . '">' . esc_html($page->post_title) . '</a>';
        }
    }
    if ($pages) {
        echo '<div class="notice notice-warning"><p>AMEZA: юридические страницы пока черновики. Заполни документы и опубликуй: '
            . implode(', ', $pages) . '.</p></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
});
