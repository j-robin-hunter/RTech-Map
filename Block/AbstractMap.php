<?php
/**
 * Copyright © 2019 Roma Technology Limited. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace RTech\Map\Block;

use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template;

abstract class AbstractMap extends Template implements BlockInterface {
  protected $_template;
  protected $_configData;
  protected $_storeId;
  protected $_mapstyle;

  public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \RTech\Map\Helper\ConfigData $configData,
    array $data = []
  ) {
    parent::__construct($context, $data);
    $this->_configData = $configData;
    $this->_storeId = $this->_storeManager->getStore()->getId();
  }

  public function getApiKey() {
    return $this->_configData->getGooleMapsApiKey($this->_storeId);
  }

  public function getMapStyle() {
    if (!$this->_mapstyle) {
      $this->_mapstyle = $this->_configData->getMapStyle();
    }
    return $this->_mapstyle;
  }
}
