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
            <div class="grid gap-4 gap-6 sm:grid-cols-2">
                @if ($currentStep == AppointmentReservationLivewire::STEP_SERVICE_AND_EMPLOYEE)
                    <div class="sm:col-span-2 md:flex md:flex-col lg:flex-row">
                        <div wire:key="{{ \Illuminate\Support\Str::uuid() }}" class="mb-3 lg:flex-grow w-full pr-4">
                            <x-input.select
                                label="Escoje un servicio"
                                name="form.service_id"
                                wire:model.lazy="form.service_id"
                                placeholder="Servicio">
                                @foreach ($this->services as $service)
                                    <option value="{{ $service->id }}">{{ $service->present()->name() }}</option>
                                @endforeach
                            </x-input.select>
                        </div>
                        @if (count($this->locations))
                            <div wire:key="{{ \Illuminate\Support\Str::uuid() }}" class="mb-3 lg:flex-grow w-full pr-4">
                                <x-input.select
                                    label="Escoje un lugar"
                                    name="form.location_id"
                                    wire:model.lazy="form.location_id"
                                    placeholder="Lugar">
                                    @foreach ($this->locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->present()->name() }}</option>
                                    @endforeach
                                </x-input.select>
                            </div>
                        @endif
                        <div wire:key="{{ \Illuminate\Support\Str::uuid() }}" class="lg:flex-grow w-full">
                            <x-input.select
                                label="Escoje un profesional"
                                name="form.employee_id"
                                wire:model.lazy="form.employee_id"
                                placeholder="Profesional">
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->present()->name() }}</option>
                                @endforeach
                            </x-input.select>
                        </div>
                    </div>
                    @if ($this->service)
                        <div class="p-4 bg-blue-50 rounded-md sm:col-span-2">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: solid/information-circle -->
                                    <svg class="w-5 h-5 text-blue-400" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="flex-1 ml-3 md:flex">
                                    <p class="text-sm text-blue-700">
                                        {{ $this->service->present()->description() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
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
                            <div class="lg:flex-grow">
                                <div
                                    class="px-3 py-2 mb-1 w-32 text-center text-white rounded-lg border border-gray-200 bg-mariajose_gray">
                                    {{ $this->selectedDay ?? 'Cargando...' }}
                                </div>
                                <div
                                    class="grid grid-cols-2 gap-1 lg:flex lg:flex-col lg:h-72 lg:flex-wrap lg:gap-0 lg:content-start">
                                    @foreach ($this->availableHours as $data)
                                        <label
                                            dusk="hour-{{ $data['hour'] }}"
                                            class="mr-2 w-full lg:w-32 text-center border border-gray-200 text-center py-2 rounded-lg mb-1 flex items-center justify-center {{ $this->hourNotAvailableClasses($data['isAvailable']) }}">
                                            <input
                                                @if (!$data['isAvailable'])
                                                disabled
                                                @else
                                                wire:model="form.start_time"
                                                @endif
                                                class="mr-1 w-4 h-4 border-gray-300 focus:ring-mariajose_gray text-mariajose_gray"
                                                name="form.start_time"
                                                value="{{ $data['hour'] }}"
                                                type="radio">
                                            {{ $data['hour'] }}
                                        </label>
                                    @endforeach
                                </div>
                                @if (count($this->availableHours) == 0)
                                    <p>No existe horario disponible el día de hoy.</p>
                                @endif
                                <x-ui.error type="form.start_time_and_location"/>
                            </div>
                        </div>
                    </div>
                    <x-website.reservation.footer
                        :stepBack="[AppointmentReservationLivewire::STEP_SERVICE_AND_EMPLOYEE,1]"
                        :nextStep="AppointmentReservationLivewire::STEP_DETAILS"
                    />
                @endif

                @if ($currentStep == AppointmentReservationLivewire::STEP_DETAILS)
                    <div class="sm:col-span-2">
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
                                                {{ $this->service->present()->name() }}
                                            </dd>
                                        </div>
                                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="font-medium text-gray-500">
                                                Fecha
                                            </dt>
                                            <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ $this->appointmentDate }}
                                            </dd>
                                        </div>
                                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="font-medium text-gray-500">
                                                Lugar
                                            </dt>
                                            <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ $this->appointmentLocation }}
                                            </dd>
                                        </div>
                                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="font-medium text-gray-500">
                                                Hora
                                            </dt>
                                            <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ $this->appointmentHour }}
                                            </dd>
                                        </div>
                                        <div class="px-4 py-5 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="font-medium text-gray-500">
                                                Valor
                                            </dt>
                                            <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ $this->appointmentValue }}
                                            </dd>
                                        </div>
                                        <div class="px-4 py-5 bg-white sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="font-medium text-gray-500">
                                                Profesional
                                            </dt>
                                            <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ $this->employee->present()->name() }}
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
                                                    Lugar
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
                                                <td class="py-4 pr-6 font-medium text-gray-900">
                                                    <div class="flex items-center">
                                                        {{ $this->service->present()->name() }}
                                                        <div style="flex-basis: 10px">
                                                            <svg
                                                                wire:click="$emit('openModal', 'show-service-detail-livewire', {{ json_encode(['serviceId' => $this->service->id]) }})"
                                                                class="ml-2 text-gray-600 cursor-pointer" width="24"
                                                                height="24" fill="none" viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                      stroke-linejoin="round" stroke-width="2"
                                                                      d="M12 13V15"></path>
                                                                <circle cx="12" cy="9" r="1"
                                                                        fill="currentColor"></circle>
                                                                <circle cx="12" cy="12" r="7.25" stroke="currentColor"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="1.5"></circle>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 font-medium text-gray-500 whitespace-nowrap">
                                                    {{ $this->appointmentDate }}
                                                </td>
                                                <td class="px-6 py-4 font-medium text-gray-500 whitespace-nowrap">

                                                    {{ $this->appointmentLocation }}
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
                        <p class="mb-6 text-lg font-medium font-bold text-gray-600 border-b border-gray-200">Información
                            del representante</p>
                        <div class="grid gap-4 sm:grid-cols-3">
                            <x-input.text
                                :labelBold="true"
                                wire:model.lazy="form.email"
                                label="Email"
                                type="email"
                                name="form.email"
                            />
                            <x-input.text
                                :labelBold="true"
                                wire:model.lazy="form.full_name"
                                label="Nombres completos"
                                name="form.full_name"
                            />
                            <x-input.text
                                :labelBold="true"
                                wire:model.lazy="form.first_name"
                                label="Primer apellido"
                                name="form.first_name"
                            />
                            <x-input.text
                                :labelBold="true"
                                wire:model.lazy="form.last_name"
                                label="Segundo Apellido"
                                name="form.last_name"
                            />
                            <x-input.text
                                :labelBold="true"
                                wire:model.lazy="form.phone"
                                label="Teléfono"
                                name="form.phone"
                            />
                            <x-input.text
                                :labelBold="true"
                                wire:model.lazy="form.name_of_child"
                                label="Nombre del niño"
                                name="form.name_of_child"
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
                        <p class="py-16 mx-auto max-w-2xl text-3xl text-center text-gray-700">Gracias por su reserva en linea, se le ha enviado un correo con los detalles de su reservación
                        </p>
                        <div class="flex justify-center">
                            <x-input.link href="{{ route('website.home') }}">
                                <span class="text-lg font-bold">
                                    Ir a la página de inicio
                                </span>
                            </x-input.link>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
