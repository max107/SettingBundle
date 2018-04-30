<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Bundle\SettingBundle\Tests;

use Max107\Bundle\SettingBundle\Entity\Setting;
use Max107\Bundle\SettingBundle\Repository\SettingRepository;
use PHPUnit\Framework\TestCase;

class SettingRepositoryTest extends TestCase
{
    public function testFetchSettings()
    {
        $setting = new Setting();
        $setting->setPath('foo');
        $setting->setValue('bar');
        $entities = [
            $setting,
        ];
        $mock = $this->getMockBuilder(SettingRepository::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(['fetchSettings'])
            ->getMock();
        $mock->method('findAll')->willReturn($entities);
        $this->assertSame([
            'foo' => 'bar',
        ], $mock->fetchSettings());
    }
}
