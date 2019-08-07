<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Map\Plugin;

use Magento\Framework\Exception\NoSuchEntityException;

class MapMarkerPlugin {

  protected $_mapMarkerRepository;
  protected $__mapMarkerExtensionFactory;
  protected $_groupRepository;
  protected $__groupFactory;
  protected $_logger;

  public function __construct(
    \RTech\Map\Model\MapMarkerRepository $mapMarkerRepository,
    \RTech\Map\Api\Data\MapMarkerExtensionFactory $mapMarkerExtensionFactory,
    \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
    \Magento\Customer\Model\GroupFactory $groupFactory,
    \Psr\Log\LoggerInterface $logger
  ) {
    $this->_mapMarkerRepository = $mapMarkerRepository;
    $this->_mapMarkerExtensionFactory = $mapMarkerExtensionFactory;
    $this->_groupRepository = $groupRepository;
    $this->_groupFactory = $groupFactory;
    $this->_logger = $logger;
  }


  public function afterGetById(
    \Magento\Customer\Api\GroupRepositoryInterface $subject,
    \Magento\Customer\Api\Data\GroupInterface $group
  ) {

    try {
      $mapMarker = $this->_mapMarkerRepository->getById($group->getId());
      $extensionAttributes = $group->getExtensionAttributes() ?: $this->_mapMarkerExtensionFactory->create();

      $extensionAttributes->setMapMarker($mapMarker);
      $group->setExtensionAttributes($extensionAttributes);
    } catch (\NoSuchEntityException $ex) {
      // Since this is allowed do nothing
    }

    return $group;
  }

  public function afterSave (
    \Magento\Customer\Api\GroupRepositoryInterface $subject,
    \Magento\Customer\Api\Data\GroupInterface $group
  ) {

    try {
      $extensionAttributes = $group->getExtensionAttributes();
      if ($extensionAttributes && $extensionAttributes->getMapMarker()) {
        $mapMarker = $this->_mapMarkerRepository->save($extensionAttributes->getMapMarker());
      }
    } catch (\Exception $e) {
      throw new CouldNotSaveException(__('Could not add save map marker extension for group: "%1"', $e->getMessage()), $e);
    }
    return $group;
  }

}