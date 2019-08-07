require(
  [
    "jquery",
    "jquery/colorpicker/js/colorpicker"
  ], function ($) {
    $(document).ready(function () {
      var el = $('#marker_color');
      var value = el.val();
      el.css('backgroundColor', value);
      el.css('width', '100px');
      el.css('color', 'transparent');


      // Attach the color picker
      el.ColorPicker({
        color: "'. $value .'",
        onChange: function (hsb, hex, rgb) {
          el.css("backgroundColor", "#" + hex).val("#" + hex);
        }
      });
    });
  });