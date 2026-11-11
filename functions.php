<?php
defined('ABSPATH') || exit;
foreach (['setup', 'assets', 'defaults', 'helpers', 'acf', 'media', 'pages', 'cleanup'] as $module) {
    require_once get_template_directory() . '/inc/' . $module . '.php';
}
