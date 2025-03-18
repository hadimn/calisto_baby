(function ($) {
    "use strict";

    /*-- Variables --*/
    var windows = $(window);
    var screenSize = windows.width();


    /*-- Product Hover Function --*/
    $(window).on('load', function () {
        function productHover() {

            var productInner = $('.product-inner');
            var proImageHeight = productInner.find('img').outerHeight();

            productInner.hover(
                function () {
                    var porContentHeight = $(this).find('.content').innerHeight() - 55;
                    $(this).find('.image-overlay').css({
                        "height": proImageHeight - porContentHeight,
                    });
                }, function () {
                    $(this).find('.image-overlay').css({
                        "height": '100%',
                    });
                }
            );

        }
        productHover();
        windows.resize(productHover);
    });


    /*--
        Menu Sticky
    -----------------------------------*/
    var sticky = $('.header-sticky');

    windows.on('scroll', function () {
        var scroll = windows.scrollTop();
        if (scroll < 300) {
            sticky.removeClass('is-sticky');
        } else {
            sticky.addClass('is-sticky');
        }
    });

    /*--
        Mobile Menu
    ------------------------*/
    var mainMenuNav = $('.main-menu nav');
    mainMenuNav.meanmenu({
        meanScreenWidth: '991',
        meanMenuContainer: '.mobile-menu',
        meanMenuClose: '<span class="menu-close"></span>',
        meanMenuOpen: '<span class="menu-bar"></span>',
        meanRevealPosition: 'right',
        meanMenuCloseSize: '0',
    });

    /*--
        Header Search
    ------------------------*/
    var searchToggle = $('.search-toggle');
    var searchWrap = $('.header-search-wrap');

    searchToggle.on('click', function () {

        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            searchWrap.addClass('active');
        } else {
            $(this).removeClass('active');
            searchWrap.removeClass('active');
        }

    });
    /*--
        Header Cart
    ------------------------*/
    var headerCart = $('.header-cart');
    var closeCart = $('.close-cart, .cart-overlay');
    var miniCartWrap = $('.mini-cart-wrap');

    headerCart.on('click', function (e) {
        e.preventDefault();
        $('.cart-overlay').addClass('visible');
        miniCartWrap.addClass('open');
    });
    closeCart.on('click', function (e) {
        e.preventDefault();
        $('.cart-overlay').removeClass('visible');
        miniCartWrap.removeClass('open');
    });

    /*--
        Hero Slider
    --------------------------------------------*/
    var heroSlider = $('.hero-slider');
    heroSlider.slick({
        arrows: true,
        autoplay: true,
        autoplaySpeed: 5000,
        dots: true,
        pauseOnFocus: false,
        pauseOnHover: false,
        fade: true,
        infinite: true,
        slidesToShow: 1,
        prevArrow: '<button type="button" class="slick-prev"><i class="icofont icofont-long-arrow-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="icofont icofont-long-arrow-right"></i></button>',
    });

    /*--
        Product Slider
    -----------------------------------*/
    $('.small-product-slider').slick({
        arrows: false,
        dots: false,
        autoplay: true,
        infinite: true,
        slidesToShow: 4,
        rows: 2,
        prevArrow: '<button type="button" class="slick-prev"><i class="icofont icofont-long-arrow-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="icofont icofont-long-arrow-right"></i></button>',
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    autoplay: true,
                    slidesToShow: 2,
                    arrows: false,
                }
            },
            {
                breakpoint: 479,
                settings: {
                    autoplay: true,
                    slidesToShow: 1,
                    arrows: false,
                }
            }
        ]
    });

    $('.best-deal-slider, .deal-product-slider').slick({
        arrows: false,
        dots: false,
        autoplay: true,
        infinite: true,
        slidesToShow: 1,
        prevArrow: '<button type="button" class="slick-prev"><i class="icofont icofont-long-arrow-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="icofont icofont-long-arrow-right"></i></button>',
    });

    /*----- 
        Testimonial Slider
    --------------------------------*/
    $('.testimonial-slider').slick({
        arrows: false,
        dots: false,
        autoplay: true,
        infinite: true,
        slidesToShow: 2,
        prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                }
            },
        ]
    });

    /*--
        Brand Slider
    -----------------------------------*/
    $('.brand-slider').slick({
        arrows: false,
        dots: false,
        autoplay: true,
        infinite: false,
        slidesToShow: 6,
        prevArrow: '<button type="button" class="slick-prev"><i class="icofont icofont-rounded-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="icofont icofont-rounded-right"></i></button>',
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 5,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 479,
                settings: {
                    slidesToShow: 2,
                }
            }
        ]
    });

    /*--
        Product Slider
    -----------------------------------*/
    $('.pro-thumb-img').slick({
        arrows: true,
        dots: false,
        autoplay: true,
        infinite: true,
        slidesToShow: 4,
        prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 479,
                settings: {
                    slidesToShow: 3,
                }
            }
        ]
    });
    $('.product-slider, .related-product-slider-1').slick({
        arrows: true,
        dots: false,
        autoplay: true,
        infinite: true,
        slidesToShow: 4,
        prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    autoplay: true,
                    slidesToShow: 1,
                    arrows: false,
                }
            }
        ]
    });
    $('.related-product-slider-2').slick({
        arrows: true,
        dots: false,
        autoplay: true,
        infinite: true,
        slidesToShow: 3,
        prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    autoplay: true,
                    slidesToShow: 1,
                    arrows: false,
                }
            }
        ]
    });

    /*----- 
        Product Zoom
    --------------------------------*/
    // Instantiate EasyZoom instances
    var $easyzoom = $('.easyzoom').easyZoom();

    // Setup thumbnails example
    var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

    $('.pro-thumb-img').on('click', 'a', function (e) {
        var $this = $(this);

        e.preventDefault();

        // Get the image source from the clicked thumbnail
        var imgSrc = $this.find('img').attr('src');

        // Update the main image source
        $('.easyzoom img').attr('src', imgSrc);

        // Use EasyZoom's `swap` method with the correct parameters
        api1.swap(imgSrc, imgSrc);
    });
    /*--
        Count Down Timer
    ------------------------*/
    $('[data-countdown]').each(function () {
        var $this = $(this), finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function (event) {
            $this.html(event.strftime('<span class="cdown day"><span class="time-count">%-D</span> <p>Days</p></span> <span class="cdown hour"><span class="time-count">%-H</span> <p>Hours</p></span> <span class="cdown minutes"><span class="time-count">%M</span> <p>Mint</p></span> <span class="cdown second"><span class="time-count">%S</span> <p>Secs</p></span>'));
        });
    });

    /*--
        MailChimp
    -----------------------------------*/
    $('#mc-form').ajaxChimp({
        language: 'en',
        callback: mailChimpResponse,
        // ADD YOUR MAILCHIMP URL BELOW HERE!
        url: 'http://devitems.us11.list-manage.com/subscribe/post?u=6bbb9b6f5827bd842d9640c82&amp;id=05d85f18ef'

    });
    function mailChimpResponse(resp) {

        if (resp.result === 'success') {
            $('.mailchimp-success').html('' + resp.msg).fadeIn(900);
            $('.mailchimp-error').fadeOut(400);

        } else if (resp.result === 'error') {
            $('.mailchimp-error').html('' + resp.msg).fadeIn(900);
        }
    }

    /*--
        Ajax Contact Form JS
    -----------------------------------*/
    $(function () {
        // Get the form.
        var form = $('#contact-form');
        // Get the messages div.
        var formMessages = $('.form-message');
        // Set up an event listener for the contact form.
        $(form).submit(function (e) {
            // Stop the browser from submitting the form.
            e.preventDefault();
            // Serialize the form data.
            var formData = $(form).serialize();
            // Submit the form using AJAX.
            $.ajax({
                type: 'POST',
                url: $(form).attr('action'),
                data: formData,
            })
                .done(function (response) {
                    // Make sure that the formMessages div has the 'success' class.
                    $(formMessages).removeClass('error');
                    $(formMessages).addClass('success');

                    // Set the message text.
                    $(formMessages).text(response);

                    // Clear the form.
                    $('#contact-form input,#contact-form textarea').val('');
                })
                .fail(function (data) {
                    // Make sure that the formMessages div has the 'error' class.
                    $(formMessages).removeClass('success');
                    $(formMessages).addClass('error');

                    // Set the message text.
                    if (data.responseText !== '') {
                        $(formMessages).text(data.responseText);
                    } else {
                        $(formMessages).text(
                            'Oops! An error occured and your message could not be sent.'
                        );
                    }
                });
        });
    });

    /*--
        Scroll Up
    -----------------------------------*/
    $.scrollUp({
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade',
        scrollText: '<i class="icofont icofont-swoosh-up"></i>',
    });

    /*--
        Nice Select
    ------------------------*/
    $('.nice-select').niceSelect()

    /*--
        Price Range Slider
    ------------------------*/
    $('#price-range').slider({
        range: true,
        min: 0,
        max: 2000,
        values: [250, 1670],
        slide: function (event, ui) {
            $('#price-amount').val('$' + ui.values[0] + '  -  $' + ui.values[1]);
        }
    });
    $('#price-amount').val('$' + $('#price-range').slider('values', 0) +
        '  -  $' + $('#price-range').slider('values', 1));

    /*----- 
        Quantity
    --------------------------------*/

    /*----- 
    Quantity
--------------------------------*/
    $('.pro-qty').prepend('<span class="dec qtybtn"><i class="ti-minus"></i></span>');
    $('.pro-qty').append('<span class="inc qtybtn"><i class="ti-plus"></i></span>');

    $('.qtybtn').on('click', function () {
        var $button = $(this);
        var $input = $button.parent().find('input'); // Find the input field
        var oldValue = parseFloat($input.val()); // Get the current quantity
        var cartId = $input.data('cart-id'); // Get the cart_id from the data attribute
        var quantity;

        // Determine the new quantity based on the button clicked
        if ($button.hasClass('inc')) {
            quantity = oldValue + 1; // Increment quantity
        } else {
            quantity = oldValue > 1 ? oldValue - 1 : 1; // Decrement quantity, but not below 1
        }

        // Send an AJAX request to check stock and update the quantity
        $.ajax({
            type: 'POST',
            url: '/calistobaby/proccess/update_cart_quantity.php',
            data: JSON.stringify({
                cart_id: cartId, // Use the cart_id from the data attribute
                quantity: quantity
            }),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Update the input field with the new quantity
                    $input.val(quantity);

                    // Format the subtotal and total with commas
                    var formattedSubtotal = response.subtotal.toLocaleString();
                    var formattedTotal = response.total.toLocaleString();
                    var formattedItemSubtotal = response.item_subtotal.toLocaleString();

                    // Update cart totals and display messages
                    $('.cart-subtotal .amount').text('$' + formattedSubtotal);
                    $('.order-total .amount').text('$' + formattedTotal);

                    // Update the individual item subtotal
                    $button.closest('tr').find('.pro-subtotal').text('$' + formattedItemSubtotal);

                    console.log("Cart updated successfully");
                } else {
                    // Show error message to the user
                    alert(response.message);
                    console.error("Cart update failed:", response.message);
                }
            },
            error: function (error) {
                console.error("Error updating cart:", error);
                alert("An error occurred while updating the cart. Please try again.");
            }
        });
    });

    /*----- 
        Shipping Form Toggle
    --------------------------------*/
    $('[data-shipping]').on('click', function () {
        if ($('[data-shipping]:checked').length > 0) {
            $('#shipping-form').slideDown();
        } else {
            $('#shipping-form').slideUp();
        }
    })

    /*----- 
        Payment Method Select
    --------------------------------*/
    $('[name="payment-method"]').on('click', function () {

        var $value = $(this).attr('value');

        $('.single-method p').slideUp();
        $('[data-method="' + $value + '"]').slideDown();

    })


})(jQuery);

