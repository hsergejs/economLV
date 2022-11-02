// JavaScript Document
$(document).ready(function() {
						   
						   url = $("a.modokn").attr('href').replace("messages_r_nosrc","messages_r");
$("a.modokn").attr("href", url);

						   
    $("a.modokn").fancybox({"padding" : 20/*,"frameWidth" : 600,"frameHeight" : 400*/});
});