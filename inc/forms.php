<?php
/**
 * Create two Contact Form 7 forms once, using the markup in the supplied HTML.
 * Existing user-created forms and manually configured ACF shortcodes are not changed.
 */
defined('ABSPATH') || exit;

function ameza_seed_form_markup(string $variant): string {
    $fields = <<<'FORM'
<div class="form-group">
  [text* your-name autocomplete:name placeholder "Ваше имя *"]
</div>
<div class="form-group">
  [tel* your-phone autocomplete:tel placeholder "Телефон *"]
</div>
<div class="form-group">
  [email your-email autocomplete:email placeholder "Email"]
</div>
FORM;
    if ($variant === 'b2b') {
        $fields .= <<<'FORM'

<div class="form-group">
  [text your-company placeholder "Компания"]
</div>
FORM;
    }
    $fields .= $variant === 'b2b' ? <<<'FORM'

<div class="form-group">
  [textarea your-message 40x4 placeholder "Комментарий (какая продукция интересует, объёмы)"]
</div>
FORM
        : <<<'FORM'

<div class="form-group">
  [textarea your-message placeholder "Комментарий"]
</div>
FORM;
    $submit = $variant === 'b2b' ? 'Отправить заявку' : 'Отправить';
    return $fields . <<<'FORM'

<div class="form-group checkbox">
  [acceptance personal-data-consent]
  Согласен на обработку персональных данных
  [/acceptance]
</div>
FORM
        . "\n" . '[submit class:btn "' . $submit . '"]';
}

function ameza_seed_cf7_forms(): void {
    if (!is_admin() || !current_user_can('manage_options') ||
        !class_exists('WPCF7_ContactForm') || !function_exists('update_field')) {
        return;
    }
    foreach (['b2b'=>'AMEZA — Запрос прайс-листа', 'contacts'=>'AMEZA — Обратная связь'] as $key=>$title) {
        if (get_field($key . '_form_shortcode', 'option')) { continue; }

        $existing = get_posts([
            'post_type'=>'wpcf7_contact_form',
            'post_status'=>'publish',
            'posts_per_page'=>1,
            'meta_key'=>'_ameza_form_variant',
            'meta_value'=>$key,
            'fields'=>'ids',
        ]);
        $id = $existing ? (int)$existing[0] : 0;
        if (!$id) {
            $id = wp_insert_post([
                'post_type'=>'wpcf7_contact_form',
                'post_status'=>'publish',
                'post_title'=>$title,
            ], true);
            if (is_wp_error($id) || !$id) { continue; }

            $mail = [
                'active'=>true,
                'subject'=>($key==='b2b' ? '[_site_title] — запрос прайс-листа' : '[_site_title] — обратная связь'),
                'sender'=>'[_site_title] <wordpress@[_site_domain]>',
                'recipient'=>get_option('admin_email'),
                'body'=>"Имя: [your-name]\nТелефон: [your-phone]\nEmail: [your-email]\n"
                    . ($key === 'b2b' ? "Компания: [your-company]\n" : "")
                    . "Комментарий: [your-message]\nСтраница: [_url]\nДата: [_date] [_time]",
                'additional_headers'=>'',
                'attachments'=>'',
                'use_html'=>false,
                'exclude_blank'=>false,
            ];
            update_post_meta($id, '_form', ameza_seed_form_markup($key));
            update_post_meta($id, '_mail', $mail);
            update_post_meta($id, '_mail_2', ['active'=>false]);
            update_post_meta($id, '_messages', []);
            update_post_meta($id, '_additional_settings', '');
            update_post_meta($id, '_locale', get_locale());
            update_post_meta($id, '_ameza_form_variant', $key);
        }
        update_field('field_ameza_' . $key . '_form_shortcode', sprintf('[contact-form-7 id="%d"]', $id), 'option');
    }
}
add_action('admin_init', 'ameza_seed_cf7_forms', 75);


/**
 * Refresh ONLY AMEZA-generated forms to use the fixed 4-row textarea.
 * Preserve all mail settings and unrelated/manual forms.
 */
function ameza_update_managed_cf7_layout_v2(): void {
    if (!is_admin() || !current_user_can('manage_options') ||
        !class_exists('WPCF7_ContactForm') ||
        get_option('ameza_managed_cf7_layout_v2') === 'complete') {
        return;
    }
    foreach (['b2b','contacts'] as $variant) {
        $ids = get_posts([
            'post_type'=>'wpcf7_contact_form',
            'post_status'=>'publish',
            'posts_per_page'=>-1,
            'fields'=>'ids',
            'meta_key'=>'_ameza_form_variant',
            'meta_value'=>$variant,
        ]);
        foreach ($ids as $id) {
            update_post_meta($id, '_form', ameza_seed_form_markup($variant));
        }
    }
    update_option('ameza_managed_cf7_layout_v2', 'complete', false);
}
add_action('admin_init', 'ameza_update_managed_cf7_layout_v2', 85);
