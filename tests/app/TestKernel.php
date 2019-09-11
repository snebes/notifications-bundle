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
use Symfony\Bundle\MakerBundle\MakerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new MakerBundle(),
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
        if (\method_exists($this, 'getProjectDir')) {
            return $this->getProjectDir() . '/var/cache/' . $this->getEnvironment();
        }

        return parent::getCacheDir();
    }

    public function getLogDir()
    {
        if (\method_exists($this, 'getProjectDir')) {
            return $this->getProjectDir() . '/var/cache/' . $this->getEnvironment();
        }

        return parent::getLogDir();
    }
}
