<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Bundle\SettingBundle\Tests;

use Max107\Bundle\SettingBundle\DependencyInjection\SettingExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SettingExtensionTest extends TestCase
{
    public function testExtension()
    {
        $ext = new SettingExtension();
        $builder = new ContainerBuilder();
        $configs = [];
        $ext->load($configs, $builder);
        $this->assertTrue($builder->hasDefinition('max107.bundle.setting_manager.setting_repository'));
    }
}
