<?php
/**
 * Copyright © 2019 Roma Technology Limited. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace RTech\Map\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use RTech\Map\Api\Data\MapMarkerInterface;

class MapMarker extends AbstractModel implements IdentityInterface, MapMarkerInterface {

  const CACHE_TAG = 'map_marker';

  protected $_cacheTag = self::CACHE_TAG;
  protected $_eventPrefix = self::CACHE_TAG;

  protected function _construct() {
    $this->_init(\RTech\Map\Model\ResourceModel\MapMarker::class);
  }

  /**
  * Return unique ID(s)
  *
  * @return string[]
  */
  public function getIdentities() {
    return [self::CACHE_TAG . '_' . $this->getId()];
  }

  /**
  * @inheritdoc
  */
  public function getId() {
    return (int)$this->getData(self::CUSTOMER_GROUP_ID);
  }

  /**
  * @inheritdoc
  */
  public function setId($entityId) {
    return $this->setData(self::CUSTOMER_GROUP_ID, $entityId);
  }

  /**
  * @inheritdoc
  */
  public function getMarkerColor() {
    return $this->getData(self::MARKER_COLOR);
  }

  /**
  * @inheritdoc
  */
  public function setMarkerColor($markerColor) {
    return $this->setData(self::MARKER_COLOR, $markerColor);
  }

}