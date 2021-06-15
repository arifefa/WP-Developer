<?php
/*===================================================
CUSTOM LOGO LOGIN URL
===================================================*/
    function mb_login_url(){
        return home_url();
    }
    add_filter('login_headerurl', 'mb_login_url');

/*===================================================
CUSTOM ADD EXTERNAL CSS TO LOGO LOGIN PAGE.
===================================================*/
    function register_login_css(){
        $loginStylePath = get_stylesheet_directory_uri() . '/logo_login.css';
        echo '<link rel="stylesheet" type="text/css" href="' . $loginStylePath . '">';
    }
    add_action('login_head', 'register_login_css');

/*===================================================
CUSTOM SHORTCODE BUTTON POPUP
====================================================*/
    add_shortcode('display_popup', 'popup_rfq');
    function popup_rfq(){
        $string = '<div>
            <button style="background:rgba(229,37,53,1); color:#ffffff; cursor: pointer;" class="smallbtn tatsu-button" onclick="toggleFormQuotation()" target="_blank">Click Here</button></div>';
        return $string;
    }

/*===================================================
CUSTOM FOOTER CURENT YEAR
===================================================*/
    add_shortcode('display_custom_footer', 'custom_footer');
    function custom_footer()
    {
        $fromYear = 2020;
        $thisYear = (int) date('Y');
        $string = '<div class="CustomFooterCurrentYear"><span>Copyright ©' . $fromYear . (($fromYear != $thisYear) ? '-' . $thisYear : '. ') .
            ' Name Client. All Rights Reserved. Bug reporting & feedback, please contact us:&nbsp;' .
            '<a href="https://yourdomain.co.id/bug-reports/?web=domainclient.com" target="_blank"><u>Your Brand</u></a></span></div>';
        return $string;
    }

/*===================================================
CUSTOM SEARCH - JUST SEARCHING POST - still bug impect in dashboart
===================================================*/
	function SearchFilter($query) {
		if ($query->is_search) {
			$query->set('post_type', 'post');
		}
		return $query;
	}
    add_filter('pre_get_posts','SearchFilter');
    
/*===================================================
CUSTOM FORCE ALT
===================================================*/
    function add_alt_tags($content)
    {
        global $post;
        preg_match_all('/<img (.*?)\/>/', $content, $images);
        if(!is_null($images))
        {
            foreach($images[1] as $index => $value)
            {
                if(!preg_match('/alt=/', $value))
                {
                    $new_img = str_replace('<img', '<img alt="'.$post->post_title.'"', $images[0][$index]);
                    $content = str_replace($images[0][$index], $new_img, $content);
                }
            }
        }
        return $content;
    }
    add_filter('the_content', 'add_alt_tags', 99999);
    
/*===================================================
CUSTOM - GET CURRENT TEAMPLATE
===================================================*/
    function show_template()
    {
        if (is_super_admin()) {
            global $template;
            print_r($template);
        }
    }
    add_action('wp_footer', 'show_template');
    
/*===================================================
CUSTOM - CONFIGURASI API
===================================================*/    
    add_shortcode('display_api', 'custom_api');
    function custom_api()
        {
            $domains = json_decode(file_get_contents('https://api.example.com/hehe'));
            ?>
            <div class="row">
                <?php foreach($domains as $domain) { ?>
                <div class="col iniCustom">
                    <?php echo $domain->name ?>
                </div>
                <?php } ?>
            </div>
            <?php
        }
    
/*===================================================
WOOCOMERCE - CUSTOM AUTO CENCELING ORDER WHEN AFTER 1 HOUR
===================================================*/
    add_action( 'restrict_manage_posts', 'cancel_unpaid_orders' );
    function cancel_unpaid_orders() {
    global $pagenow, $post_type;
    // Enable the process to be executed daily when browsing Admin order list
    if( 'shop_order' === $post_type && 'edit.php' === $pagenow) {// && get_option( unpaid_orders_daily_process' ) < time()
        )
        { // Get unpaid orders (5 days old) $unpaid_orders=(array) wc_get_orders( array( // 'limit'=> -1,
        'status' => 'on-hold',
        'date_created' => '<' . ( time() - (60 * 60) ),//menit * detik, 60menit=1 jam ) ); if ( sizeof($unpaid_orders)> 0 )
            {

            $cancelled_text = __("The order was cancelled due to no payment from customer.", "woocommerce");
            // Loop through orders
            foreach ( $unpaid_orders as $order ) {
            $order->update_status( 'cancelled', $cancelled_text );
            }
            }
            }
        }    
    }

/*===================================================
WOOCOMERCE - RENAME TABS PRODUCT
===================================================*/
    add_filter('woocommerce_product_tabs', 'woo_rename_tabs', 98);
    function woo_rename_tabs($tabs)
    {
        $tabs['description']['title'] = __('DESKRIPSI');
        $tabs['additional information']['title'] = __('SPESIFIKASI');
        return $tabs;
    }

/*===================================================
WOOCOMERCE - CHANGE BREADCRUMB HOME TO PRODUCT  
===================================================*/
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

/*===================================================
WOOCOMERCE - BREADCRUMB  
===================================================*/
    // breadcrumb yoast
    add_shortcode('display_custom_breadcrumb', 'custom_breadcrumb');
    function custom_breadcrumb()
    {
        if (function_exists('yoast_breadcrumb')) {
    yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
        }
    }

    // breadcrumb woocomerce
    add_shortcode('display_custom_breadcrumb', 'woocommerce_breadcrumb');
     
?>