$(document).ready(function() {

	var mobileCheck = {
	    Android: function() {
	        return navigator.userAgent.match(/Android/i);
	    },
	    BlackBerry: function() {
	        return navigator.userAgent.match(/BlackBerry/i);
	    },
	    iOS: function() {
	        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	    },
	    Opera: function() {
	        return navigator.userAgent.match(/Opera Mini/i);
	    },
	    Windows: function() {
	        return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
	    },
	    any: function() {
	        return (mobileCheck.Android() || mobileCheck.BlackBerry() || mobileCheck.iOS() || mobileCheck.Opera() || mobileCheck.Windows());
	    }
	};

	var isMobile = (mobileCheck.any()) ? true : false;

	$('li.filterlist-more').click(function() {

		var expandID = $(this).attr('id');
		expandID = expandID.replace('show','');

		var listID = 'list'+expandID;

		if($('li[rel='+listID+']').css('display') == 'none') {
			$('li[rel='+listID+']').slideDown('fast');
			$(this).html('Hide all &raquo;');
		} else {
			$('li[rel='+listID+']').slideUp('fast');
			$(this).html('Show all &raquo;');
		}

	});


	$('button[type="reset"]').click(function() {
		$(this).closest('form').find('input[type="text"]').attr('value','');
		$(this).closest('form').submit();
	});


	$('.mobile-nav').click(function() {
		if($('.mask').css('display') == 'none') {
			$('.mask').fadeTo(200, 0.7);
			$('nav').animate({right:'0%'}, 200);
			$('.logo').addClass('fixed');
		} else {
			$('.mask').fadeOut(300);
			$('nav').animate({right:'-70%'}, 300);
			$('.logo').removeClass('fixed');
		}
	});

	$('.mobile-nav-close, .mask').click(function() {
		$('.mask').fadeOut(100);
		$('nav').animate({right:'-70%'}, 100);
		$('.logo').removeClass('fixed');
	});



	$('.recipe').mouseover(function() {
		$(this).find('.recipe-over').stop(true, true).fadeIn('fast');
		$(this).find('.crp_title').stop(true, true).fadeIn('fast');
	}).mouseleave(function() {
		$(this).find('.recipe-over').stop(true, true).fadeOut('slow');
		$(this).find('.crp_title').stop(true, true).fadeOut('slow');
	});


	$('.wpcf7-text, .wpcf7-textarea').click(function() {
		$(this).select();
	});

});