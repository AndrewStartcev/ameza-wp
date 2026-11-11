<?php
defined('ABSPATH') || exit;

/** Never fill empty fields with demo text, icons or contact details. */
function ameza_field(string $key, $context = false) {
    if (!function_exists('get_field')) {
        return null;
    }
    return $context === false ? get_field($key) : get_field($key, $context);
}

function ameza_option(string $key) {
    return ameza_field($key, 'option');
}

function ameza_asset(string $path): string {
    return get_theme_file_uri('assets/' . ltrim($path, '/'));
}

function ameza_has_text($value): bool {
    return is_scalar($value) && trim((string)$value) !== '';
}

function ameza_media_url($value): string {
    if (is_numeric($value) && (int)$value > 0) {
        return (string)(wp_get_attachment_image_url((int)$value, 'full') ?: '');
    }
    if (is_array($value)) {
        return esc_url_raw((string)($value['url'] ?? ''));
    }
    return '';
}

/** Icons are optional: a missing ACF value means no element. */
function ameza_icon(string $name = '', int $override_id = 0): void {
    $name = preg_replace('/[^a-z0-9-]/', '', strtolower($name));
    if (!$override_id && $name === '') {
        return;
    }
    $url = $override_id ? (string)wp_get_attachment_url($override_id) : '';
    if (!$url && $name !== '' && function_exists('ameza_media_attachment_url')) {
        $url = ameza_media_attachment_url('icon-' . $name);
    }
    if (!$url && $name !== '') {
        $relative = 'assets/icons/' . $name . '.svg';
        if (is_file(get_theme_file_path($relative))) {
            $url = get_theme_file_uri($relative);
        }
    }
    if (!$url) {
        return;
    }
    printf(
        '<span class="ameza-icon" aria-hidden="true" style="--ameza-icon:url(&#039;%s&#039;)"></span>',
        esc_url($url)
    );
}

function ameza_brand_html(): string {
    $id = (int)(ameza_option('brand_logo') ?: get_theme_mod('custom_logo', 0));
    if ($id > 0) {
        return (string)wp_get_attachment_image($id, 'medium', false, [
            'alt' => (string)(ameza_option('brand_name') ?: get_bloginfo('name')),
        ]);
    }
    $name = (string)(ameza_option('brand_name') ?: '');
    return $name !== '' ? esc_html($name) : '';
}

function ameza_home_anchor(string $id): string {
    return home_url('/#' . rawurlencode($id));
}

function ameza_doc_url(string $slug): string {
    if ($slug === 'privacy') {
        $url = get_privacy_policy_url();
        if ($url) {
            return $url;
        }
    }
    $page = get_page_by_path($slug);
    return $page && $page->post_status === 'publish' ? get_permalink($page) : '';
}

/** Only configured Contact Form 7 shortcodes may produce markup. */
function ameza_form_shortcode(string $key): string {
    $code = ameza_option($key . '_form_shortcode');
    return is_string($code) && preg_match('/^\[contact-form-7\s[^\]]+\]$/', trim($code))
        && shortcode_exists('contact-form-7') ? trim($code) : '';
}

function ameza_print_form(string $key): void {
    $code = ameza_form_shortcode($key);
    if ($code !== '') {
        echo do_shortcode($code); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

add_action('admin_notices', static function (): void {
    if (!current_user_can('activate_plugins')) {
        return;
    }
    $missing = [];
    if (!function_exists('acf_add_local_field_group')) {
        $missing[] = 'ACF PRO';
    }
    if (!defined('WPCF7_VERSION')) {
        $missing[] = 'Contact Form 7';
    }
    if ($missing) {
        printf(
            '<div class="notice notice-warning"><p>AMEZA: активируй %s. Rank Math SEO Free рекомендуется для SEO.</p></div>',
            esc_html(implode(' и ', $missing))
        );
    }
});


/**
 * Read renamed ACF repeater headings, with legacy raw postmeta fallback.
 * ACF's old field names were "title"; on existing pages this data can remain
 * under products_0_title / advantages_0_title after changing the field group.
 */
function ameza_card_heading(array $row, string $group, int $index): string {
    $field = $group === 'products' ? 'product_title' : 'advantage_title';
    $value = trim((string)($row[$field] ?? $row['title'] ?? ''));
    if ($value !== '') {
        return $value;
    }
    $page_id = absint(get_queried_object_id());
    if ($page_id) {
        $previous = get_post_meta($page_id, $group . '_' . $index . '_title', true);
        if (is_scalar($previous)) {
            return trim((string)$previous);
        }
    }
    return '';
}

/**
 * Render only legitimate Yandex Maps constructor scripts or map-widget iframes.
 * Never evaluate pasted HTML directly. All attributes and URLs are reconstructed.
 */
function ameza_yandex_map_embed(string $html): string {
    if ($html === '') {
        return '';
    }
    if (!preg_match('~<(script|iframe)\b[^>]*\bsrc\s*=\s*(["\'])(.*?)\2~is', $html, $m)) {
        return '';
    }
    $type = strtolower($m[1]);
    $url = html_entity_decode(trim($m[3]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $parts = wp_parse_url($url);
    if (!is_array($parts) || strtolower((string)($parts['scheme'] ?? '')) !== 'https') {
        return '';
    }
    $host = strtolower((string)($parts['host'] ?? ''));
    $path = (string)($parts['path'] ?? '');
    if ($type === 'script' && $host === 'api-maps.yandex.ru' &&
        str_starts_with($path, '/services/constructor/1.0/js/')) {
        return '<script async src="' . esc_url($url) . '"></script>';
    }
    if ($type === 'iframe' && in_array($host, ['yandex.ru','yandex.com','yandex.kz'], true) &&
        str_starts_with($path, '/map-widget/v1/')) {
        return '<iframe src="' . esc_url($url) . '" title="Карта проезда" width="100%" height="340" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
    }
    return '';
}
