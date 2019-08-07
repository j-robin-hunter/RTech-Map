<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Map\Block\Adminhtml\Group\Edit;

use Magento\Customer\Controller\RegistryConstants;

class Form extends \Magento\Customer\Block\Adminhtml\Group\Edit\Form {

  protected function _prepareLayout() {
    parent::_prepareLayout();
    $form = $this->getForm();

    $groupId = $this->_coreRegistry->registry(RegistryConstants::CURRENT_GROUP_ID);
    if ($groupId === null) {
      $customerGroup = $this->groupDataFactory->create();
      $defaultCustomerTaxClass = $this->_taxHelper->getDefaultCustomerTaxClass();
    } else {
      $customerGroup = $this->_groupRepository->getById($groupId);
      $defaultCustomerTaxClass = $customerGroup->getTaxClassId();
    }


    $fieldset = $form->addFieldset('map_locations', ['legend' => __('Customer Map Locations')]);
    $field = $fieldset->addField(
      'marker_color',
      'text',
      [
        'name' => 'marker_color',
        'label' => __('Marker Color'),
        'title' => __('Marker Color'),
        'note' => __('Click to select color using color picker.'),
        'visible' => false
      ]
    );

    $extensionAttribute = $customerGroup->getExtensionAttributes();
    if ($extensionAttribute !== null && $extensionAttribute->getMapMarker() !== null) {
      $form->addValues(
        [
          'marker_color' => '#' . dechex($extensionAttribute->getMapMarker()->getMarkerColor())
        ]
      );
    }
  }
}