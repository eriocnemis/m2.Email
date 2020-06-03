<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Controller\Adminhtml\Message;

use Psr\Log\LoggerInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\MailException;
use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Eriocnemis\Email\Model\Email\Extractor;
use Eriocnemis\Email\Model\Email\Sender;

/**
 * Message send controller
 */
class Send extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magento_Config::config';

    /**
     * Result factory
     *
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * Email sender
     *
     * @var Sender
     */
    private $sender;

    /**
     * Test email extractor
     *
     * @var Extractor
     */
    private $extractor;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Initialize controller
     *
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param Extractor $extractor
     * @param Sender $sender
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        Extractor $extractor,
        Sender $sender,
        LoggerInterface $logger
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->extractor = $extractor;
        $this->sender = $sender;
        $this->logger = $logger;

        parent::__construct(
            $context
        );
    }

    /**
     * Send email action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->getRequest()->isAjax()) {
            $this->_forward('noroute');
            return;
        }

        $result = ['error' => true];
        try {
            $this->extractor->extract($this->getRequest());
            $this->sender->send();

            $result = [
                'error' => false,
                'message' => __('Sent successfully! Please check your email box.')
            ];
        } catch (MailException $e) {
            $result['message'] = $e->getMessage();
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $result['message'] = __(
                'We can\'t send the email right now. Please review the log and try again.'
            );
        }

        /** @var \Magento\Framework\Controller\Result\Json $json */
        $json = $this->resultJsonFactory->create();
        return $json->setData($result);
    }
}
