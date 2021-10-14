<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;

class AppointmentConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $service;
    public $location;
    public $employee;
    public $slots;
    public $customer;
    public $dateAndHour = [];
    public $value;

    public function __construct(Collection $appointments)
    {
        $this->dateAndHour = $appointments
            ->map(function (Appointment $appointment) {
                return [
                    'date' => $appointment->present()->date(),
                    'start_time' => $appointment->present()->startTime(),
                ];
            })->toArray();

        /** @var Appointment $appointment */
        $appointment = $appointments->first();

        $this->value = $appointment->service->present()->value();
        $this->customer = $appointment->customer->present()->name();
        $this->service = $appointment->service->present()->name();
        $this->slots = $appointment->service->slots;
        $this->location = $appointment->service->place ??
            $appointment->location->present()->name();
        $this->employee = $appointment->employee->present()->name();
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
            ->markdown('emails.appointment-confirmed', [
                'customer' => $this->customer,
                'service' => $this->service,
                'slots' => $this->slots,
                'dateAndHour' => $this->dateAndHour,
                'location' => $this->location,
                'employee' => $this->employee,
                'value' => $this->value,
            ]);
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
