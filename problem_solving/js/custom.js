<script>
	// CHANGE TAG HTML
        $('.thisclass').replaceWith('<p class="thisclass">' + $('.thisclass').html() +'</p>')

	// CHANGE TAG HTML VERSI 2
		var attrs = {};

		$.each($(".home .exp-post-title")[0].attributes, function(idx, attr) {
		attrs[attr.nodeName] = attr.nodeValue;
		});

		$(".home .exp-post-title").replaceWith(function () {
			return $("<p />", attrs).append($(this).contents());
		});

    // CHANGE ATRIBUTE AHREF
        $(document).ready(function(){
		$("[href='https://google.com']").attr("href", "https://google.com/new");
        });

    // CHANGE ATRIBUTE BY ID
        $("#iniID a").attr("href", "https://google.com");

	// ALT TO ALL IMG:
		$('#map_canvas > img').attr('alt', 'Alternative text');

	// ALT text to images that does not have alt attribute:
		$('#map_canvas > img:not([alt])').attr('alt', 'Alternative text');

	// ADD VALUE BY ATTRIBUT NAME
	    $( "[name='nama']" ).val("Hello bro");

	// PLACEHOLDER
		placeholder="Name :&#10;Kota :&#10;Email :&#10;Komontar :"
		jquery("#comment").attr("placeholder", "Name :&#10;Kota :&#10;Email :&#10;Komontar :");
		jQuery("#comment").attr("placeholder", " Name : \n Kota : \n Email : \n KomEntar :");
		jQuery('#comment').val(' Name : \n Kota : \n Email : \n Komentar :');

</script>