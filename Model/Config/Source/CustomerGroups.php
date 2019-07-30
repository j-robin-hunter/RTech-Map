<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Map\Model\Config\Source;

class CustomerGroups implements \Magento\Framework\Option\ArrayInterface {
  protected $_customerGroupCollectionFactory;
  protected $_categoryCollectionFactory;

  public function __construct(
    \Magento\Customer\Model\ResourceModel\Group\Collection $customerGroupCollectionFactory
  ) {
    $this->_customerGroupCollectionFactory = $customerGroupCollectionFactory;
  }

  public function toOptionArray() {
    return $this->_customerGroupCollectionFactory->toOptionArray();
  }
}