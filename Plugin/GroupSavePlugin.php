<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Map\Plugin;

use RTech\Map\Api\Data\MapMarkerInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GroupSavePlugin {

  protected $_mapMarkerRepository;
  protected $__mapMarkerFactory;
  protected $_logger;

  public function __construct(
    \RTech\Map\Model\MapMarkerRepository $mapMarkerRepository,
    \RTech\Map\Model\MapMarkerFactory $mapMarkerFactory,
    \Psr\Log\LoggerInterface $logger
  ) {
    $this->_mapMarkerRepository = $mapMarkerRepository;
    $this->_mapMarkerFactory = $mapMarkerFactory;
    $this->_logger = $logger;
  }


  public function afterExecute(
    \Magento\Customer\Controller\Adminhtml\Group\Save $save,
    $result
  ) {
    $customerGroupId = $save->getRequest()->getParam('id');
    $markerColor = $save->getRequest()->getParam('marker_color');
    if ($customerGroupId) {
      $mapMarker = $this->_mapMarkerFactory->create();
      $mapMarker->setData([
        MapMarkerInterface::CUSTOMER_GROUP_ID => $customerGroupId,
        MapMarkerInterface::MARKER_COLOR => hexdec($markerColor)
      ]);
        try {
          $this->_mapMarkerRepository->save($mapMarker);
        } catch (\Exception $e) {
          $this->_logger->error(__('Error while saving map marker data: ' . $e->getMessage()));
        }
    }

    return $result;
  }

}