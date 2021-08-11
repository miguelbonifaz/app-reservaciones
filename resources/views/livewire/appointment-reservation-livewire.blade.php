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
                        wire:model.lazy="form.service_id"
                        placeholder="Servicio">
                        @foreach ($this->services as $service)
                            <option value="{{ $service->id }}">{{ $service->present()->name() }}</option>
                        @endforeach
                    </x-input.select>
                    <x-input.select
                        label="Escoje un profesional"
                        name="form.employee_id"
                        wire:model.lazy="form.employee_id"
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
                        <div class="flex flex-col space-x-2 lg:flex-row">
                            <div class="mb-6 lg:w-96">
                                <livewire:date-picker-livewire
                                    :employeeId="$this->form['employee_id']"
                                />
                                <x-ui.error :type="$this->form['date']"/>
                            </div>
                            <div>
                                <div
                                    class="px-3 py-2 mb-1 w-32 text-center text-white rounded-lg border border-gray-200 bg-mariajose_gray">
                                    {{ $this->selectedDay ?? 'Cargando...' }}
                                </div>
                                <div class="grid grid-cols-2 gap-2 lg:flex lg:flex-col lg:h-72 lg:flex-wrap lg:gap-0">
                                    @foreach ($this->availableHours as $data)
                                        <label
                                            class="mr-2 w-full lg:w-32 text-center border border-gray-200 text-center py-2 rounded-lg mb-1 flex items-center justify-center {{ $this->hourNotAvailableClasses($data['isAvailable']) }}">
                                            <input
                                                @if (!$data['isAvailable'])
                                                disabled
                                                @else
                                                wire:model.lazy="form.start_time"
                                                @endif
                                                class="mr-1 w-4 h-4 border-gray-300 focus:ring-mariajose_gray text-mariajose_gray"
                                                name="start_time"
                                                type="radio"
                                                value="{{ $data['hour'] }}">
                                            {{ $data['hour'] }}
                                        </label>
                                    @endforeach
                                </div>
                                <x-ui.error type="form.start_time"/>
                            </div>
                        </div>
                    </div>
                    <x-website.reservation.footer
                        :stepBack="[AppointmentReservationLivewire::STEP_SERVICE_AND_EMPLOYEE,1]"
                        :nextStep="AppointmentReservationLivewire::STEP_DETAILS"
                    />
                @endif

                @if ($currentStep == AppointmentReservationLivewire::STEP_DETAILS)
                    <div class="col-span-2">
                        <div class="lg:hidden">
                            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                                <div class="px-4 py-5 sm:px-6">
                                    <h3 class="text-lg font-bold leading-6 text-gray-900">
                                        Este es el resumen de tu reservación
                                    </h3>
                                </div>
                                <div class="border-t border-gray-200">
                                    <dl>
                                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="font-medium text-gray-500">
                                                Servicio
                                            </dt>
                                            <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                                Margot Foster
                                            </dd>
                                        </div>
                                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="font-medium text-gray-500">
                                                Fecha
                                            </dt>
                                            <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                                Backend Developer
                                            </dd>
                                        </div>
                                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="font-medium text-gray-500">
                                                Hora
                                            </dt>
                                            <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                                margotfoster@example.com
                                            </dd>
                                        </div>
                                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="font-medium text-gray-500">
                                                Valor
                                            </dt>
                                            <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                                -
                                            </dd>
                                        </div>
                                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="font-medium text-gray-500">
                                                Profesional
                                            </dt>
                                            <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                                $120,000
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="hidden lg:block">
                            <p class="mb-4">Este es el resumen de tu reservación</p>

                            <div class="flex flex-col">
                                <div class="overflow-x-auto -my-2 sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead>
                                            <tr>
                                                <th scope="col"
                                                    class="pt-3 pr-6 pb-2 text-lg font-medium font-bold tracking-wider text-left text-mariajose_gray">
                                                    Servicio
                                                </th>
                                                <th scope="col"
                                                    class="px-6 pt-3 pb-2 text-lg font-medium font-bold tracking-wider text-left text-mariajose_gray">
                                                    Fecha
                                                </th>
                                                <th scope="col"
                                                    class="px-6 pt-3 pb-2 text-lg font-medium font-bold tracking-wider text-left text-mariajose_gray">
                                                    Hora
                                                </th>
                                                <th scope="col"
                                                    class="px-6 pt-3 pb-2 text-lg font-medium font-bold tracking-wider text-left text-mariajose_gray">
                                                    Valor
                                                </th>
                                                <th scope="col"
                                                    class="px-6 pt-3 pb-2 text-lg font-medium font-bold tracking-wider text-left text-mariajose_gray">
                                                    Profesional
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="py-4 pr-6 font-medium text-gray-900 whitespace-nowrap">
                                                    {{ $this->service->present()->name() }}
                                                </td>
                                                <td class="px-6 py-4 font-medium text-gray-500 whitespace-nowrap">
                                                    {{ $this->appointmentDate }}
                                                </td>
                                                <td class="px-6 py-4 font-medium text-gray-500 whitespace-nowrap">

                                                    {{ $this->appointmentHour }}
                                                </td>
                                                <td class="px-6 py-4 font-medium text-gray-500 whitespace-nowrap">
                                                    {{ $this->appointmentValue }}
                                                </td>
                                                <td class="px-6 py-4 font-medium text-gray-500 whitespace-nowrap">
                                                    {{ $this->employee->present()->name() }}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <x-website.reservation.footer
                        :stepBack="[AppointmentReservationLivewire::STEP_DATE_AND_HOUR, 2]"
                        :nextStep="AppointmentReservationLivewire::STEP_FORM_CUSTOMER"
                    />
                @endif

                @if ($currentStep == AppointmentReservationLivewire::STEP_FORM_CUSTOMER)
                    <div class="sm:col-span-2">
                        <div class="grid gap-4 sm:grid-cols-3">
                            <x-input.text
                                :labelBold="true"
                                wire:model.lazy="form.name"
                                label="Nombres"
                                name="form.name"
                            />
                            <x-input.text
                                :labelBold="true"
                                wire:model.lazy="form.phone"
                                label="Teléfono"
                                name="form.phone"
                            />
                            <x-input.text
                                :labelBold="true"
                                wire:model.lazy="form.email"
                                label="Email"
                                type="email"
                                name="form.email"
                            />
                            <div class="sm:col-span-3">
                                <x-input.textarea
                                    :labelBold="true"
                                    wire:model.lazy="form.note"
                                    label="Nota"
                                    name="form.note"
                                />
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="flex items-center">
                                <input
                                    wire:model="form.terms_and_conditions"
                                    id="termsAndConditions"
                                    name="termsAndConditions"
                                    type="checkbox"
                                    class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                                <label class="ml-2 text-gray-600" for="termsAndConditions">Para continuar, debes aceptar
                                    nuestro <a class="font-bold underline" href="">Terminos y Condiciones</a> y nuestra
                                    <a class="font-bold underline" href="">Política de Devolución.</a></label>
                            </div>
                            <x-ui.error type="form.terms_and_conditions"/>
                        </div>
                    </div>

                    <x-website.reservation.footer
                        :stepBack="[AppointmentReservationLivewire::STEP_DETAILS, 3]"
                        :nextStep="AppointmentReservationLivewire::STEP_FAREWELL"
                    />
                @endif

                @if ($currentStep == AppointmentReservationLivewire::STEP_FAREWELL)
                    <div class="sm:col-span-2">
                        <p class="py-16 mx-auto max-w-2xl text-3xl text-center text-gray-700">
                            Gracias por su reserva en linea, se le ha enviado un correo con los detalles de su
                            reservación
                        </p>
                        <div class="flex justify-center">
                            <x-input.button>
                                <span class="font-bold text-lg">
                                    Ir a la página de inicio
                                </span>
                            </x-input.button>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
