<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Su cita en " . config('app.name'))
            ->greeting("Apreciado(a) {$this->appointment->customer->present()->name()}")
            ->line("Esta es la confirmación de su cita con los siguientes datos:")
            ->line("- Fecha: {$this->appointment->present()->date()}")
            ->line("- Hora: {$this->appointment->present()->startTime()}")
            ->line("- Servicio: {$this->appointment->service->present()->name()}")
            ->line("- Profesional: {$this->appointment->employee->present()->name()}")
            ->line('Gracias por confiar en nosotros.')
            ->line("<br>");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
