<?php
/**
 * Copyright © 2019 Roma Technology Limited. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace RTech\Map\Block;

use Magento\Framework\View\Element\Template;

class ContactForm extends Template {

    public function __construct(Template\Context $context, array $data = [])  {
        parent::__construct($context, $data);
        $this->_isScopePrivate = true;
    }

    public function getFormAction() {
        return $this->getUrl('contact/index/post', ['_secure' => true]);
    }

    public function getSubject() {
        return $this->getData('subject') ?: null;
    }
}