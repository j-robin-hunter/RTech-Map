<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace RTech\Map\Controller\Contact;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Contact\Controller\Index implements HttpGetActionInterface {

    public function execute() {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $block = $resultPage->getLayout()->getBlock('contactForm');
        $block->setData('subject', $this->getRequest()->getParam('subject'));
        return $resultPage;
    }
}
