<?php
/*=========================================================
DISABLE AUTO UPDATE ALL PLUGIN
=========================================================*/	
    add_filter( 'auto_update_plugin', '__return_false' );

/*=========================================================
DISABLE AUTO UPDATE IN ALL THEME 
=========================================================*/	  
    add_filter( 'auto_update_theme', '__return_false' );    
    
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
CUSTOM - CONFIGURATION API
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

/*==========================================================
// NOTIF LIMIT EMAIL CF7 GET DATABASE CFDB7
==========================================================*/
    add_filter( 'wpcf7_validate', 'email_already_in_cfdb7', 10, 2 );
    function email_already_in_cfdb7 ( $result, $tags ) {
        //changed variable
        $email_field_name ='your-email';
        $form_post_id = 219;
        $notice_message = 'Your email already in use';
        
        //get email from input form
        $form  = WPCF7_Submission::get_instance();
        $email = $form->get_posted_data($email_field_name);
        
        //get email from database
        global $wpdb;
        $datas = array();
        //query
        $get_db = $wpdb->get_results("SELECT form_value FROM wp_db7_forms WHERE form_post_id = $form_post_id");
        //selection email from dump
        $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
        foreach ($get_db as $index => $data) {
            preg_match_all($pattern, $data->form_value , $matches);
            $datas[$index] = $matches[0][0];
        }
        //validate email
        foreach ($datas as $index => $data) {
            if( $data == $email ){
                $result->invalidate($email_field_name, $notice_message);
            }
        }
        //return result
        return $result;
    }    

/*==========================================================
SET UPLOAD SIZE MAX 300kb
==========================================================*/
    add_filter( 'upload_size_limit', 'set_max_upload' );
    function set_max_upload( $bytes ){
        return 307200; //300kb
    }

/*==========================================================
CUSTOM MODIF READ MORE
==========================================================*/
    function modify_read_more_link() {
        return '<a class="more-link" href="' . get_permalink() . '">Your Read More Link Text</a>';
    }
    add_filter( 'the_content_more_link', 'modify_read_more_link' );

/*=========================================================
ADD CUSTOM POST TYPE
=========================================================*/	
	function custom_post_type_project(){
		$labels=array(
			'menu_icon' => 'dashicons-category',
			'name' => 'Project',
			'singular_name' => 'Project',
			'add_new' => 'Add Project',
			'add_item' => 'Add item',
			'add_new_item' => 'Add new project',
			'all_items' => 'All Project',
			'edit_item' => 'Edit Project',
			'view_item' => 'View project',
			'search_item' => 'Search item',
			'not_found' => 'No items found',
			'not_found_in_trash' => 'No items found in trash',
			'parent_item_colon' => 'Add new project item'
		);
		$args=array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'pubicly_queryable' => true,
			'query_var' => true,
			'rewrite' => true,
			'pubicly_queryable' => true,
			'hierarchical' => false,
			'capabity_type' => 'post',
			'supports' => array(
				'title',
				'thumbnail',
				'editor',
				'excerpt',
				'comment'),
			// 'taxonomies' => array('category','post_tag'), //-> this is default post
			'menu_position' => null,
			'exclude_from_search' =>false
		);
		register_post_type('Project',$args);
	};
	add_action('init','custom_post_type_project');

/*=========================================================
ADD CUSTOM TAXONOMY
=========================================================*/	
    function custom_taxonomy_project_a() {
        $labels=array(
            'name' => 'types',
            'singular_name' => 'type',
            'search_items' => 'Search type',
            'all_items' => 'All item',
            'parent_item' => 'Parent item',
            'parent_item_colon' => 'Parent item',
            'edit_item' => 'Edit item',
            'update_item' => 'Update item',
            'add_new_item' => 'Add new type',
            'new_item_name' => 'Add new item name',
            'menu_name' => 'Type Project',
        );
        $args=array(
            'labels' => $labels,
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'type' ),
        );
        //name taxonomy, name custom post type, argument
        register_taxonomy('type',array('project'),$args);
    }
    add_action( 'init', 'custom_taxonomy_project_a' );  

    function custom_taxonomy_project_b() {
        $labels=array(
            'name' => 'Tags',
            'singular_name' => 'tag',
            'search_items' => 'Search tag',
            'all_items' => 'All item',
            'parent_item' => 'Parent item',
            'parent_item_colon' => 'Parent item',
            'edit_item' => 'Edit item',
            'update_item' => 'Update item',
            'add_new_item' => 'Add new tag',
            'new_item_name' => 'Add new tag name',
            'menu_name' => 'Tag Project',
        );
        $args=array(
            'labels' => $labels,
            // 'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'tag' ),
        );
        //type,name custom post type,argument
        register_taxonomy('tag',array('project'),$args);
    }
    add_action( 'init', 'custom_taxonomy_project_b' );

