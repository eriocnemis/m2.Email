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
     * @param Storage $storage
     * @param Filesystem $filesystem
     */
    public function __construct(
        Storage $storage,
        Filesystem $filesystem
    ) {
        $this->filesystem = $filesystem;

        parent::__construct(
            $storage
        );
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
            trim($this->storage->getConfigValue(self::XML_CONFIG_PREFIX)),
            time(),
            random_int(1, PHP_INT_MAX),
            trim($this->storage->getConfigValue(self::XML_CONFIG_EXTENSION), '.')
        );
    }

    /**
     * Retrieve email storage path
     *
     * @return string
     */
    private function getPath()
    {
        $path = $this->prepareDir(
            $this->preparePath()
        );
        return $this->getDirectory()->getAbsolutePath($path);
    }

    /**
     * Prepare email storage path
     *
     * @return string
     */
    private function preparePath()
    {
        return str_replace(
            ['{{IDENTITY}}', '{{STORE}}'],
            [$this->storage->getEmailIdentity(), $this->storage->getStoreId()],
            $this->storage->getConfigValue(self::XML_CONFIG_PATH)
        );
    }

    /**
     * Prepare email dir
     *
     * @param string $path
     * @return string
     */
    private function prepareDir(string $path)
    {
        if (!$this->getDirectory()->isExist($path)) {
            $this->getDirectory()->create($path);
        };
        return $path;
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
