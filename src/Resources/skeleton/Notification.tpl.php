<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use SN\Notifications\Contracts\ArrayableInterface;
use SN\Notifications\Contracts\EmailInterface;
use SN\Notifications\Contracts\MailableInterface;
use SN\Notifications\Contracts\NotifiableInterface;
use SN\Notifications\Contracts\NotificationInterface;
use SN\Notifications\Email\Email;

class <?= $class_name ?> implements NotificationInterface, ArrayableInterface, MailableInterface
{
    /**
     * Get the notification's delivery channels.
     *
     * @param NotifiableInterface $notifiable
     *
     * @return array
     */
    public function via(NotifiableInterface $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param NotifiableInterface $notifiable
     *
     * @return \SN\Notifications\Contracts\EmailInterface
     */
    public function toMail(NotifiableInterface $notifiable): EmailInterface
    {
        return (new Email())
            ->subject('The introduction to the notification.')
            ->text('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param NotifiableInterface $notifiable
     *
     * @return array
     */
    public function toArray(NotifiableInterface $notifiable): array
    {
        return [
            //
        ];
    }
}
