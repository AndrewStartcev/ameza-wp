<?php
defined('ABSPATH') || exit;
get_header();
$hero_image = ameza_media_url(ameza_field('hero_image', 0), 'img/hero-socks.svg');
$about_image = ameza_media_url(ameza_field('about_image', 0), 'img/factory.svg');
?>
<main id="main">
<section class="hero" style="--ameza-hero-image:url('<?php echo esc_url($hero_image); ?>')">
    <div class="container hero-content">
        <h1><?php echo esc_html((string)ameza_field('hero_title')); ?></h1>
        <p><?php echo esc_html((string)ameza_field('hero_text')); ?></p>
        <div class="hero-buttons">
            <a href="#assortment" class="btn"><?php echo esc_html((string)ameza_field('hero_primary_text')); ?></a>
            <a href="#b2b" class="btn btn-outline"><?php echo esc_html((string)ameza_field('hero_secondary_text')); ?></a>
        </div>
        <div class="hero-features">
        <?php foreach ((array)ameza_field('hero_features') as $feature) : ?>
            <div class="hero-feature-item">
                <?php ameza_icon((string)($feature['icon']??'check-circle'), absint($feature['icon_image']??0)); ?>
                <span><?php echo esc_html((string)($feature['text']??'')); ?></span>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="advantages" id="advantages">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html((string)ameza_field('advantages_title')); ?></h2>
        <p class="section-subtitle"><?php echo esc_html((string)ameza_field('advantages_subtitle')); ?></p>
        <div class="advantages-grid">
            <?php foreach ((array)ameza_field('advantages') as $item) : ?>
            <article class="advantage-card">
                <?php ameza_icon((string)($item['icon']??'check-circle'), absint($item['icon_image']??0)); ?>
                <h3><?php echo esc_html((string)($item['title']??'')); ?></h3>
                <p><?php echo esc_html((string)($item['text']??'')); ?></p>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="assortment" id="assortment">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html((string)ameza_field('products_title')); ?></h2>
        <p class="section-subtitle"><?php echo esc_html((string)ameza_field('products_subtitle')); ?></p>
        <div class="assortment-grid">
            <?php foreach ((array)ameza_field('products') as $item) :
                $url=ameza_media_url($item['image']??0, (string)($item['image_asset']??'img/product-classic.svg'));
            ?>
            <article class="product-card">
                <div class="product-image">
                    <img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr((string)($item['title']??'Носки AMEZA')); ?>" loading="lazy" decoding="async">
                </div>
                <h3><?php echo esc_html((string)($item['title']??'')); ?></h3>
                <p><?php echo esc_html((string)($item['text']??'')); ?></p>
                <a href="#b2b" class="btn"><?php echo esc_html((string)($item['button_text']??'Запросить прайс')); ?></a>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="about-production" id="about">
    <div class="container about-grid">
        <div class="about-text">
            <h2><?php echo esc_html((string)ameza_field('about_title')); ?></h2>
            <?php echo wp_kses_post((string)ameza_field('about_content')); ?>
        </div>
        <div class="about-image" style="--ameza-about-image:url('<?php echo esc_url($about_image); ?>')">
            <span><?php echo esc_html((string)ameza_field('about_caption')); ?></span>
        </div>
    </div>
</section>

<section class="b2b" id="b2b">
    <div class="container">
        <div class="b2b-content">
            <div class="b2b-text">
                <h2><?php echo esc_html((string)ameza_field('b2b_title')); ?></h2>
                <p><?php echo esc_html((string)ameza_field('b2b_text')); ?></p>
                <ul>
                    <?php foreach ((array)ameza_field('b2b_bullets') as $bullet) : ?>
                    <li><?php ameza_icon('check'); ?><span><?php echo esc_html((string)($bullet['text']??'')); ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="b2b-form-wrapper">
                <h3><?php echo esc_html((string)ameza_field('b2b_form_title')); ?></h3>
                <?php ameza_print_form('b2b'); ?>
            </div>
        </div>
    </div>
