<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Bundle\SettingBundle\SettingManager;

use Doctrine\ORM\EntityManagerInterface;
use Max107\Bundle\SettingBundle\Entity\Setting;
use Max107\Bundle\SettingBundle\Repository\SettingRepository;
use Max107\Component\Parameters\Parameters;
use Max107\Component\Parameters\ParametersTrait;

class SettingManager
{
    use ParametersTrait;

    private const SYMBOL = '__';

    /**
     * @var SettingRepository
     */
    protected $repository;
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * SettingManager constructor.
     *
     * @param EntityManagerInterface     $em
     * @param SettingRepositoryInterface $settingRepository
     */
    public function __construct(
        EntityManagerInterface $em,
        SettingRepositoryInterface $settingRepository
    ) {
        $this->em = $em;
        $this->repository = $settingRepository;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->repository->fetchSettings();
    }

    /**
     * @param string $key
     *
     * @throws UnknownSettingPathException
     */
    public function remove($key)
    {
        $setting = $this->repository->findOneBy([
            'path' => $key,
        ]);
        if (null === $setting) {
            throw new UnknownSettingPathException(sprintf(
                'Unknown setting in path: %s',
                $key
            ));
        }

        $this->em->remove($setting);
        $this->em->flush();
    }

    /**
     * @param string $name
     *
     * @return Parameters
     */
    public function getBag(string $name): Parameters
    {
        $prefix = sprintf('%s%s', $name, self::SYMBOL);

        $parameters = [];
        foreach ($this->all() as $key => $value) {
            if (0 === strpos($key, $prefix)) {
                $t = substr(
                    $key,
                    \strlen($prefix) // Opcode optimization
                );
                $parameters[$t] = $value;
            }
        }

        return new Parameters($parameters);
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value)
    {
        $setting = $this->repository->findOneBy([
            'path' => $key,
        ]);
        if (null === $setting) {
            $setting = new Setting();
        }
        $setting->setPath((string) $key);
        $setting->setValue((string) $value);

        $this->em->persist($setting);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key, $defaultValue = null)
    {
        $setting = $this->repository->findOneBy([
            'path' => $key,
        ]);
        if (null === $setting) {
            return $defaultValue;
        }

        return $setting->getValue();
    }
}