/*=========================================================
ADD SHORTCODE TO SHOW ALL POST TYPE PROJECT
=========================================================*/	
    add_shortcode( 'display_project', 'display_custom_post_type_project' );
    function display_custom_post_type_project(){
        $args = array(
            'post_type' => 'project',
			'post_status' => 'publish',
			'posts_per_page' => 6
        );

        $string = '';
        $query = new WP_Query( $args );
        if( $query->have_posts() ){

            $string .= '<div class="exp-post-thumb">';
            while( $query->have_posts() ){
                $query->the_post();
                $string .= '<article>';
                $string .= '<div class="exp-post-details">';
                $string .= '<div class="exp-post-title-meta">';
								 $string .= '<h1 class="exp-post-title">' . get_the_title() . '</h1>';
								 $string .= '<p>'.get_post().'</p>';
                $string .= '</div>';
                $string .= '</div>';
                $string .= '</article>';
            }
            $string .= '</div>';
        }
        wp_reset_postdata();
        return $string;
    }


/*===================================================
WOOCOMMERCE - new / custom order status
===================================================*/
// register (add) a new post status
add_action( 'init', 'register_custom_post_status', 10 );
function register_custom_post_status() {
    register_post_status( 'wc-awaiting-shipment', array(
        'label'                     => 'Proses Pengiriman',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Proses Pengiriman <span class="count">(%s)</span>', 'Proses Pengiriman <span class="count">(%s)</span>', 'woocommerce' )
    ) );

}

// style for custom order status label in admin side
add_action('admin_head', 'shipment_label_css');
function shipment_label_css() {
  echo '<style>
    .status-awaiting-shipment{
        background: #e6f3b2;
        color: #899b41;
    } </style>';
}

// add in detail order item select box and sorting them
add_filter( 'wc_order_statuses', 'custom_wc_order_statuses' );
function custom_wc_order_statuses( $order_statuses ) {
    $sorted_order_statuses = [];
    foreach( $order_statuses as $key => $label ) {
        $sorted_order_statuses[$key] = $order_statuses[$key];
        if( 'wc-processing' === $key ){
            $sorted_order_statuses['wc-awaiting-shipment'] = 'Proses Pengiriman';
        }
    }
    return $sorted_order_statuses;
}
// add in admin order list bulk dropdown
add_filter( 'bulk_actions-edit-shop_order', 'custom_dropdown_bulk_actions_shop_order', 20, 1 );
function custom_dropdown_bulk_actions_shop_order( $actions ) {
    $new_actions = array();
    // add new order status before processing
    foreach ($actions as $key => $action) {
        if ('mark_on-hold' === $key) {
            $new_actions['mark_awaiting-shipment'] = 'Ubah status ke proses pengiriman';
        }
        $new_actions[$key] = $action;
    }
    return $new_actions;
}
/*===================================================
 WOOCOMMERCE - add custom field (resi) in order (admin side)
===================================================*/
add_action( 'woocommerce_admin_order_data_after_order_details', 'custom_woocommerce_admin_order_data_after_order_details' );
function custom_woocommerce_admin_order_data_after_order_details( $order ){
?>
    <br class="clear" />
    <h4>Lain-lain</h4>
    <?php $custom_field_value = get_post_meta( $order->id, 'wc_no_resi', true ); ?>
    <div>
    <?php
        woocommerce_wp_text_input( array(
            'id' => 'wc_no_resi',
            'label' => 'Nomor Resi:',
            'value' => $custom_field_value,
            'wrapper_class' => 'form-field-wide'
        ) );
    ?>
    </div>
<?php
}

