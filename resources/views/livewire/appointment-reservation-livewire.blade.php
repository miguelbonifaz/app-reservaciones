<div>
    @php
        use App\Http\Livewire\AppointmentReservationLivewire;
    @endphp
    <div class="mx-auto max-w-5xl sm:rounded-md">
        <div class="hidden grid-cols-5 gap-2 mb-6 md:grid">
            <div>
                <label class="text-sm font-bold text-mariajose_gray" for="">1.Servicio</label>
                <div class="h-3 rounded-l-md bg-mariajose_gray {{ $this->firstStepProgressBarClass }}">
                </div>
            </div>
            <div>
                <label class="text-sm font-bold text-mariajose_gray" for="">2.Hora</label>
                <div class="h-3 bg-mariajose_gray {{ $this->secondStepProgressBarClass }}">
                </div>
            </div>
            <div>
                <label class="text-sm font-bold text-mariajose_gray" for="">3.Información</label>
                <div class="h-3 bg-mariajose_gray {{ $this->thirdStepProgressBarClass }}">
                </div>
            </div>
            <div>
                <label class="text-sm font-bold text-mariajose_gray" for="">4.Detalles</label>
                <div class="h-3 bg-mariajose_gray {{ $this->fourthStepProgressBarClass }}">
                </div>
            </div>
            <div>
                <label class="text-sm font-bold text-mariajose_gray" for="">5.Reservación</label>
                <div class="h-3 rounded-r-md bg-mariajose_gray {{ $this->fifthStepProgressBarClass }}">
                </div>
            </div>
        </div>
        <div class="bg-white">
            <div class="grid gap-6 sm:grid-cols-2">
                @if ($currentStep == AppointmentReservationLivewire::STEP_SERVICE_AND_EMPLOYEE)
                    <x-input.select
                        label="Escoje un servicio"
                        name="form.service_id"
                        wire:model="form.service_id"
                        placeholder="Servicio">
                        @foreach ($this->services as $service)
                            <option value="{{ $service->id }}">{{ $service->present()->name() }}</option>
                        @endforeach
                    </x-input.select>
                    <x-input.select
                        label="Escoje un profesional"
                        name="form.employee_id"
                        wire:model="form.employee_id"
                        placeholder="Profesional">
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->present()->name() }}</option>
                        @endforeach
                    </x-input.select>
                    <x-website.reservation.footer
                        :nextStep="AppointmentReservationLivewire::STEP_DATE_AND_HOUR"
                    />
                @endif

                @if ($currentStep == AppointmentReservationLivewire::STEP_DATE_AND_HOUR)
                    <div class="sm:col-span-2">
                        <livewire:date-picker-livewire/>
                    </div>
                    <x-website.reservation.footer
                        :stepBack="AppointmentReservationLivewire::STEP_SERVICE_AND_EMPLOYEE"
                        :nextStep="AppointmentReservationLivewire::STEP_DETAILS"
                    />
                @endif

                @if ($currentStep == AppointmentReservationLivewire::STEP_DETAILS)
                    details
                @endif

                @if ($currentStep == AppointmentReservationLivewire::STEP_FORM_CUSTOMER)
                    form customer
                @endif

                @if ($currentStep == AppointmentReservationLivewire::STEP_FAREWELL)
                    Farewell
                @endif

            </div>
        </div>
    </div>
</div>
