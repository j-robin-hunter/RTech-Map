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
    //return $this->_configData->getInstallerMapCentreLatitude($this->_storeId);
    return $this->getData('lat');
  }

  public function getMapCentreLongitude() {
    //return $this->_configData->getInstallerMapCentreLongitude($this->_storeId);
    return $this->getData('lon');
  }

  public function getMapZoom() {
    //return $this->_configData->getInstallerMapZoom($this->_storeId);
    return $this->getData('zoom');
  }

  public function getResellers() {
    $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/log_file_name.log');
$this->_logger = new \Zend\Log\Logger();
$this->_logger->addWriter($writer);
$this->_logger->info(explode(',', $this->getData('address_groups')));
$this->_logger->info($this->_configData->getInstallerCustomerGroups($this->_storeId));
    $resellers = $this->_customerFactory->create()
      ->getCollection()
      ->addFieldToFilter('group_id', array('in' => explode(',', $this->getData('address_groups'))));
    $countries = $this->_countryFactory->create();
    $resellerLocations = [];
    foreach ($resellers->getItems() as $reseller) {
        $account = $this->_customerRepository->getById($reseller->getId());
        foreach($reseller->getAddresses() as $address) {
          if ($address->getLocation()) {
            $location = explode(',', $address->getLocation());
            if (count($location) == 2) {
              $resellerLocations[] = [
                'type' => $this->getGroupName($reseller->getGroupId()),
                'company' => $address->getCompany(),
                'street' => $address->getStreet(),
                'city' => $address->getCity(),
                'region' => $address->getRegion(),
                'postcode' => $address->getPostcode(),
                'country' => $countries->loadByCode($address->getCountryId())->getName(),
                'telephone' => $address->getTelephone(),
                'email' => $reseller->getEmail(),
                'website' => $account->getCustomAttribute('website')->getValue(),
                'lat' => $location[0],
                'lon' => $location[1]
              ];
            }
          }
        }
    }
    return $resellerLocations;
  }

  public function getGroupName($groupId){
    $group = $this->_groupRepository->getById($groupId);
    return $group->getCode();
  }
}