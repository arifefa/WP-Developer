<!-- flatsome  -->

<div class="box-text <?php echo flatsome_product_box_text_class(); ?>">
    <?php
    do_action('woocommerce_before_shop_loop_item_title');

    echo '<p class="customCategory">';
    echo wc_get_product_category_list($product->get_id());
    echo '</p>';
    echo '<div class="title-wrapper titleCategory">';
    // do_action('woocommerce_shop_loop_item_title'); -> default code 
    // <start_iniCustom>
    ?>
    <p style="color:#ffffff;">
        <a href="<?php echo get_page_link(); ?>">
            <?php
            echo get_the_title();
            ?>
        </a>
    </p>
    <?php
    // <end_iniCustom>
    echo '</div>';

    echo '<div class="price-wrapper">';
    do_action('woocommerce_after_shop_loop_item_title');
    echo '</div>';

    do_action('flatsome_product_box_after');
    ?>

</div>