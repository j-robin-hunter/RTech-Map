<?php
/**
 * Copyright © 2019 Roma Technology Limited. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace RTech\Map\Api;

use RTech\Map\Api\Data\MapMarkerInterface;

interface MapMarkerRepositoryInterface {

  /**
  * Retrive by Magento customer group id
  *
  * @param int $customerGroupId
  * @return \RTech\Map\Api\Data\MapMarkerInterface
  * @throws \Magento\Framework\Exception\NoSuchEntityException
  */
  public function getById($customerGroupId);

  /**
  * @param \RTech\Map\Api\Data\MapMarkerInterface $mapMarker
  * @return \RTech\Map\Api\Data\MapoMarkerInterface
  * @throws \Magento\Framework\Exception\CouldNotSaveException
  */
  public function save(MapMarkerInterface $mapMarker);

  /**
  * @param \RTech\Map\Api\Data\MapMarkerInterface $mapMarker
  * @return bool true on success
  * @throws \Magento\Framework\Exception\CouldNotDeleteException
  */
  public function delete(ZohoAddressInterface $mapMarker);

}