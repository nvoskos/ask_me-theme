(function($) {

	$(document).ready(function() {


$(".the-title").on('keypress', function (e) {
  var ingnore_key_codes = [34, 39];
   if ($.inArray(e.which, ingnore_key_codes) >= 0) {
       e.preventDefault();
       $(".error").html("Please do not use quotation marks in your title").addClass("form-description").css("color", "red").show();
   } else {
       $(".error").hide();
   }
  });


  $('a').each(function() {
     var a = new RegExp('/' + window.location.host + '/');
     if (!a.test(this.href)) {
        $(this).attr("target","_blank");
     }
  });


  //
  // $('.content-text').each(function(){
  //     this.href += '?a=text'
  // })

  // $('*:contains("www")').each(function(){
  //      if($(this).children().length < 1)
  //           $(this).css("color","blue")
  //             var oldUrl = $(this).attr('*:contains("www")');
  //         });
  //
  //
  //           $('*:contains("http")').each(function(){
  //                if($(this).children().length < 1)
  //                     $(this).css("color","blue")
  //                   });
  //
  //
  //







  });


})( jQuery );
