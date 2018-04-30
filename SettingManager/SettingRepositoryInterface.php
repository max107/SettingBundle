<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Bundle\SettingBundle\SettingManager;

interface SettingRepositoryInterface
{
    /**
     * Return key => value array from repository
     *
     * @return array
     */
    public function fetchSettings(): array;
}
