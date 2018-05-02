<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Bundle\SettingBundle\Twig;

use Max107\Bundle\SettingBundle\SettingManager\SettingManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SettingExtension extends AbstractExtension
{
    /**
     * @var SettingManager
     */
    protected $settingManager;

    /**
     * SettingExtension constructor.
     *
     * @param SettingManager $settingManager
     */
    public function __construct(SettingManager $settingManager)
    {
        $this->settingManager = $settingManager;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_setting_value', [$this, 'getSettingValue']),
        ];
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function getSettingValue(string $key, $default = null)
    {
        return $this->settingManager->get($key, $default);
    }
}
