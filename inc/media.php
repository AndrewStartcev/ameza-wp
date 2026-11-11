<?php
/**
 * Local, repeat-safe import from theme assets into the WordPress Media Library.
 * No external downloads on the production server: GitHub Actions prepares images.
 */
defined('ABSPATH') || exit;

function ameza_media_sources(): array {
    $sources = [
        'hero' => ['photos/hero.jpg', 'AMEZA — изображение первого экрана'],
        'production' => ['photos/production.jpg', 'AMEZA — изображение производства'],
        'product' => ['photos/product.jpg', 'AMEZA — фотография продукции (замена недоступного оригинала)'],
    ];
    foreach ([
        'phone', 'telegram', 'whatsapp', 'factory', 'check-circle', 'tags',
        'certificate', 'search', 'palette', 'handshake', 'chart', 'check',
        'star', 'chevron-down', 'mail', 'map-pin', 'menu', 'arrow-up'
    ] as $name) {
        $sources['icon-' . $name] = ['icons/' . $name . '.png', 'AMEZA — иконка ' . $name];
    }
    return $sources;
}

function ameza_media_attachment_id(string $key): int {
    $manifest = get_option('ameza_media_manifest', []);
    $id = is_array($manifest) ? absint($manifest[$key] ?? 0) : 0;
    return $id && get_post_type($id) === 'attachment' ? $id : 0;
}

function ameza_media_attachment_url(string $key): string {
    $id = ameza_media_attachment_id($key);
    return $id ? (string) wp_get_attachment_url($id) : '';
}

/**
 * Import image files copied into the theme by the GitHub media preparation workflow.
 * Files stay under wp-content/uploads after importing, so theme updates are safe.
 */
function ameza_import_media_assets(): void {
    if (!is_admin() || !current_user_can('manage_options')) { return; }
    $sources = ameza_media_sources();
    $source_dir = get_template_directory() . '/assets/uploads-ready/';
    $manifest = get_option('ameza_media_manifest', []);
    if (!is_array($manifest)) { $manifest = []; }
    $all_ready = true;

    foreach ($sources as $key => [$relative_path, $title]) {
        $already = absint($manifest[$key] ?? 0);
        if ($already && get_post_type($already) === 'attachment') { continue; }

        $existing = get_posts([
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => 1,
            'fields' => 'ids',
            'meta_key' => '_ameza_import_source',
            'meta_value' => $key,
        ]);
        if ($existing) {
            $manifest[$key] = (int)$existing[0];
            continue;
        }

        $source = $source_dir . $relative_path;
        if (!is_readable($source) || !getimagesize($source)) {
            $all_ready = false;
            continue;
        }
        $filetype = wp_check_filetype(basename($source));
        if (!in_array($filetype['type'] ?? '', ['image/jpeg', 'image/png'], true)) {
            $all_ready = false;
            continue;
        }

        $filename = 'ameza-' . str_replace(['/', '.'], '-', $key) . '.' . pathinfo($source, PATHINFO_EXTENSION);
        $bytes = file_get_contents($source);
        if ($bytes === false) { $all_ready = false; continue; }

        $upload = wp_upload_bits($filename, null, $bytes);
        if (!empty($upload['error'])) {
            $all_ready = false;
            continue;
        }
        $attachment_id = wp_insert_attachment([
            'post_mime_type' => $filetype['type'],
            'post_title' => $title,
            'post_content' => '',
            'post_status' => 'inherit',
        ], $upload['file'], 0, true);

        if (is_wp_error($attachment_id)) {
            wp_delete_file($upload['file']);
            $all_ready = false;
            continue;
        }

        update_post_meta($attachment_id, '_ameza_import_source', $key);
        update_post_meta($attachment_id, '_wp_attachment_image_alt', $title);
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $metadata = wp_generate_attachment_metadata($attachment_id, $upload['file']);
        if (is_array($metadata)) {
            wp_update_attachment_metadata($attachment_id, $metadata);
        }
        $manifest[$key] = (int)$attachment_id;
    }

    update_option('ameza_media_manifest', $manifest, false);
    if ($all_ready && count($manifest) >= count($sources)) {
        update_option('ameza_media_import_complete', '1', false);
    }
}
add_action('admin_init', 'ameza_import_media_assets', 15);

add_action('admin_notices', static function (): void {
    if (!current_user_can('manage_options') || get_option('ameza_media_import_complete') === '1') { return; }
    echo '<div class="notice notice-info"><p>AMEZA: оригинальные изображения и иконки будут автоматически добавлены в медиатеку из папки assets/uploads-ready после обновления темы и входа в админку. Проверить импорт можно в «Медиафайлы».</p></div>';
});
