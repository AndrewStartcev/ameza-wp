<?php
defined('ABSPATH') || exit;
$brand = ameza_brand_html();
$footer_description = trim((string)ameza_option('footer_description'));
$has_footer_nav = has_nav_menu('footer');
$legal_links = [];
foreach ([
    'privacy-policy' => 'Политика конфиденциальности',
    'public-offer' => 'Публичная оферта',
    'personal-data-consent' => 'Согласие на обработку ПД',
] as $slug => $label) {
    $page = get_page_by_path($slug, OBJECT, 'page');
    if (!$page instanceof WP_Post || $page->post_status === 'trash') {
        continue;
    }
    $legal_links[] = [
        'title' => $label,
        'url' => $page->post_status === 'publish' ? get_permalink($page) : '',
    ];
}
$has_documents = !empty($legal_links);

$company_name = trim((string)ameza_option('company_name'));
$brand_name = trim((string)ameza_option('brand_name'));
$inn = trim((string)ameza_option('inn'));
$ogrn = trim((string)ameza_option('ogrn'));
$socials = [];
$links = ameza_option('social_links');
foreach (is_array($links) ? $links : [] as $link) {
    if (!is_array($link)) { continue; }
    $label = trim((string)($link['label'] ?? ''));
    if ($label === '') { continue; }
    $url = trim((string)($link['url'] ?? ''));
    // Text field is flexible, but malformed and placeholder links never become live anchors.
    if (!preg_match('~^https?://~i', $url)) {
        $url = '';
    }
    $socials[] = ['name'=>$label, 'url'=>$url];
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
                    <?php foreach ($legal_links as $document) : ?>
                    <li>
                        <?php if ($document['url']) : ?>
                        <a href="<?php echo esc_url($document['url']); ?>"><?php echo esc_html($document['title']); ?></a>
                        <?php else : ?>
                        <span class="footer-links__pending" title="Ссылка появится после публикации документа"><?php echo esc_html($document['title']); ?></span>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
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
                <?php if ($social['url']) : ?>
                <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($social['name']); ?></a>
                <?php else : ?>
                <span class="footer-bottom__pending" title="Ссылка ещё не указана в настройках"><?php echo esc_html($social['name']); ?></span>
                <?php endif; ?>
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
