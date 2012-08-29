$(function(){

  $('.nav-tabs a').click(function (e) {    
    $('.nav-tabs li').removeClass('active');
    $(this).parent().addClass('active');
  });
    
});