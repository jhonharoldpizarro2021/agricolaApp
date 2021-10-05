$(document).ready(function() {
    $('#side-menu').metisMenu();
    $(".lista").css("background", "rgba(255,255,255,0.8)").css("padding-left","10px").css("margin-top","10px");
    $(".enlace").css("color", "#000");
    $(".enlace").mouseenter(function() {
        $(this).css("color", "#A0522D");
    }).mouseleave(function() {
         $(this).css("color", "#000");
    });

    $( ".nav>li>a" ).click(function() {
      var ventana = $("#page-wrapper").height();
      var sidebar = $(".sidebar").height();
      var altura =  ventana + sidebar;
      //$("#page-wrapper").css("min-height", (altura) + "px");
    });

});
//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            //$('div.navbar-collapse').addClass('collapse');
            $(".fondo-inicio img").css("height", "auto");
            topOffset = 100; // 2-row-menu
        } 
        else {
            //$('div.navbar-collapse').removeClass('collapse');
        }
        if (width >= 768) {
            $('#tabla_insumos th:nth-child(2)').addClass('hideColum');
            $('#tabla_insumos td:nth-child(2)').addClass('hideColum');
        }
        else {
            $('#tabla_insumos th:nth-child(2)').removeClass('hideColum');
            $('#tabla_insumos td:nth-child(2)').removeClass('hideColum');
        }
        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height + topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
            $("ul#side-menu").css("height", (height-76) + "px").css("overflow-y", "scroll");
            $(".fondo-inicio img").css("height", (height-200) + "px");
        }

    });
    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});

$('.form_date').datetimepicker({
   language:  'es',
   weekStart: 1,
   todayBtn:  1,
   autoclose: 1,
   todayHighlight: 1,
   startView: 2,
   minView: 2,
   forceParse: 0,
   format: "yyyy-mm-dd", /*yyyy-mm-dd hh:ii:ss*/
});
$('.tiempo').datetimepicker({
   language:  'es',
   weekStart: 1,
   todayBtn:  1,
   autoclose: 1,
   todayHighlight: 1,
   startView: 2,
   minView: 2,
   forceParse: 0,
   format: "yyyy-mm-dd hh:ii:ss", /*yyyy-mm-dd hh:ii:ss    ----     yyyy-mm-dd*/
});
/**
* Función encargada de validar email
* @param Strning email
* @return true | false
*/
function validarEmail(email)
{
    var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) )
    {
        return false;
    }else
    {
        return true;
    }
}
// Hide Header on on scroll down
var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('.navbar').outerHeight();
$(window).scroll(function(event){
    didScroll = true;
});
setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 0);
function hasScrolled() {
  var st = $(this).scrollTop();
  // Make sure they scroll more than delta
  if(Math.abs(lastScrollTop - st) <= delta)
      return;
  // If they scrolled down and are past the navbar, add class .nav-up.
  // This is necessary so you never see what is "behind" the navbar.
  if (st > lastScrollTop && st > navbarHeight){
      // Scroll Down
      $('.navbar').removeClass('nav-down').addClass('nav-up');
  } 
  else {
      // Scroll Up
      if(st + $(window).height() < $(document).height()) {
          $('.navbar').removeClass('nav-up').addClass('nav-down');
      }
  }
  lastScrollTop = st;
}
$('.navbar').hover(
  function(){ $(this).removeClass('nav-up').addClass('nav-down'); }
);
