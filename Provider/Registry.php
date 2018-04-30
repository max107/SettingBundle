<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max107\Bundle\SettingBundle\Provider;

class Registry
{
    /**
     * @var SettingProviderInterface[]
     */
    protected $providers = [];

    /**
     * @param string                   $code
     * @param SettingProviderInterface $provider
     */
    public function addProvider(string $code, SettingProviderInterface $provider)
    {
        $this->providers[$code] = $provider;
    }

    /**
     * @param string $code
     *
     * @return bool
     */
    public function hasProvider(string $code): bool
    {
        return array_key_exists($code, $this->providers);
    }

    /**
     * @param string $code
     *
     * @throws \Exception
     *
     * @return SettingProviderInterface
     */
    public function getProvider(string $code): SettingProviderInterface
    {
        if (false === $this->hasProvider($code)) {
            throw new \Exception(sprintf(
                'Unknown setting provider: %s',
                $code
            ));
        }

        return $this->providers[$code];
    }

    /**
     * @return SettingProviderInterface[]
     */
    public function getProviders(): array
    {
        return $this->providers;
    }
}
