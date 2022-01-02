jQuery( document ).ready(function() {
	jQuery(window).on('load', function () {
	    var $preloader = jQuery('.preloader');
	    $preloader.delay(350).fadeOut('slow');
	});

	jQuery(window).on('load resize', function() {
		jQuery('.section .cell').css('height', jQuery(window).height());
		jQuery('.section1 img').each(function(){
			jQuery(this).css('max-height', jQuery(window).height()-jQuery(this).parents('.section1').find('.heading').outerHeight()-jQuery(this).parents('.section1').find('.button').outerHeight()-40-jQuery('.ypromo-site-bar').height());
		});
		jQuery('.section2 img').each(function(){
			jQuery(this).css('max-height', jQuery(window).height()-jQuery(this).parents('.section2').find('.heading').outerHeight()-jQuery(this).parents('.section2').find('.button').outerHeight()-70-jQuery('.ypromo-site-bar').height());
		});
		jQuery('.section3 img').each(function(){
			jQuery(this).css('max-height', jQuery(window).height()-jQuery(this).parents('.section3').find('.heading').outerHeight()-jQuery(this).parents('.section3').find('.button').outerHeight()-40-jQuery('.ypromo-site-bar').height());
		});
		jQuery('.section4 img').each(function(){
			jQuery(this).css('max-height', jQuery(window).height()-jQuery(this).parents('.section4').find('.heading').outerHeight()-jQuery(this).parents('.section4').find('.button').outerHeight()-40-jQuery('.ypromo-site-bar').height());
		});
		jQuery('.section5 img').each(function(){
			jQuery(this).css('max-height', jQuery(window).height()-jQuery(this).parents('.section5').find('.heading').outerHeight()-jQuery(this).parents('.section5').find('.button').outerHeight()-jQuery('.ypromo-site-bar').height());
		});
		jQuery('.section6 img').each(function(){
			jQuery(this).css('max-height', jQuery(window).height()-jQuery(this).parents('.section6').find('.heading').outerHeight()-jQuery(this).parents('.section6').find('.button').outerHeight()-20-jQuery('.ypromo-site-bar').height());
		});
		jQuery('.section7 .space').each(function(){
			jQuery(this).css('height', jQuery(window).height()-jQuery(this).parents('.section7').find('.heading').outerHeight()-jQuery(this).parents('.section7').find('.button').outerHeight()-40-jQuery('.ypromo-site-bar').height());
		});
		jQuery('.section8 img').each(function(){
			jQuery(this).css('max-height', jQuery(window).height()-jQuery(this).parents('.section8').find('.heading').outerHeight()-jQuery(this).parents('.section8').find('.button').outerHeight()-30-jQuery('.ypromo-site-bar').height());
		});
		jQuery('.section9 .space').each(function(){
			jQuery(this).css('height', jQuery(window).height()-jQuery(this).parents('.section9').find('.heading').outerHeight()-jQuery(this).parents('.section9').find('.button').outerHeight()-40-jQuery('.ypromo-site-bar').height());
		});
		jQuery('.section11 .col1 img').each(function(){
			jQuery(this).css('max-height', jQuery(window).height()-jQuery(this).parents('.section11').find('.heading').outerHeight()-jQuery(this).parents('.section11').find('.logos').outerHeight()-jQuery(this).parents('.section11').find('.button').outerHeight()-30-jQuery('.ypromo-site-bar').height());
		});
		jQuery('.section11 .col2 img').each(function(){
			jQuery(this).css('max-height', jQuery(window).height()-jQuery(this).parents('.section11').find('.button').outerHeight()-30-jQuery('.ypromo-site-bar').height());
		});
		jQuery('.section12 .image').each(function(){
			jQuery(this).css('height', jQuery(window).height()-jQuery(this).parents('.section12').find('.heading').outerHeight()-jQuery(this).parents('.section12').find('.button').outerHeight()-40-jQuery('.ypromo-site-bar').height());
		});
		jQuery('.section13 img').each(function(){
			jQuery(this).css('max-height', jQuery(window).height()-jQuery(this).parents('.section13').find('.heading').outerHeight()-jQuery(this).parents('.section13').find('.button').outerHeight()-20-jQuery('.ypromo-site-bar').height());
		});
		jQuery('.section14 img').each(function(){
			jQuery(this).css('max-height', jQuery(window).height()-jQuery(this).parents('.section14').find('.heading').outerHeight()-jQuery(this).parents('.section14').find('.button').outerHeight()-20-jQuery('.ypromo-site-bar').height());
		});
		jQuery('.section15 img').each(function(){
			jQuery(this).css('max-height', jQuery(window).height()-jQuery(this).parents('.section15').find('.heading').outerHeight()-jQuery(this).parents('.section15').find('.button').outerHeight()-20-jQuery('.ypromo-site-bar').height());
		});
	});

	function animation(eq) {
		var el = '.section'+eq;
		jQuery('#fullpage').find('.section').eq(eq-1).find('.animate').each(function(){
			var animation = jQuery(this).data('animation');
			jQuery(this).addClass('animated '+animation);
		});
	}

	jQuery('#fullpage').fullpage({
		navigation: true,
		responsiveWidth: 768,
		afterLoad: function(anchorLink, index){
			animation(index);
			console.log(index);
		},
		onLeave: function(anchorLink, index){
			animation(index);
			console.log(index);
		},
	});
});