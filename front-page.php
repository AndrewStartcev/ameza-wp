<?php
defined('ABSPATH') || exit;
get_header();

$hero_title = trim((string)ameza_field('hero_title'));
$hero_text = trim((string)ameza_field('hero_text'));
$hero_image = ameza_media_url(ameza_field('hero_image'));
$hero_primary = trim((string)ameza_field('hero_primary_text'));
$hero_secondary = trim((string)ameza_field('hero_secondary_text'));
$features = array_values(array_filter((array)ameza_field('hero_features'), static function ($row): bool {
    return is_array($row) && (
        ameza_has_text($row['text'] ?? '') ||
        !empty($row['icon_image'])
    );
}));

$advantages = array_values(array_filter((array)ameza_field('advantages'), static function ($row): bool {
    return is_array($row) && (
        ameza_has_text($row['title'] ?? '') ||
        ameza_has_text($row['text'] ?? '') ||
        !empty($row['icon_image'])
    );
}));
$products = array_values(array_filter((array)ameza_field('products'), static function ($row): bool {
    return is_array($row) && (
        ameza_has_text($row['title'] ?? '') ||
        ameza_has_text($row['text'] ?? '') ||
        !empty($row['image'])
    );
}));
$about_title = trim((string)ameza_field('about_title'));
$about_content = trim((string)ameza_field('about_content'));
$about_image = ameza_media_url(ameza_field('about_image'));
$about_caption = trim((string)ameza_field('about_caption'));
$b2b_title = trim((string)ameza_field('b2b_title'));
$b2b_text = trim((string)ameza_field('b2b_text'));
$b2b_bullets = array_values(array_filter((array)ameza_field('b2b_bullets'), static fn($row) =>
    is_array($row) && ameza_has_text($row['text'] ?? '')
));
$b2b_form = ameza_form_shortcode('b2b');
$reviews = array_values(array_filter((array)ameza_field('reviews'), static function ($row): bool {
    return is_array($row) && (
        ameza_has_text($row['quote'] ?? '') ||
        ameza_has_text($row['author'] ?? '') ||
        ameza_has_text($row['company'] ?? '')
    );
}));
$faqs = array_values(array_filter((array)ameza_field('faqs'), static fn($row) =>
    is_array($row) && ameza_has_text($row['question'] ?? '')
));
$contact_phone = trim((string)ameza_option('phone'));
$contact_email = trim((string)ameza_option('email'));
$contact_telegram = trim((string)ameza_option('telegram'));
$telegram_label = trim((string)ameza_option('telegram_label'));
$whatsapp_number = trim((string)ameza_option('whatsapp_phone')) ?: $contact_phone;
$contact_whatsapp = trim((string)ameza_option('whatsapp'));
$contact_address = trim((string)ameza_option('address'));
$map_embed = ameza_yandex_map_embed((string)ameza_option('map_embed'));
$contacts_form = ameza_form_shortcode('contacts');
$has_contact_info = $contact_phone || $contact_email || $contact_telegram || $contact_whatsapp || $contact_address || $map_embed;
?>
<main id="main">
<?php if ($hero_title || $hero_text || $hero_image || $hero_primary || $hero_secondary || $features) : ?>
<section class="hero"<?php if ($hero_image) : ?> style="--ameza-hero-image:url('<?php echo esc_url($hero_image); ?>')"<?php endif; ?>>
    <div class="container hero-content">
        <?php if ($hero_title) : ?><h1><?php echo esc_html($hero_title); ?></h1><?php endif; ?>
        <?php if ($hero_text) : ?><p><?php echo esc_html($hero_text); ?></p><?php endif; ?>
        <?php if ($hero_primary || $hero_secondary) : ?>
        <div class="hero-buttons">
            <?php if ($hero_primary) : ?><a href="#assortment" class="btn"><?php echo esc_html($hero_primary); ?></a><?php endif; ?>
            <?php if ($hero_secondary) : ?><a href="#b2b" class="btn btn-outline"><?php echo esc_html($hero_secondary); ?></a><?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if ($features) : ?>
        <div class="hero-features">
            <?php foreach ($features as $feature) : ?>
            <div class="hero-feature-item">
                <?php ameza_icon('', absint($feature['icon_image'] ?? 0)); ?>
                <?php if (ameza_has_text($feature['text'] ?? '')) : ?><span><?php echo esc_html($feature['text']); ?></span><?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<?php $advantages_title=trim((string)ameza_field('advantages_title')); $advantages_subtitle=trim((string)ameza_field('advantages_subtitle')); ?>
