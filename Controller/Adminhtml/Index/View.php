<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Controller\Adminhtml\Index;

use Magento\Framework\Exception\LocalizedException;
use Eriocnemis\Email\Controller\Adminhtml\Index as Action;

/**
 * View controller
 */
class View extends Action
{
    /**
     * View action
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        try {
            /** @var \Eriocnemis\Email\Model\Email $email */
            $email = $this->initEmail();
        } catch (LocalizedException $e) {
            $this->messageManager->addError(
                $e->getMessage()
            );
            return $this->_redirect('*/*/');
        } catch (\Exception $e) {
            $this->logger->critical($e);
            return $this->_redirect('*/*/');
        }

        $this->initAction();

        $title = $email->getSubject();
        $this->_addBreadcrumb($title, $title);

        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $title
        );
        $this->_view->renderLayout();
    }
}
