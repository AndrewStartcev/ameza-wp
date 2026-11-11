<?php
defined('ABSPATH') || exit;
$brand = ameza_brand_html();
$footer_description = trim((string)ameza_option('footer_description'));
$has_footer_nav = has_nav_menu('footer');
$privacy_url = ameza_doc_url('privacy');
$offer_id = (int)ameza_option('offer_page');
$consent_id = (int)ameza_option('consent_page');
$offer_url = $offer_id && get_post_status($offer_id) === 'publish' ? get_permalink($offer_id) : '';
$consent_url = $consent_id && get_post_status($consent_id) === 'publish' ? get_permalink($consent_id) : '';
$has_documents = $privacy_url || $offer_url || $consent_url;

$company_name = trim((string)ameza_option('company_name'));
$brand_name = trim((string)ameza_option('brand_name'));
$inn = trim((string)ameza_option('inn'));
$ogrn = trim((string)ameza_option('ogrn'));
$socials = [];
foreach (['telegram'=>'Telegram', 'wildberries'=>'Wildberries', 'ozon'=>'Ozon'] as $key => $name) {
    $url = trim((string)ameza_option($key));
    if ($url) {
        $socials[] = ['url'=>$url, 'name'=>$name];
    }
}
?>
<footer class="site-footer">
    <div class="container">
        <?php if ($brand !== '' || $footer_description || $has_footer_nav || $has_documents) : ?>
        <div class="footer-grid">
            <?php if ($brand !== '' || $footer_description) : ?>
            <div class="footer-brand">
                <?php if ($brand !== '') : ?>
                <a class="footer-logo" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php echo $brand; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </a>
                <?php endif; ?>
                <?php if ($footer_description) : ?><p class="footer-desc"><?php echo esc_html($footer_description); ?></p><?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if ($has_footer_nav) : ?>
            <nav class="footer-links" aria-label="Навигация в подвале">
                <h4>Навигация</h4>
                <?php wp_nav_menu(['theme_location'=>'footer', 'container'=>false, 'menu_class'=>'footer-links__list', 'depth'=>1]); ?>
            </nav>
            <?php endif; ?>
            <?php if ($has_documents) : ?>
            <div class="footer-links">
                <h4>Документы</h4>
                <ul>
                    <?php if ($privacy_url) : ?><li><a href="<?php echo esc_url($privacy_url); ?>">Политика конфиденциальности</a></li><?php endif; ?>
                    <?php if ($offer_url) : ?><li><a href="<?php echo esc_url($offer_url); ?>">Публичная оферта</a></li><?php endif; ?>
                    <?php if ($consent_url) : ?><li><a href="<?php echo esc_url($consent_url); ?>">Согласие на обработку ПД</a></li><?php endif; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if ($brand_name || $company_name || $inn || $ogrn || $socials) : ?>
        <div class="footer-bottom">
            <?php if ($brand_name || $company_name || $inn || $ogrn) : ?>
            <p>© <?php echo esc_html(date_i18n('Y')); ?>
                <?php if ($company_name || $brand_name) : ?><?php echo esc_html($company_name ?: $brand_name); ?>.<?php endif; ?>
                <?php if ($inn) : ?> ИНН <?php echo esc_html($inn); ?>.<?php endif; ?>
                <?php if ($ogrn) : ?> ОГРН <?php echo esc_html($ogrn); ?>.<?php endif; ?>
            </p>
            <?php endif; ?>
            <?php if ($socials) : ?>
            <div class="footer-bottom__links">
                <?php foreach ($socials as $social) : ?>
                <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($social['name']); ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
