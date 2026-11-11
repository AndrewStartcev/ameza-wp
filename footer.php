<?php defined('ABSPATH') || exit; ?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <a class="footer-logo" href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html((string)ameza_option('brand_name','AMEZA')); ?></a>
                <p class="footer-desc"><?php echo esc_html((string)ameza_option('footer_description','Производство и продажа премиальных носков. Опт и розница. Собственная фабрика полного цикла.')); ?></p>
            </div>
            <div class="footer-links">
                <h4>Навигация</h4>
                <ul>
                <?php foreach (['advantages'=>'Преимущества','assortment'=>'Продукция','about'=>'О производстве','b2b'=>'Опт','contacts'=>'Контакты'] as $id=>$label) : ?>
                    <li><a href="<?php echo esc_url(ameza_home_anchor($id)); ?>"><?php echo esc_html($label); ?></a></li>
                <?php endforeach; ?>
                </ul>
            </div>
            <div class="footer-links">
                <h4>Документы</h4>
                <ul>
                    <?php $privacy=ameza_doc_url('privacy'); $offer_id=(int)ameza_option('offer_page',0); $consent_id=(int)ameza_option('consent_page',0); ?>
                    <?php if ($privacy) : ?><li><a href="<?php echo esc_url($privacy); ?>">Политика конфиденциальности</a></li><?php endif; ?>
                    <?php if ($offer_id && get_post_status($offer_id) === 'publish') : ?><li><a href="<?php echo esc_url(get_permalink($offer_id)); ?>">Публичная оферта</a></li><?php endif; ?>
                    <?php if ($consent_id && get_post_status($consent_id) === 'publish') : ?><li><a href="<?php echo esc_url(get_permalink($consent_id)); ?>">Согласие на обработку ПД</a></li><?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© <?php echo esc_html(date_i18n('Y')); ?> AMEZA. Все права защищены.
                <?php
                $inn=(string)ameza_option('inn',''); $ogrn=(string)ameza_option('ogrn','');
                if ($inn) { echo ' ИНН ' . esc_html($inn) . '.'; }
                if ($ogrn) { echo ' ОГРН ' . esc_html($ogrn) . '.'; }
                ?>
            </p>
            <div class="footer-bottom__links">
                <?php foreach (['telegram'=>'Telegram','wildberries'=>'Wildberries','ozon'=>'Ozon'] as $key=>$label) :
                    $link=(string)ameza_option($key,$key==='telegram'?'https://t.me/ameza_brand':'');
                    if (!$link) { continue; } ?>
                    <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($label); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
