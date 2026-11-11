<?php
defined('ABSPATH') || exit;
foreach ([
 ['wlwmanifest_link',10], ['rsd_link',10], ['wp_generator',10],
 ['wp_shortlink_wp_head',10], ['adjacent_posts_rel_link_wp_head',10],
 ['wp_oembed_add_discovery_links',10], ['wp_oembed_add_host_js',10]
] as [$action,$priority]) { remove_action('wp_head', $action, $priority); }
remove_action('template_redirect', 'wp_shortlink_header', 11);
add_filter('the_generator', '__return_empty_string');
foreach ([
 ['wp_head','print_emoji_detection_script',7],
 ['admin_print_scripts','print_emoji_detection_script',10],
 ['wp_enqueue_scripts','wp_enqueue_emoji_styles',10],
 ['admin_print_styles','wp_enqueue_emoji_styles',10],
 ['wp_print_styles','print_emoji_styles',10],
 ['admin_print_styles','print_emoji_styles',10]
] as [$hook,$callback,$priority]) { remove_action($hook, $callback, $priority); }
add_action('init', static function (): void {
    foreach (get_post_types() as $type) {
        remove_post_type_support($type, 'comments');
        remove_post_type_support($type, 'trackbacks');
    }
}, 100);
add_filter('comments_open','__return_false',100);
add_filter('pings_open','__return_false',100);
add_filter('xmlrpc_enabled','__return_false');
add_filter('use_block_editor_for_post_type', static fn($use,$type) => $type === 'page' ? false : $use, 100, 2);
add_action('admin_menu', static function (): void {
    remove_menu_page('edit.php');
    remove_menu_page('edit-comments.php');
    remove_submenu_page('themes.php','widgets.php');
    remove_submenu_page('themes.php','customize.php');
    remove_submenu_page('themes.php','theme-editor.php');
    remove_submenu_page('plugins.php','plugin-editor.php');
    remove_submenu_page('options-general.php','options-discussion.php');
}, 999);
add_action('admin_bar_menu', static function ($bar): void {
    foreach (['comments','new-post','customize'] as $node) { $bar->remove_node($node); }
}, 999);
add_action('wp_enqueue_scripts', static function (): void {
    foreach (['wp-block-library','wp-block-library-theme','global-styles','classic-theme-styles'] as $handle) {
        wp_dequeue_style($handle);
    }
}, 100);
add_action('wp_dashboard_setup', static function (): void {
    remove_meta_box('dashboard_quick_press','dashboard','side');
    remove_meta_box('dashboard_primary','dashboard','side');
    remove_meta_box('dashboard_activity','dashboard','normal');
});
