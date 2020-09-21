
<script>
	jQuery(document).ready(function(){
		jQuery(".chaty-widget-i").click(function () {
			jQuery("#chaty-channel-custom_link a").attr("href", "https://api.whatsapp.com/");
		});
	});

	jQuery(document).ready(function(){
		jQuery("[href='https://web.whatsapp.com/send?phone=6281234567']").attr("href", "https://api.whatsapp.com/send?phone=6281234567&text=Hi%2C%");
	});
</script>