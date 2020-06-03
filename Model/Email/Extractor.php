<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Email;

use Magento\Framework\App\RequestInterface;
use Eriocnemis\Email\Model\Transport\Storage;

/**
 * Email data extractor
 */
class Extractor
{
    /**
     * Storage data
     *
     * @var Storage
     */
    private $storage;

    /**
     * Sender config data
     *
     * @var array
     */
    private $config = [];

    /**
     * Initialize extractor
     *
     * @param Storage $storage
     */
    public function __construct(
        Storage $storage
    ) {
        $this->storage = $storage;
    }

    /**
     * Extract data
     *
     * @param RequestInterface $request
     * @return void
     */
    public function extract(RequestInterface $request)
    {
        //$sectionId = $request->getParam('section');
        // ?? validate access to $sectionId
        //$websiteId = $request->getParam('website');
        $storeId = $request->getParam('store');
        $groups = $request->getPost('groups');

        foreach ($groups as $group => $data) {
            $this->storage->setEmailIdentity(str_replace('ident_', '', $group));
            foreach ($data['fields'] as $field => $value) {
                if (!$this->isValid($value)) {
                    continue;
                }

                if ($this->isSpecific($field)) {
                    $this->setSpecific($field, $value['value']);
                } else {
                    $this->setConfig($group, $field, $value['value']);
                }

                if ($field == 'name') {
                    $name = $value['value'];
                    continue;
                }
                if ($field == 'email') {
                    $email = $value['value'];
                    continue;
                }
            }
        }
        // ?? validate to
        // ?? validate email name identity
        $this->storage->setStoreId($storeId);
        $this->storage->setConfig($this->config);
    }

    private function setSpecific($field, $value)
    {
        if ($field == 'to') {
            $this->storage->addRecipient($value);
        } else {
        
        }
    }

    private function setConfig($group, $field, $value)
    {
        $path = 'trans_email/' . $group . '/' . $field;
        $this->config[$path] = $value;
    }

    /**
     * Checks if config value is valid
     *
     * @param array $value
     * @return bool
     */
    private function isValid(array $value)
    {
        if (!isset($value['value']) ||
            !empty($value['inherit']) ||
            false !== strpos($value['value'], '*')
        ) {
            return false;
        }
        return true;
    }

    /**
     * Checks if config value is specific
     *
     * @param string $field
     * @return bool
     */
    private function isSpecific($field)
    {
        return in_array($field, ['name', 'email', 'to']);
    }
}
