<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Controller\Adminhtml\Index;

use Eriocnemis\Email\Controller\Adminhtml\Index as Action;

/**
 * Index controller
 */
class Index extends Action
{
    /**
     * Emails list
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Eriocnemis_Email::email');
        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            __('Sending Emails')
        );
        $this->_view->renderLayout();
    }
}