<?php if ($advantages_title || $advantages_subtitle || $advantages) : ?>
<section class="advantages" id="advantages">
    <div class="container">
        <?php if ($advantages_title) : ?><h2 class="section-title"><?php echo esc_html($advantages_title); ?></h2><?php endif; ?>
        <?php if ($advantages_subtitle) : ?><p class="section-subtitle"><?php echo esc_html($advantages_subtitle); ?></p><?php endif; ?>
        <?php if ($advantages) : ?>
        <div class="advantages-grid">
            <?php foreach ($advantages as $index => $item) : ?>
            <?php $advantage_title = ameza_card_heading($item, 'advantages', $index); ?>
            <article class="advantage-card">
                <?php ameza_icon('', absint($item['icon_image'] ?? 0)); ?>
                <?php if ($advantage_title !== '') : ?><h3><?php echo esc_html($advantage_title); ?></h3><?php endif; ?>
                <?php if (ameza_has_text($item['text'] ?? '')) : ?><p><?php echo esc_html($item['text']); ?></p><?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<?php $products_title=trim((string)ameza_field('products_title')); $products_subtitle=trim((string)ameza_field('products_subtitle')); ?>
<?php if ($products_title || $products_subtitle || $products) : ?>
<section class="assortment" id="assortment">
    <div class="container">
        <?php if ($products_title) : ?><h2 class="section-title"><?php echo esc_html($products_title); ?></h2><?php endif; ?>
        <?php if ($products_subtitle) : ?><p class="section-subtitle"><?php echo esc_html($products_subtitle); ?></p><?php endif; ?>
        <?php if ($products) : ?>
        <div class="assortment-grid">
            <?php foreach ($products as $index => $item) : ?>
            <?php
            $product_title = ameza_card_heading($item, 'products', $index);
            $product_image = ameza_media_url($item['image'] ?? 0);
            ?>
            <article class="product-card">
                <?php if ($product_image) : ?>
                <div class="product-image">
                    <img src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr($product_title); ?>" loading="lazy" decoding="async">
                </div>
                <?php endif; ?>
                <?php if ($product_title !== '') : ?><h3><?php echo esc_html($product_title); ?></h3><?php endif; ?>
                <?php if (ameza_has_text($item['text'] ?? '')) : ?><p><?php echo esc_html($item['text']); ?></p><?php endif; ?>
                <?php if (ameza_has_text($item['button_text'] ?? '')) : ?>
                <a href="#b2b" class="btn"><?php echo esc_html($item['button_text']); ?></a>
                <?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<?php if ($about_title || $about_content || $about_image) : ?>
<section class="about-production" id="about">
    <div class="container about-grid<?php echo ($about_image && ($about_title || $about_content)) ? '' : ' about-grid--single'; ?>">
        <?php if ($about_title || $about_content) : ?>
        <div class="about-text">
            <?php if ($about_title) : ?><h2><?php echo esc_html($about_title); ?></h2><?php endif; ?>
            <?php if ($about_content) : ?><?php echo wp_kses_post($about_content); ?><?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if ($about_image) : ?>
        <div class="about-image" style="--ameza-about-image:url('<?php echo esc_url($about_image); ?>')">
            <?php if ($about_caption) : ?><span><?php echo esc_html($about_caption); ?></span><?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<?php $b2b_form_title=trim((string)ameza_field('b2b_form_title')); ?>
<?php if ($b2b_title || $b2b_text || $b2b_bullets || $b2b_form) : ?>
<section class="b2b" id="b2b">
    <div class="container">
        <div class="b2b-content<?php echo $b2b_form ? '' : ' b2b-content--single'; ?>">
            <?php if ($b2b_title || $b2b_text || $b2b_bullets) : ?>
            <div class="b2b-text">
                <?php if ($b2b_title) : ?><h2><?php echo esc_html($b2b_title); ?></h2><?php endif; ?>
                <?php if ($b2b_text) : ?><p><?php echo esc_html($b2b_text); ?></p><?php endif; ?>
                <?php if ($b2b_bullets) : ?>
                <ul>
                    <?php foreach ($b2b_bullets as $bullet) : ?>
                    <li>
                        <?php ameza_icon('', absint($bullet['icon_image'] ?? 0)); ?>
                        <span><?php echo esc_html($bullet['text']); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if ($b2b_form) : ?>
            <div class="b2b-form-wrapper">
                <?php if ($b2b_form_title) : ?><h3><?php echo esc_html($b2b_form_title); ?></h3><?php endif; ?>
                <?php ameza_print_form('b2b'); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php $reviews_title=trim((string)ameza_field('reviews_title')); $reviews_subtitle=trim((string)ameza_field('reviews_subtitle')); ?>
