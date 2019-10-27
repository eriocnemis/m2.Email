<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Controller\Adminhtml\Index;

use Magento\Framework\Exception\LocalizedException;
use Eriocnemis\Email\App\Action\Context;
use Eriocnemis\Email\Controller\Adminhtml\Index as Action;
use Eriocnemis\Email\Model\ResourceModel\Email as EmailResource;

/**
 * Delete controller
 */
class Delete extends Action
{
    /**
     * Email resource
     *
     * @var EmailResource
     */
    protected $emailResource;

    /**
     * Initialize controller
     *
     * @param Context $context
     * @param EmailResource $emailResource
     */
    public function __construct(
        Context $context,
        EmailResource $emailResource
    ) {
        $this->emailResource = $emailResource;

        parent::__construct(
            $context
        );
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        try {
            /** @var \Eriocnemis\Email\Model\Email $email */
            $email = $this->initEmail();
            $this->emailResource->delete($email);

            $this->messageManager->addSuccess(
                __('You deleted the email.')
            );

            return $this->_redirect(
                '*/*/index'
            );
        } catch (LocalizedException $e) {
            $this->messageManager->addError(
                $e->getMessage()
            );
        } catch (\Exception $e) {
            $this->messageManager->addError(
                __('We can\'t delete the email right now. Please review the log and try again.')
            );
            $this->logger->critical($e);
        }

        return $this->_redirect('*/*/*', ['id' => $id, '_current' => true]);
    }
}
