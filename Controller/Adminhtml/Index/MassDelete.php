<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Controller\Adminhtml\Index;

use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Eriocnemis\Email\App\Action\Context;
use Eriocnemis\Email\Model\ResourceModel\Email\CollectionFactory;
use Eriocnemis\Email\Controller\Adminhtml\Index as Action;

/**
 * Mass delete controller
 */
class MassDelete extends Action
{
    /**
     * Mass action filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * Email collection factory
     *
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Initialize controller
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;

        parent::__construct(
            $context
        );
    }

    /**
     * Mass delete action
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection(
                $this->collectionFactory->create()
            );

            $size = $collection->getSize();
            if (!$size) {
                $this->messageManager->addError(
                    __('Please correct the emails you requested.')
                );
                return $this->_redirect('*/*/*');
            }

            $collection->walk('delete');

            $this->messageManager->addSuccess(
                __('You deleted a total of %1 records.', $size)
            );
        } catch (LocalizedException $e) {
            $this->messageManager->addError(
                $e->getMessage()
            );
        } catch (\Exception $e) {
            $this->messageManager->addError(
                __('We can\'t delete these rules right now. Please review the log and try again.')
            );
            $this->logger->critical($e);
        }

        return $this->_redirect('*/*/index', ['_current' => true]);
    }
}
