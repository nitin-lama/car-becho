(function($, Drupal) {
  Drupal.behaviors.custom_action = {
    attach: function(context, settings) {
      $('.vbo-table td input[type="checkbox"]').once().click(function(){
          var count=0;
          $(".vbo-table td").each(function(){
      if($(this).find('input[type="checkbox"]').is(':checked')){
          count++;
          }
        });
        if(count > 1){
          $('.view-car-becho input[data-drupal-selector="edit-compare"]').show();
        }
        else{
          $('.view-car-becho input[data-drupal-selector="edit-compare"]').hide();
        }
      if(count > 3){
        alert('Only maximum 3 cars can be compared!');
      }
    });
  }
};
})(jQuery, Drupal);
