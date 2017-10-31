function close_callback() {
	jQuery('#callback_wrapper').delay(800).fadeOut(400);
}
jQuery(document).ready(function($) {
	$('.swipebox').swipebox();
	$('a.checkout.disabled').live('click', function(e) {
		e.preventDefault();
		$('#myModal').modal('show');
		$('#myModal .modal-title').html('<p>' + texts.low_order_amount_title + '</p>')
		$('#myModal .modal-body').html('<p>' + texts.low_order_amount + '</p>')
	})
	$('.more-images-btn').click(function() {
		$(this).next().slideToggle();
	});
	$('.sf-menu-phone .cat-parent > a').live('click', function() {
		event.preventDefault();
		$(this).toggleClass('active');
		$('.cat-parent > a').not($(this)).each(function() {});
		$(this).next().slideToggle();
	});
	$('.menu-item-has-children.menu-item-depth-1 > a').live('click', function() {
		event.preventDefault();
		$('.menu-item-depth-1 > a').not($(this)).each(function() {
			$(this).next().slideUp();
		});
		$(this).next().slideToggle();
	});
	$('.woocommerce-info a').click(function() {
		$('.woocommerce-info a').not($(this)).each(function() {
			$(this).parent().next().slideUp();
		});
	});
	$('#callback-btn').click(function() {
		console.log("run")
		$("#callback_wrapper").show();
		$("#callback_wrapper").toggleClass("hidden", 1000, "swing");
	});
	$('#callback-btn-mobile').click(function() {
		$("#callback_wrapper").show();
		$("#callback_wrapper").toggleClass("hidden", 1000, "swing");
	});
	$('#close_callback').click(function() {
		$("#callback_wrapper").addClass("hidden", 1000, "swing");
	})
	$('.additional-product-actions,.additional-product > h4, .additional-product .price-box').click(function() {
		$(this).parent().next().slideToggle();
	})
	$("#billing_country_field strong").hover(function() {
		$(this).append($('<div class="tooltip">Más országba történő szállítás esetén emailben vagy telefonon érdeklődjön az árról</div>'));
	}, function() {
		$(this).find(".tooltip").remove();
	});
	jQuery("#menu-icon").on("click", function() {
		jQuery(".sf-menu-phone").slideToggle();
		jQuery(this).toggleClass("active");
	});
	jQuery('.sf-menu-phone').find('li.parent').append('<strong></strong>');
	jQuery('.sf-menu-phone li.parent strong').on("click", function() {
		if (jQuery(this).attr('class') == 'opened') {
			jQuery(this).removeClass().parent('li.parent').find('> ul').slideToggle();
		} else {
			jQuery(this).addClass('opened').parent('li.parent').find('> ul').slideToggle();
		}
	});
	jQuery('.truncated span').click(function() {
		jQuery(this).parent().find('.truncated_full_value').stop().slideToggle();
	});
	jQuery.fn.slideFadeToggle = function(speed, easing, callback) {
		return this.animate({
			opacity: 'toggle',
			height: 'toggle'
		}, speed, easing, callback);
	};
	jQuery('.box-collateral').not('.box-up-sell').find('h2').append('<span class="toggle"></span>');
	jQuery('.form-add').find('.box-collateral-content').css({
		'display': 'block'
	}).parents('.form-add').find('h2 > span').addClass('opened');
	jQuery('.box-collateral > h2').click(function() {
		OpenedClass = jQuery(this).find('span').attr('class');
		if (OpenedClass == 'toggle opened') {
			jQuery(this).find('span').removeClass('opened');
		} else {
			jQuery(this).find('span').addClass('opened');
		}
		jQuery(this).parents('.box-collateral').find(' > .box-collateral-content').slideFadeToggle()
	});
	jQuery('.sidebar .block .block-title').append('<span class="toggle"></span>');
	jQuery('.sidebar .block .block-title').on("click", function() {
		$('.sidebar .block .block-title').not($(this)).each(function() {
			jQuery(this).find('> span').parents('.block').find('.block-content').slideUp();
		});
		jQuery(this).find('> span').parents('.block').find('.block-content').slideToggle();
	});
	jQuery('.footer .footer-col > h4').append('<span class="toggle"></span>');
	jQuery('.footer h4').on("click", function() {
		$('.footer .footer-col > h4').not($(this)).each(function() {
			jQuery(this).find('span').removeClass('opened').parents('.footer-col').find('.footer-col-content').slideUp();
		});
		jQuery(this).find('span').removeClass('opened').parents('.footer-col').find('.footer-col-content').slideToggle();
	});
	jQuery('.header-button').not('.top-sale').not('.top-facebook').on("click", function(e) {
		var ul = jQuery(this).find('ul')
		if (ul.is(':hidden')) ul.slideDown(),
			jQuery(this).addClass('active')
			else ul.slideUp(), jQuery(this).removeClass('active')
			jQuery('.header-button').not(this).removeClass('active'), jQuery('.header-button').not(this).find('ul').slideUp()
			jQuery('.header-button ul li').click(function(e) {
				e.stopPropagation();
			});
		return false
	});
	jQuery(document).on('click', function() {
		jQuery('.header-button').removeClass('active').find('ul').slideUp()
	});
	jQuery(".price-box.map-info a").click(function() {
		jQuery(".map-popup").toggleClass("displayblock");
	});
	jQuery('.map-popup-close').on('click', function() {
		jQuery('.map-popup').removeClass('displayblock');
	});
	qwe = jQuery('.lang-list ul li.current-lang span').html();
	jQuery('.lang-list > a').html(qwe);
	jQuery(window).bind('load resize', function() {
		sw = jQuery('.container').width();
		if (sw > 723) {
			jQuery('body').addClass('opened-1');
		} else {
			jQuery('body').removeClass('opened-1');
		};
	});
	jQuery('.block-cart-header .cart-content').hide();
	if (jQuery('.container').width() < 800) {
		jQuery('.block-cart-header .summary, .block-cart-header .empty, #close_cart').click(function() {
			jQuery('.block-cart-header .cart-content').stop(true, true).slideToggle(300);
		})
	} else {
		jQuery('.block-cart-header .summary, .block-cart-header .cart-content, .block-cart-header .empty').hover(function() {
			jQuery('.block-cart-header .cart-content').stop(true, true).slideDown(400);
		}, function() {
			jQuery('.block-cart-header .cart-content').stop(true, true).delay(400).slideUp(300);
		});
	};
});
jQuery(function() {
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > 100) {
			jQuery('#back-top').fadeIn();
		} else {
			jQuery('#back-top').fadeOut();
		}
	});
	jQuery('#back-top a').click(function() {
		jQuery('body,html').stop(false, false).animate({
			scrollTop: 0
		}, 800);
		return false;
	});
});
jQuery(function() {
	jQuery('.box-collateral h2').not('.box-up-sell h2').wrapInner("<strong>");
	jQuery('.page-title.category-title h1, .block-title strong, .box-collateral h2 strong, .box-up-sell span.line-title, .page-title strong').before("<div class='line-before'></div>");
	jQuery('.page-title.category-title h1, .block-title strong, .box-collateral h2 strong, .box-up-sell span.line-title, .page-title strong').after("<div class='line-after'></div>");
	jQuery(window).load(function() {
		jQuery('.line-after').each(function() {
			var thiswidth = (jQuery(this).parent().width() - jQuery(this).prev().width()) / 2 - 20;
			jQuery(this).css({
				width: thiswidth
			})
		})
		jQuery('.line-before').each(function() {
			var thiswidth = (jQuery(this).parent().width() - jQuery(this).next().width()) / 2 - 20;
			jQuery(this).css({
				width: thiswidth
			})
		})
	});
	jQuery(window).resize(function() {
		jQuery('.line-after').each(function() {
			var thiswidth = (jQuery(this).parent().width() - jQuery(this).prev().width()) / 2 - 20;
			jQuery(this).css({
				width: thiswidth
			})
		})
		jQuery('.line-before').each(function() {
			var thiswidth = (jQuery(this).parent().width() - jQuery(this).next().width()) / 2 - 20;
			jQuery(this).css({
				width: thiswidth
			})
		})
	});
});
jQuery(document).ready(function($) {
	jQuery('#products-informations').jcarousel({
		vertical: false,
		visible: 1,
		scroll: 1
	});

	if (jQuery('.container').width() < 724) {
		jQuery('.related-carousel').jcarousel({
			vertical: false,
			visible: 1,
			scroll: 1
		});
	} else {
		jQuery('.related-carousel').jcarousel({
			vertical: false,
			visible: 3,
			scroll: 1
		});
	}
	if (jQuery('.container').width() < 724) {
		jQuery('.design-carousel').jcarousel({
			vertical: false,
			visible: 1,
			scroll: 1
		});
	} else {
		jQuery('.design-carousel').jcarousel({
			vertical: false,
			visible: 3,
			scroll: 1
		});
	}
	$('#_package_price').change(function() {
		var chkb = $(this);
		if ($('.quantity .qty').val() % $(this).data('ipp') != 0) {
			chkb.attr('checked', false)
			if (!$(".add_prod_error_box").length) {
				$('.additional-product').after('<div class="add_prod_error_box"><div>' + texts.not_enough + '</div></div>');
				$('.add_prod_error_box').slideToggle().delay(3000).slideToggle(function() {
					$('.add_prod_error_box').remove()
				})
			}
		}
	})
});
(function(doc) {
	var addEvent = 'addEventListener',
		type = 'gesturestart',
		qsa = 'querySelectorAll',
		scales = [1, 1],
		meta = qsa in doc ? doc[qsa]('meta[name=viewport]') : [];
	function fix() {
		meta.content = 'width=device-width,minimum-scale=' + scales[0] + ',maximum-scale=' + scales[1];
		doc.removeEventListener(type, fix, true);
	}
	if ((meta = meta[meta.length - 1]) && addEvent in doc) {
		fix();
		scales = [.25, 1.6];
		doc[addEvent](type, fix, true);
	}
}(document));