<?php
/**
* Copyright © 2019 Roma Technology Limited. All rights reserved.
* See COPYING.txt for license details.
*/
namespace RTech\Map\Setup;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallData implements InstallDataInterface {

  const LOCATION_ATTRIBUTE_CODE = 'location';

  private $eavSetup;
  private $eavConfig;

  public function __construct(
    \Magento\Eav\Setup\EavSetup $eavSetup,
    \Magento\Eav\Model\Config $eavConfig
  ) {
    $this->eavSetup = $eavSetup;
    $this->eavConfig = $eavConfig;
  }

  public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {

    $setup->startSetup();

    $this->eavSetup->addAttribute(
      AddressMetadataInterface:: ENTITY_TYPE_ADDRESS,
      self::LOCATION_ATTRIBUTE_CODE,
      [
        'label' => 'Location',
        'input' => 'text',
        'visible' => true,
        'required' => false,
        'position' => 150,
        'sort_order' => 150,
        'system' => false
      ]
    );

    $locationAttribute = $this->eavConfig->getAttribute(
      AddressMetadataInterface:: ENTITY_TYPE_ADDRESS,
      self::LOCATION_ATTRIBUTE_CODE
    );
    $locationAttribute->setData(
      'used_in_forms',
      ['adminhtml_customer_address']
    );
    $locationAttribute->save();

    $setup->endSetup();
  }
}