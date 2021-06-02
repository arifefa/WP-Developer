
// CHANGE TAG HTML
$('.thisclass').replaceWith('<p class="thisclass">' + $('.thisclass').html() + '</p>')

// CHANGE TAG HTML VERSI 2
var attrs = {};

$.each($(".home .exp-post-title")[0].attributes, function (idx, attr) {
	attrs[attr.nodeName] = attr.nodeValue;
});

$(".home .exp-post-title").replaceWith(function () {
	return $("<p />", attrs).append($(this).contents());
});

// CHANGE ATRIBUTE AHREF
$(document).ready(function () {
	$("[href='https://google.com']").attr("href", "https://google.com/new");
});

// CHANGE ATRIBUTE BY ID
$("#iniID a").attr("href", "https://google.com");

// ALT TO ALL IMG:
$('#map_canvas > img').attr('alt', 'Alternative text');

// ALT text to images that does not have alt attribute:
$('#map_canvas > img:not([alt])').attr('alt', 'Alternative text');

// ADD VALUE BY ATTRIBUT NAME
$("[name='nama']").val("Hello bro");

// PLACEHOLDER
placeholder = "Name :&#10;Kota :&#10;Email :&#10;Komontar :"
jquery("#comment").attr("placeholder", "Name :&#10;Kota :&#10;Email :&#10;Komontar :");
jQuery("#comment").attr("placeholder", " Name : \n Kota : \n Email : \n KomEntar :");
jQuery('#comment').val(' Name : \n Kota : \n Email : \n Komentar :');

// BREADCRUMB YOAST
add_shortcode('display_custom_breadcrumb', 'custom_breadcrumb');
function custom_breadcrumb() {
	if (function_exists('yoast_breadcrumb')) {
		yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
	}
}

breadcrumb woocomerce
add_shortcode('display_custom_breadcrumb', 'woocommerce_breadcrumb');


//SPESIFIC FOOTER
if (jQuery(".pageAbout").length || jQuery(".pageContact").length || jQuery(".pageFaq").length) {
	jQuery(".footerGlobal").css("display", "none");
	jQuery(".footerHome").css("display", "block");
}

//WOOCOMEERCE - auto update quantity cart
var timeout;
jQuery(function ($) {
	$('.woocommerce').on('change', 'input.qty', function () {
		if (timeout !== undefined) {
			clearTimeout(timeout);
		}
		timeout = setTimeout(function () {
			$("[name='update_cart']").trigger("click");
		}, 1000);
	});
});



