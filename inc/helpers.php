<?php
defined('ABSPATH') || exit;

function ameza_asset(string $path): string {
    return get_theme_file_uri('assets/' . ltrim($path, '/'));
}
function ameza_field(string $key, $fallback = null, $context = false) {
    if ($fallback === null) {
        static $defaults = null;
        if ($defaults === null) { $defaults = ameza_defaults(); }
        $fallback = $defaults[$key] ?? null;
    }
    if (!function_exists('get_field')) {
        return $fallback;
    }
    $value = $context ? get_field($key, $context) : get_field($key);
    return ($value === null || $value === false || $value === '' || $value === []) ? $fallback : $value;
}
function ameza_option(string $key, $fallback = '') {
    return ameza_field($key, $fallback, 'option');
}
function ameza_media_url($value, string $fallback): string {
    if (is_numeric($value) && (int)$value > 0) {
        $url = wp_get_attachment_image_url((int)$value, 'full');
        return $url ?: ameza_asset($fallback);
    }
    if (is_array($value) && !empty($value['url'])) {
        return (string)$value['url'];
    }
    // Use exact photos from the original mockup after a one-time WordPress media import.
    $sources = [
        'img/hero-socks.svg' => ['hero', 'uploads-ready/photos/hero.jpg'],
        'img/factory.svg' => ['production', 'uploads-ready/photos/production.jpg'],
        'img/product-classic.svg' => ['product', 'uploads-ready/photos/product.jpg'],
        'img/product-sport.svg' => ['product', 'uploads-ready/photos/product.jpg'],
        'img/product-brand.svg' => ['product', 'uploads-ready/photos/product.jpg'],
        'img/product-kids.svg' => ['product', 'uploads-ready/photos/product.jpg'],
    ];
    if (isset($sources[$fallback])) {
        [$key, $source] = $sources[$fallback];
        if (function_exists('ameza_media_attachment_url')) {
            $url = ameza_media_attachment_url($key);
            if ($url !== '') { return $url; }
        }
        if (file_exists(get_theme_file_path('assets/' . $source))) {
            return ameza_asset($source);
        }
    }
    return ameza_asset($fallback);
}
function ameza_icon(string $name, int $override_id = 0): void {
    $name = preg_replace('/[^a-z0-9-]/', '', strtolower($name));
    $url = $override_id ? (string) wp_get_attachment_url($override_id) : '';
    if (!$url && function_exists('ameza_media_attachment_url')) {
        $url = ameza_media_attachment_url('icon-' . $name);
    }
    if (!$url) {
        $url = ameza_asset('icons/' . $name . '.svg');
    }
    printf('<span class="ameza-icon" aria-hidden="true" style="--ameza-icon:url(\'%s\')"></span>', esc_url($url));
}
function ameza_home_anchor(string $id): string {
    return home_url('/#' . rawurlencode($id));
}
function ameza_doc_url(string $slug): string {
    if ($slug === 'privacy') {
        $url = get_privacy_policy_url();
        if ($url) { return $url; }
    }
    $page = get_page_by_path($slug);
    return $page && $page->post_status === 'publish' ? get_permalink($page) : '';
}
function ameza_print_form(string $key): void {
    $shortcode = trim((string)ameza_option($key . '_form_shortcode', ''));
    if ($shortcode !== '' && preg_match('/^\[contact-form-7\s[^\]]+\]$/', $shortcode) && shortcode_exists('contact-form-7')) {
        echo do_shortcode($shortcode); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        return;
    }
    $phone = (string)ameza_option('phone', '');
    echo '<p class="ameza-form-placeholder">';
    if ($phone) {
        printf('Для заявки позвони нам: <a href="tel:%s">%s</a>', esc_attr(preg_replace('/[^+0-9]/', '', $phone)), esc_html($phone));
    } else {
        echo 'Форма обратной связи будет доступна после настройки.';
    }
    echo '</p>';
}
add_action('admin_notices', static function (): void {
    if (!current_user_can('activate_plugins')) { return; }
    $missing=[];
    if (!function_exists('acf_add_local_field_group')) { $missing[]='ACF PRO'; }
    if (!defined('WPCF7_VERSION')) { $missing[]='Contact Form 7'; }
    if ($missing) {
        printf('<div class="notice notice-warning"><p>AMEZA: активируй %s. Rank Math SEO Free рекомендуется для SEO.</p></div>', esc_html(implode(' и ', $missing)));
    }
});
