<?php
/**
 * Copyright © 2019 Roma Technology Limited. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace RTech\Map\Block;

use RTech\Map\Block\AbstractMap;

class InstallerMap extends AbstractMap {
  protected $_template = "widget/installermap.phtml";
  protected $_customerFactory;
  protected $_groupRepository;
  protected $_customerRepository;
  protected $__countryFactory;

  public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
    \RTech\Map\Helper\ConfigData $configData,
    \Magento\Customer\Model\CustomerFactory $customerFactory,
    \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
    \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
    \Magento\Directory\Model\CountryFactory $countryFactory,
    array $data = []
  ) {
    parent::__construct($context, $configData, $data);
    $this->_customerFactory = $customerFactory;
    $this->_groupRepository = $groupRepository;
    $this->_customerRepository = $customerRepository;
    $this->_countryFactory = $countryFactory;
  }

  public function getCenterLat() {
    return $this->_mapsApiKey;
  }

  public function getMapCentreLatitude() {
    return $this->getData('lat');
  }

  public function getMapCentreLongitude() {
    return $this->getData('lon');
  }

  public function getMapZoom() {
    return $this->getData('zoom');
  }

  public function getResellers() {
    $resellers = $this->_customerFactory->create()
      ->getCollection()
      ->addFieldToFilter('group_id', array('in' => explode(',', $this->getData('address_groups'))));
    $countries = $this->_countryFactory->create();
    $resellerLocations = [];


    foreach ($resellers->getItems() as $reseller) {
      $account = $this->_customerRepository->getById($reseller->getId());
      $group = $this->_groupRepository->getById($reseller->getGroupId());
      $mapMarker = $group->getExtensionAttributes() ? $group->getExtensionAttributes()->getMapMarker() : null;
      foreach($reseller->getAddresses() as $address) {
        if (!empty($address->getLocation())) {
          $location = explode(',', $address->getLocation());
          if (count($location) == 2) {
            $resellerLocations[] = [
              'type' => $group->getCode(),
              'company' => $address->getCompany(),
              'street' => $address->getStreet(),
              'city' => $address->getCity(),
              'region' => $address->getRegion(),
              'postcode' => $address->getPostcode(),
              'country' => $countries->loadByCode($address->getCountryId())->getName(),
              'telephone' => $address->getTelephone(),
              'email' => $address->getLocalEmail() ? : $reseller->getEmail(),
              'website' => $account->getCustomAttribute('website') ? $account->getCustomAttribute('website')->getValue() : '',
              'lat' => $location[0],
              'lon' => $location[1],
              'marker_color' => $mapMarker ? dechex($mapMarker->getMarkerColor()) : null
            ];
          }
        }
      }
    }

    return $resellerLocations;
  }

}