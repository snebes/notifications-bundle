<?php
/**
 * (c) Steve Nebes (steve@nebes.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SN\Bundle\NotificationsBundle\Tests\app;

use SN\Bundle\NotificationsBundle\SNNotificationsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new SNNotificationsBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->loadFromExtension('framework', [
                'secret' => 'secret',
                'router' => [
                    'resource' => __DIR__ . '/routing.yaml',
                ],
                'annotations' => Kernel::VERSION_ID >= 30200 ? false : [],
            ]);
        });
    }

    public function getCacheDir()
    {
        return __DIR__.'/../cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return __DIR__.'/../logs/'.$this->getEnvironment();
    }
}
