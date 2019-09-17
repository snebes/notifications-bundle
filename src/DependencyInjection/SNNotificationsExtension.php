<?php
/**
 * (c) Steve Nebes <steve@nebes.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SN\Bundle\NotificationsBundle\DependencyInjection;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use SN\Notifications\Channel\DatabaseChannel;
use SN\Notifications\Channel\MailChannel;
use SN\Notifications\Contracts\MailerInterface;
use SN\Notifications\Mailer\SwiftMailerMailer;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * @author Steve Nebes <steve@nebes.net>
 */
class SNNotificationsExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        if (\class_exists(DoctrineBundle::class)) {
            $def = new Definition(DatabaseChannel::class, [
                '@?doctrine.orm.entity_manager',
                'SN\Bundle\NotificationsBundle\Entity\Notification'
            ]);
            $def->setPublic(false);
            $def->addTag('kernel.event_subscriber');
            $container->setDefinition('sn_notifications.channel.database_channel', $def);
        }

        if (\class_exists(SwiftmailerBundle::class)) {
            // Mailer.
            $def = new Definition(SwiftMailerMailer::class, [
                '@?swiftmailer.mailer',
            ]);
            $def->setPublic(false);

            $container->setDefinition('sn_notifications.mailer.swiftmailer_mailer', $def);
            $container->setAlias(MailerInterface::class, 'sn_notifications.mailer.swiftmailer_mailer');

            // Mail channel.
            $def = new Definition(MailChannel::class, [
                '@' . MailerInterface::class,
            ]);
            $def->setPublic(false);
            $def->addTag('kernel.event_subscriber');

            $container->setDefinition('sn_notifications.channel.mail_channel', $def);
        }
    }
}