</section>

<section class="reviews">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html((string)ameza_field('reviews_title')); ?></h2>
        <p class="section-subtitle"><?php echo esc_html((string)ameza_field('reviews_subtitle')); ?></p>
        <div class="reviews-grid">
            <?php foreach ((array)ameza_field('reviews') as $review) : ?>
            <article class="review-card">
                <div class="stars" aria-label="5 из 5"><?php for($i=0;$i<5;$i++){ ameza_icon('star'); } ?></div>
                <p>«<?php echo esc_html((string)($review['quote']??'')); ?>»</p>
                <div class="author"><?php echo esc_html((string)($review['author']??'')); ?></div>
                <div class="company"><?php echo esc_html((string)($review['company']??'')); ?></div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="faq">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html((string)ameza_field('faq_title')); ?></h2>
        <p class="section-subtitle"><?php echo esc_html((string)ameza_field('faq_subtitle')); ?></p>
        <div class="faq-list">
            <?php foreach ((array)ameza_field('faqs') as $faq) : ?>
            <details class="faq-item">
                <summary class="faq-question">
                    <span><?php echo esc_html((string)($faq['question']??'')); ?></span>
                    <?php ameza_icon('chevron-down'); ?>
                </summary>
                <div class="faq-answer"><?php echo wp_kses_post(wpautop((string)($faq['answer']??''))); ?></div>
            </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="contacts" id="contacts">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html((string)ameza_field('contacts_title')); ?></h2>
        <p class="section-subtitle"><?php echo esc_html((string)ameza_field('contacts_subtitle')); ?></p>
        <div class="contacts-grid">
            <div class="contact-info">
                <h2>Контакты</h2>
                <?php
                $phone=(string)ameza_option('phone','+7 (495) 123-45-67');
                $email=(string)ameza_option('email','info@ameza.ru');
                $tg=(string)ameza_option('telegram','https://t.me/ameza_brand');
                $wa=(string)ameza_option('whatsapp','https://wa.me/74951234567');
                $address=(string)ameza_option('address','г. Москва, ул. Производственная, д. 10 (офис/склад)');
                ?>
                <?php if ($phone) : ?><div class="contact-item"><?php ameza_icon('phone'); ?><a href="tel:<?php echo esc_attr(preg_replace('/[^+0-9]/','',$phone)); ?>"><?php echo esc_html($phone); ?></a></div><?php endif; ?>
                <?php if ($email) : ?><div class="contact-item"><?php ameza_icon('mail'); ?><a href="mailto:<?php echo esc_attr(antispambot($email)); ?>"><?php echo esc_html(antispambot($email)); ?></a></div><?php endif; ?>
                <?php if ($tg) : ?><div class="contact-item"><?php ameza_icon('telegram'); ?><a href="<?php echo esc_url($tg); ?>" target="_blank" rel="noopener noreferrer">Telegram</a></div><?php endif; ?>
                <?php if ($wa) : ?><div class="contact-item"><?php ameza_icon('whatsapp'); ?><a href="<?php echo esc_url($wa); ?>" target="_blank" rel="noopener noreferrer">WhatsApp</a></div><?php endif; ?>
                <?php if ($address) : ?><div class="contact-item"><?php ameza_icon('map-pin'); ?><span><?php echo esc_html($address); ?></span></div><?php endif; ?>
                <div class="map-placeholder" role="img" aria-label="Место для карты"><span class="map-placeholder__label">Карта — подключается после подтверждения адреса</span></div>
            </div>
            <div class="contact-form">
                <h3><?php echo esc_html((string)ameza_field('contacts_form_title')); ?></h3>
                <?php ameza_print_form('contacts'); ?>
            </div>
        </div>
    </div>
</section>
</main>
<?php get_footer(); ?>
