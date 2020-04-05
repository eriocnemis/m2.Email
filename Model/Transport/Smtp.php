<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Transport;

/**
 * Email zend smtp transport
 */
class Smtp extends TransportAbstract
{
    /**
     * Email transport type
     */
    const TYPE = 'smtp';

    /**
     * Host config path
     */
    const XML_CONFIG_HOST = 'trans_email/ident_{{IDENTITY}}/host';

    /**
     * Port config path
     */
    const XML_CONFIG_PORT = 'trans_email/ident_{{IDENTITY}}/port';

    /**
     * Ssl config path
     */
    const XML_CONFIG_SSL = 'trans_email/ident_{{IDENTITY}}/ssl';

    /**
     * Auth config path
     */
    const XML_CONFIG_AUTH = 'trans_email/ident_{{IDENTITY}}/auth';

    /**
     * User config path
     */
    const XML_CONFIG_USER = 'trans_email/ident_{{IDENTITY}}/user';

    /**
     * Pass config path
     */
    const XML_CONFIG_PASS = 'trans_email/ident_{{IDENTITY}}/pass';

    /**
     * Storage data
     *
     * @var Storage
     */
    private $storage;

    /**
     * Initialize builder
     *
     * @param Storage $storage
     */
    public function __construct(
        Storage $storage
    ) {
        $this->storage = $storage;
    }

    /**
     * Retrieve transport config
     *
     * @return array
     */
    protected function getConfig()
    {
        return [
            'type' => self::TYPE,
            'options' => $this->getOptions()
        ];
    }

    /**
     * Retrieve transport connection config
     *
     * @return array
     */
    private function getConnectionConfig()
    {
        return [
            'ssl' => $this->storage->getConfigValue(self::XML_CONFIG_SSL),
            'username' => $this->storage->getConfigValue(self::XML_CONFIG_USER),
            'password' => $this->storage->getConfigValue(self::XML_CONFIG_PASS)
        ];
    }

    /**
     * Retrieve file transport config options
     *
     * @return array
     */
    private function getOptions()
    {
        return [
            'host' => $this->storage->getConfigValue(self::XML_CONFIG_HOST),
            'port' => $this->storage->getConfigValue(self::XML_CONFIG_PORT),
            'connection_class' => $this->storage->getConfigValue(self::XML_CONFIG_AUTH),
            'connection_config' => $this->getConnectionConfig()
        ];
    }
}
