<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/

namespace RTech\Map\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigData extends AbstractHelper
{
  const GOOGLE_MAPS_API_KEY = 'map/google/api_key';
  const INSTALLER_MAP_CENTRE_LAT = 'map/installer/lat';
  const INSTALLER_MAP_CENTRE_LON = 'map/installer/lon';
  const INSTALLER_MAP_ZOOM = 'map/installer/zoom';
  const INSTALLER_CUSTOMER_GROUPS = 'map/installer/customer_groups';

  public function __construct(
    ScopeConfigInterface $scopeConfig
  ) {
    $this->scopeConfig = $scopeConfig;
  }

  public function getGooleMapsApiKey($storeId) {
    return (string)$this->scopeConfig->getValue(
      self::GOOGLE_MAPS_API_KEY,
      ScopeInterface::SCOPE_STORE,
      $storeId
    );
  }

  public function getInstallerMapCentreLatitude($storeId) {
    return $this->scopeConfig->getValue(
      self::INSTALLER_MAP_CENTRE_LAT,
      ScopeInterface::SCOPE_STORE,
      $storeId
    );
  }

  public function getInstallerMapCentreLongitude($storeId) {
    return $this->scopeConfig->getValue(
      self::INSTALLER_MAP_CENTRE_LON,
      ScopeInterface::SCOPE_STORE,
      $storeId
    );
  }

  public function getInstallerMapZoom($storeId) {
    return $this->scopeConfig->getValue(
      self::INSTALLER_MAP_ZOOM,
      ScopeInterface::SCOPE_STORE,
      $storeId
    );
  }

  public function getInstallerCustomerGroups($storeId) {
    return explode(',', $this->scopeConfig->getValue(
      self::INSTALLER_CUSTOMER_GROUPS,
      ScopeInterface::SCOPE_STORE,
      $storeId
    ));
  }
}