//save meta & send email
add_action( 'woocommerce_process_shop_order_meta', 'custom_woocommerce_process_shop_order_meta' );
function custom_woocommerce_process_shop_order_meta( $order_id ){
    //init var
    $order = wc_get_order( $order_id );
    $text_resi_old = get_post_meta( $order->id, 'wc_no_resi', true );
    //update meta
    update_post_meta( $order_id, 'wc_no_resi', wc_sanitize_textarea( $_POST[ 'wc_no_resi' ] ) );
    //send email
    $text_resi = wc_sanitize_textarea( $_POST[ 'wc_no_resi' ] );
    if(!empty($text_resi)){
        if($text_resi!=$text_resi_old){
            $mailer = WC()->mailer();
            $text_order_id = '#'.$order_id;
            $shipping_method = $order->get_shipping_method();
            $billing_name = $order->get_billing_first_name();
            // customer email
            $to = $order->get_billing_email();
            // email subject
            $subject = 'Update Resi Pesanan '.$text_order_id;
            //email message
            $message_body = 'Hai '.$billing_name.',<br><br>Resi untuk pesanan Anda (<span style="color:#ad000059"><strong>'.$text_order_id.'</strong></span>) telah diperbarui dengan nomor resi <span style="background-color:#ad000059;color:white;font-weight:bold;padding: 1px 4px;letter-spacing: 1px;">'.$text_resi.'</span> dan menggunakan pengiriman '.$shipping_method.'.';
            // email massage head
            $message = $mailer->wrap_message( 'Update Resi Pesanan '.$text_order_id, $message_body );
            // header type
            $headers = 'Content-Type: text/html\r\n';
            // sending email
            $mailer->send( $to, $subject, $message, $headers);
        }
    }
}

/*===================================================
 WOOCOMMERCE - email notification for custom order status
===================================================*/
// enable the action
add_filter( 'woocommerce_email_actions', 'filter_woocommerce_email_actions' );
function filter_woocommerce_email_actions( $actions ){
    $actions[] = 'woocommerce_order_status_wc-awaiting-shipment';
    return $actions;
}
// send email order status changed to awaiting-shipment
add_action('woocommerce_order_status_changed', 'shipped_status_custom_notification', 10, 4);
function shipped_status_custom_notification( $order_id, $from_status, $to_status, $order ) {
    if(  'awaiting-shipment' === $to_status ) {
        $mailer = WC()->mailer();
        $text_order_id = '#'.$order->get_id();
        $shipping_method = $order->get_shipping_method();
        // customer email
        $to = $order->get_billing_email();
        // email subject
        $subject = 'Proses Pengiriman Pesanan '.$text_order_id;
        //email message
        $message_body = 'Hai '.$order->get_billing_first_name().',<br><br>Status pesanan Anda (<span style="color:#ad000059"><strong>'.$text_order_id.'</strong></span>) telah diperbarui dan dalam <span style="color:green;"><strong>proses pengiriman</strong></span> menggunakan '.$shipping_method.'.';
        // email massage head
        $message = $mailer->wrap_message( 'Proses Pengiriman Pesanan #'.$order->get_id(), $message_body );
        // header type
        $headers = 'Content-Type: text/html\r\n';
        // sending email
        $mailer->send( $to, $subject, $message, $headers);
    }
}
 
/*===================================================
 WOOCOMMERCE - set time a week for awating-shipment order status change to completed
===================================================*/
add_action('init', 'wp_orders');
function wp_orders(){
    global $wpdb;
    $results = $wpdb->get_results("SELECT * FROM  $wpdb->posts WHERE post_type = 'shop_order' AND post_status = 'wc-awaiting-shipment'");
    foreach ($results as $result) {
        $date1 = $result->post_modified_gmt;       
        $order_id = $result->ID;
        $date2=date("Y-m-d h:i:s");

        $dteStart = new DateTime($date1);
        $dteEnd   = new DateTime($date2);
        $dteDiff  = $dteStart->diff($dteEnd);
        $Diff = $dteDiff->format("%d");
        $int = (int)$Diff;
        if($int>=7){
            $order = new WC_Order($order_id);
            if (!empty($order)) {
                $order->update_status( 'wc-completed' );
            }
        }
    }
}

?>