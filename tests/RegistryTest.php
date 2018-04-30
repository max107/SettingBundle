<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Bundle\SettingBundle\Tests;

use Max107\Bundle\SettingBundle\Provider\Registry;
use Max107\Bundle\SettingBundle\Provider\SettingProviderInterface;
use PHPUnit\Framework\TestCase;

class RegistryTest extends TestCase
{
    public function testRegistry()
    {
        $provider = $this->createMock(SettingProviderInterface::class);

        $registry = new Registry();
        $this->assertCount(0, $registry->getProviders());
        $registry->addProvider('test', $provider);
        $this->assertCount(1, $registry->getProviders());
        $this->assertTrue($registry->hasProvider('test'));
        $this->assertInstanceOf(SettingProviderInterface::class, $registry->getProvider('test'));
    }

    /**
     * @expectedException \Exception
     */
    public function testUnknownProvider()
    {
        $registry = new Registry();
        $registry->getProvider('test');
    }
}
