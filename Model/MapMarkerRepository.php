<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Map\Model;

use RTech\Map\Api\MapMarkerRepositoryInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;

class MapMarkerRepository implements MapMarkerRepositoryInterface {

  protected $mapMarkerFactory;

  public function __construct(
    MapMarkerFactory $mapMarkerFactory
  ) {
    $this->mapMarkerFactory = $mapMarkerFactory;
  }

  /**
  * @inheritdoc
  */
  public function getById($customerGroupId) {
    $mapMarker = $this->mapMarkerFactory->create();
    $response = $mapMarker->getResource()->load($mapMarker, $customerGroupId);
    return $mapMarker;
  }

  /**
  * @inheritdoc
  */
  public function save($mapMarker) {
    try {
      $mapMarker->getResource()->save($mapMarker);
    } catch (\Exception $exception) {
      throw new CouldNotSaveException(__($exception->getMessage()));
    }
    return $mapMarker;
  }

  /**
  * @inheritdoc
  */
  public function delete($mapMarker) {
    try {
      $mapMarker->getResource()->delete($mapMarker);
    } catch (\Exception $exception) {
      throw new CouldNotDeleteException(__($exception->getMessage()));
    }
    return $mapMarker;
  }

}