//Show-Hiden Advanced
jQuery(function ($) {$(document).ready(function(){
		$('#show_hide').click(function(){
			$("#advanced").toggle();
		});
	});});
//Show-Hiden WTF
jQuery(function ($) {$(document).ready(function(){
		$('#wtf-id').click(function(){
			$("#tip-id").toggle();
		});
	});});
	
jQuery(function ($) {$(document).ready(function(){
		$('#wtf-type').click(function(){
			$("#tip-type").toggle();
		});
	});});
	
jQuery(function ($) {$(document).ready(function(){
		$('#wtf-token').click(function(){
			$("#tip-token").toggle();
		});
	});});
jQuery(function ($) {
	$('.content').hide();
      $('.open').click(function(){
        $(this).parent('.pageid').next('.content').slideToggle(50);
    });
});