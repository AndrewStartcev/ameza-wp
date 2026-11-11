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
<header class="header">
    <div class="container header-inner">
        <a class="logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="AMEZA — главная">
            <?php
            $logo_id = (int) ameza_option('brand_logo', 0);
            if ($logo_id) {
                echo wp_get_attachment_image($logo_id, 'medium', false, ['alt'=>(string)ameza_option('brand_name','AMEZA')]); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            } elseif (has_custom_logo()) {
                $id = (int)get_theme_mod('custom_logo');
                echo wp_get_attachment_image($id, 'medium', false, ['alt'=>(string)ameza_option('brand_name','AMEZA')]); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            } else {
                echo esc_html((string)ameza_option('brand_name', 'AMEZA'));
            }
            ?>
        </a>
        <nav class="nav-menu" id="navMenu" aria-label="Основная навигация">
            <?php if (has_nav_menu('primary')) :
                wp_nav_menu(['theme_location'=>'primary','container'=>false,'menu_class'=>'nav-menu__list','depth'=>1]);
            else : ?>
            <ul class="nav-menu__list">
                <?php foreach (['advantages'=>'Преимущества','assortment'=>'Продукция','about'=>'О производстве','b2b'=>'Опт','contacts'=>'Контакты'] as $id=>$label) : ?>
                <li><a href="<?php echo esc_url(ameza_home_anchor($id)); ?>"><?php echo esc_html($label); ?></a></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </nav>
        <div class="header-contacts">
            <?php $phone=(string)ameza_option('phone','+7 (495) 123-45-67'); $tg=(string)ameza_option('telegram','https://t.me/ameza_brand'); ?>
            <?php if ($phone) : ?>
            <a href="tel:<?php echo esc_attr(preg_replace('/[^+0-9]/','',$phone)); ?>" aria-label="<?php echo esc_attr($phone); ?>"><?php ameza_icon('phone'); ?></a>
            <?php endif; ?>
            <?php if ($tg) : ?>
            <a href="<?php echo esc_url($tg); ?>" rel="noopener noreferrer" target="_blank" aria-label="Telegram"><?php ameza_icon('telegram'); ?></a>
            <?php endif; ?>
            <a href="<?php echo esc_url(ameza_home_anchor('contacts')); ?>" class="btn">Оставить заявку</a>
            <button class="burger" id="burger" type="button" aria-label="Открыть меню" aria-controls="navMenu" aria-expanded="false"><?php ameza_icon('menu'); ?></button>
        </div>
    </div>
</header>
