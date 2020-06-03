<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\Email\Test\Unit\Model\Config\Source\Address;

use Eriocnemis\Email\Model\Config\Source\Auth as Source;

/**
 * Test auth source
 */
class AuthTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Source model
     *
     * @var Source
     */
    protected $source;

    /**
     * Source options
     *
     * @var array
     */
    protected $options = [
        '' => 'Authentication Not Required',
        'plain' => 'Plain',
        'login' => 'Login',
        'crammd5' => 'CRAM-MD5'
    ];

    /**
     * Prepare test
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->source = new Source;
    }

    /**
     * Test options in key-value format
     *
     * @return void
     * @test
     */
    public function testToArray()
    {
        $this->assertEquals($this->options, $this->source->toArray());
    }

    /**
     * Test options
     *
     * @return void
     * @test
     */
    public function testToOptionArray()
    {
        $expected = [];
        foreach ($this->options as $value => $label) {
            $expected[] = ['value' => $value, 'label' => $label];
        }
        $this->assertEquals($expected, $this->source->toOptionArray());
    }
}
