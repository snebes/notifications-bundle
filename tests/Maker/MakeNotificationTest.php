<?php
/**
 * (c) Steve Nebes (steve@nebes.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SN\Bundle\NotificationsBundle\Tests\Maker;

use PHPUnit\Framework\TestCase;
use SN\Bundle\NotificationsBundle\Maker\MakeNotification;
use SN\Bundle\NotificationsBundle\Tests\app\TestKernel;

/**
 * @author Steve Nebes <steve@nebes.net>
 */
class MakeNotificationTest extends TestCase
{
    public function testCommand(): void
    {
        $kernel = new TestKernel();
        $kernel->boot();
        $container = $kernel->getContainer();

        $maker = $container->get('sn_notifications.maker.make_notification');
        $this->assertInstanceOf(MakeNotification::class, $maker);
    }
}
