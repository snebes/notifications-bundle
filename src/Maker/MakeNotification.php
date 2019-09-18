<?php
/**
 * (c) Steve Nebes (steve@nebes.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SN\Bundle\NotificationsBundle\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

/**
 * @author Steve Nebes <steve@nebes.net>
 */
final class MakeNotification extends AbstractMaker
{
    public static function getCommandName(): string
    {
        return 'make:sn:notification';
    }

    /**
     * @codeCoverageIgnore
     */
    public function configureCommand(Command $command, InputConfiguration $inputConf)
    {
        $command
            ->setDescription('Creates a new notification class.')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the class')
            ->setHelp(file_get_contents(__DIR__.'/../Resources/help/MakeNotification.txt'));
    }

    /**
     * @codeCoverageIgnore
     */
    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $testClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            'Notification\\',
            'Notification'
        );

        $generator->generateClass(
            $testClassNameDetails->getFullName(),
            __DIR__.'/../Resources/skeleton/Notification.tpl.php',
            []
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);

        $io->text([
            'Next: Open your new notification class and start customizing it.',
            'Find the documentation at <fg=yellow>https://github.com/snebes/notifications-bundle</>',
        ]);
    }

    /**
     * @codeCoverageIgnore
     */
    public function configureDependencies(DependencyBuilder $dependencies)
    {
    }
}
