<script> // second page

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"), results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

var mapdiv = jQuery("#mapdiv");
var addr = getParameterByName("street")+" "+getParameterByName("citystate");
var encoded = encodeURI(addr);
mapdiv.html('<iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyB3BASLanTRik25irkt95qEhMyENR9woOw&q='+encoded+'" allowfullscreen></iframe>');

jQuery("#addr-big").html(addr);

var valsArr = ["val", "lo", "hi", "lsd", "lsp", "beds", "baths", "sqft"];

var hasData = false;
	
for (i = 0; i < valsArr.length; i++) {

	var theValue = getParameterByName(valsArr[i]);

	if (theValue != "") {

		jQuery("#"+valsArr[i]).css("display","block");
		
		if (valsArr[i] == "val" || valsArr[i] == "lo" || valsArr[i] == "hi" || valsArr[i] == "lsp") {
			theValue = numberWithCommas(theValue);
			hasData = true;
		}

		jQuery("#"+valsArr[i]+" span").html(theValue);
		
	}

}
	
if (!hasData) {
	jQuery("#no-data").css("display","block");
	jQuery("#input_35_7").val("true");
}

var aFormSubmitted = false;
	
jQuery(document).bind("gform_confirmation_loaded", function(){
	if (!aFormSubmitted) {
		jQuery(".special-info, .special-info-challenge").css("display","block");
		jQuery("html,body").scrollTop(0);
		ga("send", "event", "Home Valuation Lead");
		fbq("track", "CompleteRegistration", {
			content_name: "Home Valuation Lead"
		});
	}
	aFormSubmitted = true;
});


jQuery("#input_35_8").change(function() { // name
	jQuery("#input_36_2").val(jQuery("#input_35_8").val());
});
jQuery("#input_35_5").change(function() { // email
	jQuery("#input_36_4").val(jQuery("#input_35_5").val());
});
jQuery("#input_35_9").change(function() { // phone
	jQuery("#input_36_5").val(jQuery("#input_35_9").val());
});

</script>