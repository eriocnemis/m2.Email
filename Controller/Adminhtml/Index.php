<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Controller\Adminhtml;

use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\App\Action;
use Eriocnemis\Email\App\Action\Context;
use Eriocnemis\Email\Model\Constant;

/**
 * Index abstract controller
 */
abstract class Index extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Eriocnemis_Email::email';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Email factory
     *
     * @var \Eriocnemis\Email\Model\EmailFactory
     */
    protected $emailFactory;

    /**
     * Logger
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Initialize controller
     *
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->coreRegistry = $context->getCoreRegistry();
        $this->emailFactory = $context->getEmailFactory();
        $this->logger = $context->getLogger();

        parent::__construct(
            $context->getContext()
        );
    }

    /**
     * Init active menu and set breadcrumb
     *
     * @return $this
     */
    protected function initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu(
            'Eriocnemis_Email::email'
        )->_addBreadcrumb(
            __('Sending Emails'),
            __('Sending Emails')
        );

        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            __('Sending Emails')
        );
        return $this;
    }

    /**
     * Initialize proper model
     *
     * @param string $requestParam
     * @return \Eriocnemis\Email\Model\Email
     * @throws LocalizedException
     */
    protected function initEmail($requestParam = 'id')
    {
        $id = $this->getRequest()->getParam($requestParam, 0);
        $email = $this->emailFactory->create();
        if ($id) {
            $email->load($id);
            if (!$email->getId()) {
                throw new LocalizedException(
                    __('Please correct the email you requested.')
                );
            }
        }
        /* register current email */
        $this->coreRegistry->register(
            Constant::CURRENT_EMAIL,
            $email
        );
        /* register current email id */
        $this->coreRegistry->register(
            Constant::CURRENT_EMAIL_ID,
            $email->getId()
        );
        return $email;
    }
}
