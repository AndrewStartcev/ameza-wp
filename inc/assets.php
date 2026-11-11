<?php
defined('ABSPATH') || exit;
add_action('wp_enqueue_scripts', static function (): void {
    $path = 'assets/css/ameza.css';
    wp_enqueue_style('ameza-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap', [], null);
    wp_enqueue_style('ameza-main', get_theme_file_uri($path), ['ameza-fonts'], (string) filemtime(get_theme_file_path($path)));
    $js = 'assets/js/ameza.js';
    wp_enqueue_script('ameza-main', get_theme_file_uri($js), [], (string) filemtime(get_theme_file_path($js)), true);
    wp_script_add_data('ameza-main', 'strategy', 'defer');
});

/** Keep back-office styling isolated from the public theme. */
add_action('admin_enqueue_scripts', static function (): void {
    $screen = get_current_screen();
    if (!$screen) { return; }
    $is_home_editor = $screen->id === 'page' && function_exists('ameza_is_editing_front_page') && ameza_is_editing_front_page();
    $is_options = strpos((string)$screen->id, 'ameza-settings') !== false;
    if (!$is_home_editor && !$is_options) { return; }
    $path = 'assets/css/admin.css';
    wp_enqueue_style('ameza-admin', get_theme_file_uri($path), [], (string)filemtime(get_theme_file_path($path)));
});