document.addEventListener('DOMContentLoaded', function () {
    // Map of all CSS color names to their hex values
    var colorMap = {
        "#f0f8ff": "aliceblue",
        "#faebd7": "antiquewhite",
        "#00ffff": "aqua",
        "#7fffd4": "aquamarine",
        "#f0ffff": "azure",
        "#f5f5dc": "beige",
        "#ffe4c4": "bisque",
        "#000000": "black",
        "#ffebcd": "blanchedalmond",
        "#0000ff": "blue",
        "#8a2be2": "blueviolet",
        "#a52a2a": "brown",
        "#deb887": "burlywood",
        "#5f9ea0": "cadetblue",
        "#7fff00": "chartreuse",
        "#d2691e": "chocolate",
        "#ff7f50": "coral",
        "#6495ed": "cornflowerblue",
        "#fff8dc": "cornsilk",
        "#dc143c": "crimson",
        "#00ffff": "cyan",
        "#00008b": "darkblue",
        "#008b8b": "darkcyan",
        "#b8860b": "darkgoldenrod",
        "#a9a9a9": "darkgray",
        "#006400": "darkgreen",
        "#a9a9a9": "darkgrey",
        "#bdb76b": "darkkhaki",
        "#8b008b": "darkmagenta",
        "#556b2f": "darkolivegreen",
        "#ff8c00": "darkorange",
        "#9932cc": "darkorchid",
        "#8b0000": "darkred",
        "#e9967a": "darksalmon",
        "#8fbc8f": "darkseagreen",
        "#483d8b": "darkslateblue",
        "#2f4f4f": "darkslategray",
        "#2f4f4f": "darkslategrey",
        "#00ced1": "darkturquoise",
        "#9400d3": "darkviolet",
        "#ff1493": "deeppink",
        "#00bfff": "deepskyblue",
        "#696969": "dimgray",
        "#696969": "dimgrey",
        "#1e90ff": "dodgerblue",
        "#b22222": "firebrick",
        "#fffaf0": "floralwhite",
        "#228b22": "forestgreen",
        "#ff00ff": "fuchsia",
        "#dcdcdc": "gainsboro",
        "#f8f8ff": "ghostwhite",
        "#ffd700": "gold",
        "#daa520": "goldenrod",
        "#808080": "gray",
        "#808080": "grey",
        "#008000": "green",
        "#adff2f": "greenyellow",
        "#f0fff0": "honeydew",
        "#ff69b4": "hotpink",
        "#cd5c5c": "indianred",
        "#4b0082": "indigo",
        "#fffff0": "ivory",
        "#f0e68c": "khaki",
        "#e6e6fa": "lavender",
        "#fff0f5": "lavenderblush",
        "#7cfc00": "lawngreen",
        "#fffacd": "lemonchiffon",
        "#add8e6": "lightblue",
        "#f08080": "lightcoral",
        "#e0ffff": "lightcyan",
        "#fafad2": "lightgoldenrodyellow",
        "#d3d3d3": "lightgray",
        "#d3d3d3": "lightgrey",
        "#90ee90": "lightgreen",
        "#ffb6c1": "lightpink",
        "#ffa07a": "lightsalmon",
        "#20b2aa": "lightseagreen",
        "#87cefa": "lightskyblue",
        "#778899": "lightslategray",
        "#778899": "lightslategrey",
        "#b0c4de": "lightsteelblue",
        "#ffffe0": "lightyellow",
        "#00ff00": "lime",
        "#32cd32": "limegreen",
        "#faf0e6": "linen",
        "#ff00ff": "magenta",
        "#800000": "maroon",
        "#66cdaa": "mediumaquamarine",
        "#0000cd": "mediumblue",
        "#ba55d3": "mediumorchid",
        "#9370db": "mediumpurple",
        "#3cb371": "mediumseagreen",
        "#7b68ee": "mediumslateblue",
        "#00fa9a": "mediumspringgreen",
        "#48d1cc": "mediumturquoise",
        "#c71585": "mediumvioletred",
        "#191970": "midnightblue",
        "#f5fffa": "mintcream",
        "#ffe4e1": "mistyrose",
        "#ffe4b5": "moccasin",
        "#ffdead": "navajowhite",
        "#000080": "navy",
        "#fdf5e6": "oldlace",
        "#808000": "olive",
        "#6b8e23": "olivedrab",
        "#ffa500": "orange",
        "#ff4500": "orangered",
        "#da70d6": "orchid",
        "#eee8aa": "palegoldenrod",
        "#98fb98": "palegreen",
        "#afeeee": "paleturquoise",
        "#db7093": "palevioletred",
        "#ffefd5": "papayawhip",
        "#ffdab9": "peachpuff",
        "#cd853f": "peru",
        "#ffc0cb": "pink",
        "#dda0dd": "plum",
        "#b0e0e6": "powderblue",
        "#800080": "purple",
        "#663399": "rebeccapurple",
        "#ff0000": "red",
        "#bc8f8f": "rosybrown",
        "#4169e1": "royalblue",
        "#8b4513": "saddlebrown",
        "#fa8072": "salmon",
        "#f4a460": "sandybrown",
        "#2e8b57": "seagreen",
        "#fff5ee": "seashell",
        "#a0522d": "sienna",
        "#c0c0c0": "silver",
        "#87ceeb": "skyblue",
        "#6a5acd": "slateblue",
        "#708090": "slategray",
        "#708090": "slategrey",
        "#fffafa": "snow",
        "#00ff7f": "springgreen",
        "#4682b4": "steelblue",
        "#d2b48c": "tan",
        "#008080": "teal",
        "#d8bfd8": "thistle",
        "#ff6347": "tomato",
        "#40e0d0": "turquoise",
        "#ee82ee": "violet",
        "#f5deb3": "wheat",
        "#ffffff": "white",
        "#f5f5f5": "whitesmoke",
        "#ffff00": "yellow",
        "#9acd32": "yellowgreen"
    };

    // Handle thumbnail clicks
    $('#pro-thumb-img').on('click', 'a', function (e) {
        e.preventDefault();

        // Get the color and image from the clicked thumbnail
        var color = $(this).data('color').toLowerCase(); // Convert to lowercase for consistency
        var imgSrc = $(this).data('standard'); // Get the high-resolution image source

        // Update the main image in the EasyZoom section
        updateMainImage(imgSrc);

        // Highlight the corresponding color button
        highlightColorButton(color);

        // Highlight the clicked thumbnail
        $(this).closest('li').addClass('active').siblings().removeClass('active');
    });

    // Handle color button clicks
    $('.color-options button').on('click', function () {
        var color = $(this).css('background-color'); // Get the color of the clicked button
        var hexColor = rgbToHex(color); // Convert to hex
        var colorName = getColorName(hexColor); // Get the color name

        // Find the corresponding thumbnail
        var thumbnail = $('#pro-thumb-img a').filter(function () {
            return $(this).data('color').toLowerCase() === colorName;
        });

        if (thumbnail.length) {
            // Update the main image in the EasyZoom section
            var imgSrc = thumbnail.data('standard');
            updateMainImage(imgSrc);

            // Highlight the clicked thumbnail
            thumbnail.closest('li').addClass('active').siblings().removeClass('active');

            // Highlight the clicked color button
            highlightColorButton(colorName);
        }
    });

    // Helper function to update the main image in the EasyZoom section
    function updateMainImage(imgSrc) {
        $('.easyzoom img').attr('src', imgSrc); // Update the image source
        $('.easyzoom a').attr('href', imgSrc); // Update the link for the zoomed image
    }

    // Helper function to highlight the corresponding color button
    function highlightColorButton(color) {
        $('.color-options button').removeClass('active'); // Remove active class from all buttons
        $('.color-options button').each(function () {
            var buttonColor = rgbToHex($(this).css('background-color')); // Convert to hex
            var colorName = getColorName(buttonColor); // Get the color name

            if (colorName === color) {
                $(this).addClass('active'); // Add active class to the matching button
            }
        });
    }

    $(document).ready(function () {
        // Function to highlight the selected size button
        $('.size-options button').on('click', function () {
            $('.size-options button').removeClass('active'); // Remove active class from all buttons
            $(this).addClass('active'); // Add active class to the clicked button
        });
    });


    // Helper function to convert RGB to Hex
    function rgbToHex(rgb) {
        // Extract RGB values from the string
        var match = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        if (!match) return rgb; // Return as-is if not in RGB format

        // Convert each RGB component to hex
        function hex(x) {
            return ("0" + parseInt(x).toString(16)).slice(-2);
        }
        return "#" + hex(match[1]) + hex(match[2]) + hex(match[3]);
    }

    // Helper function to get the color name from hex
    function getColorName(hex) {
        // Normalize hex to lowercase for comparison
        hex = hex.toLowerCase();

        // Return the color name or null if not found
        return colorMap[hex] || null;
    }
});