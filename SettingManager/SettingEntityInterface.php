<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Bundle\SettingBundle\SettingManager;

interface SettingEntityInterface
{
    /**
     * @param string $path
     *
     * @void
     */
    public function setPath(string $path): void;

    /**
     * @return null|string
     */
    public function getPath(): ?string;

    /**
     * @param null|string $value
     *
     * @return null|string
     */
    public function setValue(?string $value): ?string;

    /**
     * @return null|string
     */
    public function getValue(): ?string;
}
