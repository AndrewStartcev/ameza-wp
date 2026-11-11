<?php
defined('ABSPATH') || exit;
foreach (['setup', 'assets', 'helpers', 'acf', 'media', 'pages', 'seed', 'legal-content', 'cleanup'] as $module) {
    require_once get_template_directory() . '/inc/' . $module . '.php';
}
