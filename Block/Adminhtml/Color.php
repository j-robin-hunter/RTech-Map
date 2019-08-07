<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Map\Block\Adminhtml;

class Color extends \Magento\Config\Block\System\Config\Form\Field {

  public function __construct(
    \Magento\Backend\Block\Template\Context $context, array $data = []
  ) {
    parent::__construct($context, $data);
  }

  protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element) {
    $html = $element->getElementHtml();
    $value = $element->getData('value');
    $html .= '<script type="text/javascript">
      require(
        [
          "jquery",
          "jquery/colorpicker/js/colorpicker"
        ], function ($) {
          $(document).ready(function () {
            var $el = $("#' . $element->getHtmlId() . '");
            $el.css("backgroundColor", "'. $value .'");

            // Attach the color picker
            $el.ColorPicker({
              color: "'. $value .'",
              onChange: function (hsb, hex, rgb) {
                $el.css("backgroundColor", "#" + hex).val("#" + hex);
              }
            });
          });
        });
      </script>';
    return parent::getElementHtml();
  }
}