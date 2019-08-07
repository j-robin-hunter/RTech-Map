<?php
/**
 * Copyright © 2019 Roma Technology Limited. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace RTech\Map\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class MapMarker extends AbstractDb {

  protected $_isPkAutoIncrement = false;

  protected function _construct() {
    $this->_init('map_marker', 'customer_group_id');
  }

}