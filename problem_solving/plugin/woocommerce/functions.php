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


/*==========================================================
// CHANGE BREADCRUMB HOME TO PRODUCT  
==========================================================*/
add_filter('woocommerce_breadcrumb_home_url', 'woo_custom_breadrumb_home_url');
function woo_custom_breadrumb_home_url()
{
    return '/products/';
}

add_filter('woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_home_text', 20);
function wcc_change_breadcrumb_home_text($defaults)
{
    // Change the breadcrumb home text from 'Home' to 'Products'
    $defaults['home'] = 'Products';
    return $defaults;
}