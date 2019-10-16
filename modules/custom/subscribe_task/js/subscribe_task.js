
jQuery(document).on("click",".subscribe", function(){
    var nid = jQuery(this).attr('nid');
    var myurl = '/data-insert?nid'+nid;
                  jQuery.ajax({
                       type: "GET",
                       url: myurl,
                       data: {nid:nid},
                       success: function(data){
                         if(data == 1){
                           //jQuery(this).hide();
                          alert("Thank you for subscribing");
                            }
                         },
                       dataType: 'html'
                       });
                 });
