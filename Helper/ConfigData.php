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
  const DEFAULT_CENTRE_LAT = 54.6;
  const DEFAULT_CENTRE_LON = -3.2;
  const DEFAULT_ZOOM = 6;
  const MAPSTYLE_FILE = 'data/mapstyle.json';

  protected $scopeConfig;
  protected $assetRepo;

  public function __construct(
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    \Magento\Framework\View\Asset\Repository $assetRepo
  ) {
    $this->scopeConfig = $scopeConfig;
    $this->assetRepo = $assetRepo;
  }

  public function getGooleMapsApiKey($storeId) {
    return (string)$this->scopeConfig->getValue(
      self::GOOGLE_MAPS_API_KEY,
      ScopeInterface::SCOPE_STORE,
      $storeId
    );
  }

  public function getDefaultMapCentreLatitude($storeId) {
    return self::DEFAULT_CENTRE_LAT;
  }

  public function getDefaultMapCentreLongitude($storeId) {
    return self::DEFAULT_CENTRE_LON;
  }

  public function getDefaultMapZoom($storeId) {
    return self::DEFAULT_ZOOM;
  }

  public function getMapStyle() {
    try {
      return file_get_contents($this->assetRepo->getUrl('RTech_Map::' . self::MAPSTYLE_FILE));
    } catch (\Exception $e) {
      return '[]';
    }
  }
}