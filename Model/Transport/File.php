<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Model\Transport;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;

/**
 * Email zend file transport
 */
class File extends TransportAbstract
{
    /**
     * Email transport type
     */
    const TYPE = 'file';

    /**
     * Path config path
     */
    const XML_CONFIG_PATH = 'trans_email/ident_{{IDENTITY}}/path';

    /**
     * Prefix config path
     */
    const XML_CONFIG_PREFIX = 'trans_email/ident_{{IDENTITY}}/prefix';

    /**
     * Extension config path
     */
    const XML_CONFIG_EXTENSION = 'trans_email/ident_{{IDENTITY}}/extension';

    /**
     * Email template identity
     *
     * @var Identity
     */
    private $identity;

    /**
     * Write interface
     *
     * @var WriteInterface
     */
    private $dir;

    /**
     * Filesystem
     *
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Initialize builder
     *
     * @param Identity $identity
     * @param Filesystem $filesystem
     */
    public function __construct(
        Identity $identity,
        Filesystem $filesystem
    ) {
        $this->identity = $identity;
        $this->filesystem = $filesystem;
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
     * Retrieve file transport config options
     *
     * @return array
     */
    private function getOptions()
    {
        return [
            'path' => $this->getPath(),
            'callback' => $this->getCallback()
        ];
    }

    /**
     * Retrieve a callable to be invoked in order to generate a unique name for a message file
     *
     * @return callable
     */
    private function getCallback()
    {
        $filename = $this->getFilename();
        return function () use ($filename) {
            return $filename;
        };
    }

    /**
     * Retrieve a unique name for a message fileh
     *
     * @return string
     */
    private function getFilename()
    {
        return sprintf(
            '%s_%u_%u.%s',
            trim($this->identity->getConfigValue(self::XML_CONFIG_PREFIX)),
            time(),
            random_int(1, PHP_INT_MAX),
            trim($this->identity->getConfigValue(self::XML_CONFIG_EXTENSION), '.')
        );
    }

    /**
     * Retrieve email storage path
     *
     * @return string
     */
    private function getPath()
    {
        $path = $this->identity->getConfigValue(self::XML_CONFIG_PATH);
        /* create directory if not exist */
        if (!$this->getDirectory()->isExist($path)) {
            $this->getDirectory()->create($path);
        }
        return $this->getDirectory()->getAbsolutePath($path);
    }

    /**
     * Create an instance of directory with write permissions
     *
     * @return WriteInterface
     */
    private function getDirectory()
    {
        if (null === $this->dir) {
            $this->dir = $this->filesystem->getDirectoryWrite(
                DirectoryList::VAR_DIR
            );
        }
        return $this->dir;
    }
}
