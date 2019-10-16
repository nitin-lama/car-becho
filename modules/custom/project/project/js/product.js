(function($, Drupal) {
  Drupal.behaviors.MarketBehavior = {
    attach: function(context, settings) {
    $(document).ready(function(){
      $("input").keydown(function(){
        $("input").css("background-color", "yellow");
      });
    });
  }
};
})(jQuery, Drupal);
