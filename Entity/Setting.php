<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Bundle\SettingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Max107\Bundle\SettingBundle\Repository\SettingRepository")
 * @UniqueEntity("path")
 */
class Setting
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=254, unique=true)
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=254, nullable=true)
     */
    private $value;

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path)
    {
        $this->path = $path;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value)
    {
        $this->value = $value;
    }
}
