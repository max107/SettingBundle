<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Bundle\SettingBundle\Tests\Twig;

use Max107\Bundle\SettingBundle\SettingManager\SettingManager;
use Max107\Bundle\SettingBundle\Twig\SettingExtension;
use PHPUnit\Framework\TestCase;

class SettingExtensionTest extends TestCase
{
    public function testGetValue()
    {
        $settingManager = $this->createMock(SettingManager::class);
        $settingManager
            ->expects($this->once())
            ->method('get')
            ->willReturn('123');

        $extension = new SettingExtension($settingManager);
        $this->assertSame('123', $extension->getSettingValue('foo'));
        $this->assertCount(1, $extension->getFunctions());
    }
}
