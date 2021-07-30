/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
// start the Stimulus application
import './bootstrap';
import '../node_modules/owl.carousel/dist/assets/owl.carousel.css';
import '../node_modules/owl.carousel/dist/assets/owl.theme.default.css';
import '../node_modules/owl.carousel/dist/owl.carousel.min.js';
import '../node_modules/jquery/dist/jquery';
import 'bootstrap-icons/font/bootstrap-icons.css';

/*-------------------------------------------------------------------------------
  testimonial slider
-------------------------------------------------------------------------------*/
$(function() {
    if ($('.testimonial').length) {
        $('.testimonial').owlCarousel({
            loop: true,
            margin: 30,
            items: 3,
            nav: false,
            dots: true,
            responsiveClass: true,
            slideSpeed: 300,
            paginationSpeed: 500,
            responsive: {
                0: {
                    items: 1
                }
            }
        })
    }
});

/*-------------------------------------------------------------------------------
    Responsive tables // https://codepen.io/JacobLett/pen/mBQoOj
    -------------------------------------------------------------------------------*/
$('.table-responsive-stack').each(function (i) {
    var id = $(this).attr('id');
    $(this).find("th").each(function(i) {
       $('#'+id + ' td:nth-child(' + (i + 1) + ')').prepend('<span class="table-responsive-stack-thead">'+ $(this).text() + ' </span>');
       $('.table-responsive-stack-thead').hide();

    });
 });

$( '.table-responsive-stack' ).each(function() {
    var thCount = $(this).find("th").length;
    var rowGrow = 100 / thCount + '%';
    $(this).find("th, td").css('flex-basis', rowGrow);
});

function flexTable(){
 if ($(window).width() < 959) {
 $(".table-responsive-stack").each(function (i) {
    $(this).find(".table-responsive-stack-thead").show();
    $(this).find('thead').hide();
 });

 // window is less than 768px
 } else {
 $(".table-responsive-stack").each(function (i) {
    $(this).find(".table-responsive-stack-thead").hide();
    $(this).find('thead').show();
 });
 }
}

flexTable();

window.onresize = function(event) {
  flexTable();
};