<?php if ($reviews_title || $reviews_subtitle || $reviews) : ?>
<section class="reviews">
    <div class="container">
        <?php if ($reviews_title) : ?><h2 class="section-title"><?php echo esc_html($reviews_title); ?></h2><?php endif; ?>
        <?php if ($reviews_subtitle) : ?><p class="section-subtitle"><?php echo esc_html($reviews_subtitle); ?></p><?php endif; ?>
        <?php if ($reviews) : ?>
        <div class="reviews-grid">
            <?php foreach ($reviews as $review) : ?>
            <article class="review-card">
                <?php $rating = absint($review['rating'] ?? 0); $rating = min(5, $rating); ?>
                <?php if ($rating > 0) : ?>
                <div class="stars" aria-label="<?php echo esc_attr($rating . ' из 5'); ?>">
                    <?php for ($i = 0; $i < $rating; $i++) { ameza_icon('star'); } ?>
                </div>
                <?php endif; ?>
                <?php if (ameza_has_text($review['quote'] ?? '')) : ?><p>«<?php echo esc_html($review['quote']); ?>»</p><?php endif; ?>
                <?php if (ameza_has_text($review['author'] ?? '')) : ?><div class="author"><?php echo esc_html($review['author']); ?></div><?php endif; ?>
                <?php if (ameza_has_text($review['company'] ?? '')) : ?><div class="company"><?php echo esc_html($review['company']); ?></div><?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<?php $faq_title=trim((string)ameza_field('faq_title')); $faq_subtitle=trim((string)ameza_field('faq_subtitle')); ?>
<?php if ($faq_title || $faq_subtitle || $faqs) : ?>
<section class="faq">
    <div class="container">
        <?php if ($faq_title) : ?><h2 class="section-title"><?php echo esc_html($faq_title); ?></h2><?php endif; ?>
        <?php if ($faq_subtitle) : ?><p class="section-subtitle"><?php echo esc_html($faq_subtitle); ?></p><?php endif; ?>
        <?php if ($faqs) : ?>
        <div class="faq-list">
            <?php foreach ($faqs as $faq) : ?>
            <details class="faq-item">
                <summary class="faq-question">
                    <span><?php echo esc_html($faq['question']); ?></span>
                    <?php ameza_icon('chevron-down'); ?>
                </summary>
                <?php if (ameza_has_text($faq['answer'] ?? '')) : ?>
                <div class="faq-answer"><?php echo wp_kses_post(wpautop($faq['answer'])); ?></div>
                <?php endif; ?>
            </details>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<?php
$contacts_title=trim((string)ameza_field('contacts_title'));
$contacts_subtitle=trim((string)ameza_field('contacts_subtitle'));
$contacts_info_title=trim((string)ameza_field('contacts_info_title'));
$contacts_form_title=trim((string)ameza_field('contacts_form_title'));
?>
<?php if ($contacts_title || $contacts_subtitle || $has_contact_info || $contacts_form) : ?>
<section class="contacts" id="contacts">
    <div class="container">
        <?php if ($contacts_title) : ?><h2 class="section-title"><?php echo esc_html($contacts_title); ?></h2><?php endif; ?>
        <?php if ($contacts_subtitle) : ?><p class="section-subtitle"><?php echo esc_html($contacts_subtitle); ?></p><?php endif; ?>
        <?php if ($has_contact_info || $contacts_form) : ?>
        <div class="contacts-grid<?php echo $contacts_form && $has_contact_info ? '' : ' contacts-grid--single'; ?>">
            <?php if ($has_contact_info) : ?>
            <div class="contact-info">
                <?php if ($contacts_info_title) : ?><h2><?php echo esc_html($contacts_info_title); ?></h2><?php endif; ?>
                <?php if ($contact_phone) : ?>
                <div class="contact-item"><?php ameza_icon('phone'); ?>
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^+0-9]/', '', $contact_phone)); ?>"><?php echo esc_html($contact_phone); ?></a>
                </div>
                <?php endif; ?>
                <?php if ($contact_email) : ?>
                <div class="contact-item"><?php ameza_icon('mail'); ?>
                    <a href="mailto:<?php echo esc_attr(antispambot($contact_email)); ?>"><?php echo esc_html(antispambot($contact_email)); ?></a>
                </div>
                <?php endif; ?>
                <?php if ($contact_telegram) : ?>
                <div class="contact-item"><?php ameza_icon('telegram'); ?>
                    <a href="<?php echo esc_url($contact_telegram); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($telegram_label ?: "Telegram"); ?></a>
                </div>
                <?php endif; ?>
                <?php if ($contact_whatsapp) : ?>
                <div class="contact-item"><?php ameza_icon('whatsapp'); ?>
                    <a href="<?php echo esc_url($contact_whatsapp); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($whatsapp_number); ?></a>
                </div>
                <?php endif; ?>
                <?php if ($contact_address) : ?>
                <div class="contact-item"><?php ameza_icon('map-pin'); ?>
                    <span><?php echo esc_html($contact_address); ?></span>
                </div>
                <?php endif; ?>
                <?php if ($map_embed) : ?>
                <div class="contact-map"><?php echo $map_embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if ($contacts_form) : ?>
            <div class="contact-form">
                <?php if ($contacts_form_title) : ?><h3><?php echo esc_html($contacts_form_title); ?></h3><?php endif; ?>
                <?php ameza_print_form('contacts'); ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
</main>
<?php get_footer(); ?>
