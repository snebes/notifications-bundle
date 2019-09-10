<?php
/**
 * (c) Steve Nebes (steve@nebes.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SN\Bundle\NotificationsBundle\Tests;

use PHPUnit\Framework\TestCase;
use SN\Bundle\NotificationsBundle\Tests\app\TestKernel;
use SN\Notifications\NotificationSender;

class FunctionalTest extends TestCase
{
    public function testServiceWiring(): void
    {
        $kernel = new TestKernel('test', true);
        $kernel->boot();
        $container = $kernel->getContainer();
        $this->assertTrue($container->has('sn_notifications.notification_sender'));

        $sender = $container->get('sn_notifications.notification_sender');
        $this->assertInstanceOf(NotificationSender::class, $sender);
    }
}
