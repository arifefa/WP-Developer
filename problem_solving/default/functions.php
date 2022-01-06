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

/*==========================================================
// CUSTOM GET TITLE CATEGORY & GET TITLE POST 
==========================================================*/
    add_shortcode('displayTitleCategory', 'custom_title_category');
    function custom_title_category()
    {
        return single_cat_title('', false);
    }

    add_shortcode('displayTitlePost', 'custom_title_post');
    function custom_title_post()
    {
        return get_the_title();
    }

/*==========================================================
// GSAP INIT
==========================================================*/
    function call_script()
    {
        wp_enqueue_script('scrolltrigger', get_stylesheet_directory_uri() . '/assets/js/ScrollTrigger.min.js', array(), false, true);

        wp_enqueue_script('gsap', get_stylesheet_directory_uri() . '/assets/js/gsap.min.js', array(), false, true);

        wp_enqueue_script('animation', get_stylesheet_directory_uri() . '/assets/js/animation_script.js', array(), false, true);

        wp_enqueue_script('custom', get_stylesheet_directory_uri() . '/assets/js/custom_script.js', array(), false, true);
    }
    add_action('wp_enqueue_scripts', 'call_script');

/*==========================================================
// REDIRECT AFTER LOGIN
==========================================================*/
    function ts_redirect_login()
    {
        return get_permalink(get_option('woocommerce_myaccount_page_id'));
    }

    add_filter('woocommerce_login_redirect', 'ts_redirect_login');


/*==========================================================
// ADD SCRIPT FOR DEALER RESMI FEATURE
==========================================================*/
    require_once('custom-portfolio-filter/scripts.php');

    add_action('wpcf7_init', function (){
        wpcf7_add_form_tag( 'country' , 'cf7_ip_to_country_form_tag' );
    }); 
    function cf7_ip_to_country_form_tag($tag){
        // https://ipstack.com API
        $api_key = '09d09b242197f1c936148f030ebc82e8';
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
        }
        // Get API Response
        $url = 'http://api.ipstack.com/' . $ipAddress . '?access_key=' . $api_key;    
        $response = wp_remote_get($url);
        $body = json_decode(wp_remote_retrieve_body($response));

        return '<input type="text" name="country" value="'.$body->country_name.'" placeholder="'.$body->country_name.'">';
    }

/*==========================================================
// GET IP ADDRESS FOR CONTACT FORM 7
==========================================================*/
    function get_ipAdress() {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }
    
    add_action('wpcf7_init', function (){
        wpcf7_add_form_tag( 'country' , 'cf7_ip_to_country_form_tag' );
    }); 
    
    function cf7_ip_to_country_form_tag($tag){
        // https://ipstack.com or https://ipgeolocation.io/ for get API
        $api_key = '09d09b242197f1c936148f030ebc82e8';
        $ipAddress = get_ipAdress();
        // Get API Response
        $url = 'http://api.ipstack.com/' . $ipAddress . '?access_key=' . $api_key;    
        $response = wp_remote_get($url);
        $body = json_decode(wp_remote_retrieve_body($response));
    
        return '<input type="text" name="country" value="'.$body->country_name.'" placeholder="'.$body->country_name.'">';
    }

/*==========================================================
// CALL CUSTOM SCRIPT N CSS - AUTO VERSIONING
==========================================================*/
    function add_timestamp_to_childtheme_stylesheet() {
        wp_dequeue_style( 'flatsome-style' );
        wp_deregister_style( 'flatsome-style' );
        wp_enqueue_style('flatsome-style', get_stylesheet_uri().'?'.filemtime(get_stylesheet_directory().'/style.css'), array(), null);
    }
    add_action( 'wp_print_styles', 'add_timestamp_to_childtheme_stylesheet' );

    function call_script() {
        wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/assets/js/custom_script.js', array( 'jquery' ), filemtime(get_stylesheet_directory() . '/assets/js/custom_script.js'), true);
        wp_enqueue_script('gsap', get_stylesheet_directory_uri() . '/assets/js/gsap.min.js', array(), false, true);
        wp_enqueue_script('gsap-script', get_stylesheet_directory_uri() . '/assets/js/gsap_script.js', array(), filemtime(get_stylesheet_directory() . '/assets/js/gsap_script.js'), true);
    }
    add_action( 'wp_enqueue_scripts', 'call_script' );

?>