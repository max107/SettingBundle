<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Bundle\SettingBundle\Tests;

use Max107\Bundle\SettingBundle\SettingManager\SettingManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KernelTest extends WebTestCase
{
    public function testIntegration()
    {
        self::bootKernel();

        $container = self::$kernel->getContainer();
        $settingManager = $container->get('max107.bundle.setting_manager');
        $this->assertInstanceOf(SettingManager::class, $settingManager);
        $this->assertTrue($container->has('max107.bundle.setting_manager.setting_repository'));
    }
}
