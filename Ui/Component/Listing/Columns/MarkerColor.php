<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Map\Ui\Component\Listing\Columns;

use Magento\Framework\Exception\NoSuchEntityException;

class MarkerColor extends \Magento\Ui\Component\Listing\Columns\Column {

  protected $_groupRepository;

  public function __construct(
    \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
    \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
    \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
    array $components = [],
    array $data = []
  ){
    parent::__construct($context, $uiComponentFactory, $components, $data);
    $this->_groupRepository = $groupRepository;
  }

  public function prepareDataSource(array $dataSource) {
    if (isset($dataSource['data']['items'])) {
      $fieldName = $this->getData('name');
      foreach ($dataSource['data']['items'] as & $item) {
        if (isset($item['customer_group_id'])) {
          try {
            $groupExtenstionAttributes = $this->_groupRepository->getById($item['customer_group_id'])->getExtensionAttributes();
            if ($groupExtenstionAttributes->getMapMarker()) {
              $markerColor = $groupExtenstionAttributes->getMapMarker()->getMarkerColor() ? '#' . dechex($groupExtenstionAttributes->getMapMarker()->getMarkerColor()) : '';
              $item[$fieldName] = '<span style="color:' . $markerColor . ';">' . $markerColor . '</span>';
            }
          } catch (NoSuchEntityException $ex) {
            // ignore this as a marker may not have been set for this group id
          }
        }
      }
    }

    return $dataSource;
  }
}