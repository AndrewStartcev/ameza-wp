<?php
defined('ABSPATH') || exit;
add_action('after_setup_theme', static function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','gallery','caption','style','script']);
    add_theme_support('custom-logo', ['height'=>100,'width'=>300,'flex-height'=>true,'flex-width'=>true]);
    register_nav_menus(['primary' => 'Основное меню', 'footer' => 'Меню в подвале']);
});
