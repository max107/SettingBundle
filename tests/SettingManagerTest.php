<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Bundle\SettingBundle\Tests;

use Doctrine\ORM\EntityManager;
use Max107\Bundle\SettingBundle\Entity\Setting;
use Max107\Bundle\SettingBundle\Repository\SettingRepository;
use Max107\Bundle\SettingBundle\SettingManager\SettingManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SettingManagerTest extends TestCase
{
    public function testSet()
    {
        $settingMock = new Setting();
        $settingMock->setPath('foo_bar');
        $settingMock->setValue('yo');

        $em = $this->createMock(EntityManager::class);
        $em
            ->expects($this->exactly(2))
            ->method('persist');
        $repository = $this->createMock(SettingRepository::class);
        $repository
            ->method('findOneBy')
            ->willReturnCallback(function ($query) use ($settingMock) {
                if ('unknown' === $query['path']) {
                    return null;
                }

                return $settingMock;
            });

        $settingManager = new SettingManager($em, $repository);
        $settingManager->set('foo_bar', 'yo');
        $settingManager->set('unknown', 'yo');
    }

    public function testRemove()
    {
        $settingMock = new Setting();
        $settingMock->setPath('foo_bar');
        $settingMock->setValue('yo');

        /** @var SettingRepository|MockObject $repoMock */
        $em = $this->createMock(EntityManager::class);
        $em
            ->expects($this->once())
            ->method('remove')
            ->with($settingMock);
        $repository = $this->createMock(SettingRepository::class);
        $repository
            ->method('findOneBy')
            ->willReturnCallback(function ($query) use ($settingMock) {
                if ('unknown' === $query['path']) {
                    return null;
                }

                return $settingMock;
            });

        $settingManager = new SettingManager($em, $repository);
        $settingManager->remove('foo_bar', 'yo');
    }

    /**
     * @expectedException \Max107\Bundle\SettingBundle\SettingManager\UnknownSettingPathException
     */
    public function testRemoveException()
    {
        /** @var SettingRepository|MockObject $repoMock */
        $em = $this->createMock(EntityManager::class);
        $em
            ->expects($this->never())
            ->method('remove');
        $repository = $this->createMock(SettingRepository::class);
        $repository
            ->method('findOneBy')
            ->willReturn(null);

        $settingManager = new SettingManager($em, $repository);
        $settingManager->remove('foo_bar', 'yo');
    }

    public function testAll()
    {
        /** @var SettingRepository|MockObject $repoMock */
        $em = $this->createMock(EntityManager::class);
        $repository = $this->createMock(SettingRepository::class);
        $repository
            ->method('fetchSettings')
            ->willReturn(['hello' => 'world', 'foo' => 'bar']);

        $settingManager = new SettingManager($em, $repository);
        $this->assertCount(2, $settingManager->all());
    }

    public function testGetBag()
    {
        /** @var SettingRepository|MockObject $repoMock */
        $em = $this->createMock(EntityManager::class);
        $repository = $this->createMock(SettingRepository::class);
        $repository
            ->method('fetchSettings')
            ->willReturn(['foo__hello' => '1', 'foo__world' => '2']);

        $settingManager = new SettingManager($em, $repository);
        $this->assertCount(2, $settingManager->getBag('foo'));
    }

    public function testGet()
    {
        $settingMock = new Setting();
        $settingMock->setPath('hello');
        $settingMock->setValue('world');

        /** @var SettingRepository|MockObject $repoMock */
        $em = $this->createMock(EntityManager::class);
        $repository = $this->createMock(SettingRepository::class);
        $repository
            ->method('findOneBy')
            ->willReturnCallback(function ($query) use ($settingMock) {
                if ('unknown' === $query['path']) {
                    return null;
                }

                return $settingMock;
            });

        $settingManager = new SettingManager($em, $repository);
        $this->assertSame('world', $settingManager->get('hello'));
        $this->assertNull($settingManager->get('unknown'));
    }
}
