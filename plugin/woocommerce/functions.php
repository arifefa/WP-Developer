<?php

/*==========================================================
// CUSTOM RENAME TABS PRODUCT
==========================================================*/
add_filter('woocommerce_product_tabs', 'woo_rename_tabs', 98);
function woo_rename_tabs($tabs)
{
    $tabs['description']['title'] = __('DESKRIPSI');
    $tabs['additional information']['title'] = __('SPESIFIKASI');
    return $tabs;
}