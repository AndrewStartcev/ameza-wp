<?php defined('ABSPATH') || exit; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
$brand = ameza_brand_html();
$phone = trim((string)ameza_option('phone'));
$telegram = trim((string)ameza_option('telegram'));
$cta_text = trim((string)ameza_option('header_cta_text'));
$has_menu = has_nav_menu('primary');
?>
<header class="header">
    <div class="container header-inner">
        <?php if ($brand !== '') : ?>
        <a class="logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(wp_strip_all_tags((string)ameza_option('brand_name')) ?: get_bloginfo('name')); ?>">
            <?php echo $brand; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </a>
        <?php endif; ?>
        <?php if ($has_menu) : ?>
        <nav class="nav-menu" id="navMenu" aria-label="Основная навигация">
            <?php wp_nav_menu(['theme_location'=>'primary', 'container'=>false, 'menu_class'=>'nav-menu__list', 'depth'=>1]); ?>
        </nav>
        <?php endif; ?>
        <?php if ($phone || $telegram || $cta_text || $has_menu) : ?>
        <div class="header-contacts">
            <?php if ($phone) : ?>
            <a href="tel:<?php echo esc_attr(preg_replace('/[^+0-9]/', '', $phone)); ?>" aria-label="<?php echo esc_attr($phone); ?>">
                <?php ameza_icon('phone'); ?>
            </a>
            <?php endif; ?>
            <?php if ($telegram) : ?>
            <a href="<?php echo esc_url($telegram); ?>" rel="noopener noreferrer" target="_blank" aria-label="Telegram">
                <?php ameza_icon('telegram'); ?>
            </a>
            <?php endif; ?>
            <?php if ($cta_text) : ?>
            <a href="<?php echo esc_url(ameza_home_anchor('contacts')); ?>" class="btn"><?php echo esc_html($cta_text); ?></a>
            <?php endif; ?>
            <?php if ($has_menu) : ?>
            <button class="burger" id="burger" type="button" aria-label="Открыть меню" aria-controls="navMenu" aria-expanded="false">
                <?php ameza_icon('menu'); ?>
            </button>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</header>
