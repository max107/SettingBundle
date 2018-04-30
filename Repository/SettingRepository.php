<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Bundle\SettingBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Max107\Bundle\SettingBundle\Entity\Setting;
use Max107\Bundle\SettingBundle\SettingManager\SettingRepositoryInterface;

/**
 * @method Setting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Setting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Setting[]    findAll()
 * @method Setting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingRepository extends EntityRepository implements SettingRepositoryInterface
{
    /**
     * Return key => value array from repository
     *
     * @return array
     */
    public function fetchSettings(): array
    {
        $settings = [];
        foreach ($this->findAll() as $entity) {
            $settings[$entity->getPath()] = $entity->getValue();
        }

        return $settings;
    }
}
