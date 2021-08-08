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
                        <div class="flex flex-col space-x-2 lg:flex-row">
                            <div class="mb-6 lg:w-96">
                                <livewire:date-picker-livewire
                                    :employeeId="$this->form['employee_id']"
                                />
                                <x-ui.error :type="$this->form['date']"/>
                            </div>
                            <div>
                                <div
                                    class="mb-1 border px-3 py-2 border-gray-200 rounded-lg bg-mariajose_gray text-white w-32 text-center">
                                    {{ $this->selectedDay }}
                                </div>
                                <div class="grid grid-cols-2 gap-2 lg:flex lg:flex-col lg:h-72 lg:flex-wrap lg:gap-0">
                                    @forelse ($this->availableHours as $data)
                                        <label
                                            class="mr-2 w-full lg:w-32 text-center border border-gray-200 text-center py-2 rounded-lg mb-1 flex items-center justify-center {{ $this->hourNotAvailableClasses($data['isAvailable']) }}">
                                            <input
                                                @if (!$data['isAvailable'])
                                                disabled
                                                @else
                                                wire:model="form.start_time"
                                                @endif
                                                class="focus:ring-mariajose_gray mr-1 h-4 w-4 text-mariajose_gray border-gray-300"
                                                name="start_time"
                                                type="radio"
                                                value="{{ $data['hour'] }}">
                                            {{ $data['hour'] }}
                                        </label>
                                    @empty
                                        <p>Lo sentimos, no existen horarios disponibles para el día de hoy.</p>
                                    @endforelse
                                    <x-ui.error :type="$this->form['start_time']"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <x-website.reservation.footer
                        :stepBack="AppointmentReservationLivewire::STEP_SERVICE_AND_EMPLOYEE"
                        :nextStep="AppointmentReservationLivewire::STEP_DETAILS"
                    />
                @endif

                @if ($currentStep == AppointmentReservationLivewire::STEP_DETAILS)
                    <div class="col-span-2">
                        <div class="lg:hidden">
                            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                                <div class="px-4 py-5 sm:px-6">
                                    <h3 class="text-lg leading-6 font-bold text-gray-900">
                                        Este es el resumen de tu reservación
                                    </h3>
                                </div>
                                <div class="border-t border-gray-200">
                                    <dl>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="font-medium text-gray-500">
                                                Servicio
                                            </dt>
                                            <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                                Margot Foster
                                            </dd>
                                        </div>
                                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="font-medium text-gray-500">
                                                Fecha
                                            </dt>
                                            <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                                Backend Developer
                                            </dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="font-medium text-gray-500">
                                                Hora
                                            </dt>
                                            <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                                margotfoster@example.com
                                            </dd>
                                        </div>
                                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="font-medium text-gray-500">
                                                Valor
                                            </dt>
                                            <dd class="mt-1 text-gray-900 sm:mt-0 sm:col-span-2">
                                                -
                                            </dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
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
                                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead>
                                            <tr>
                                                <th scope="col"
                                                    class="pr-6 pb-2 pt-3 text-left text-lg font-medium font-bold text-mariajose_gray tracking-wider">
                                                    Servicio
                                                </th>
                                                <th scope="col"
                                                    class="px-6 pb-2 pt-3 text-left text-lg font-medium font-bold text-mariajose_gray tracking-wider">
                                                    Fecha
                                                </th>
                                                <th scope="col"
                                                    class="px-6 pb-2 pt-3 text-left text-lg font-medium font-bold text-mariajose_gray tracking-wider">
                                                    Hora
                                                </th>
                                                <th scope="col"
                                                    class="px-6 pb-2 pt-3 text-left text-lg font-medium font-bold text-mariajose_gray tracking-wider">
                                                    Valor
                                                </th>
                                                <th scope="col"
                                                    class="px-6 pb-2 pt-3 text-left text-lg font-medium font-bold text-mariajose_gray tracking-wider">
                                                    Profesional
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="pr-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                                    {{ $this->service->present()->name() }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-500">
                                                    {{ $this->appointmentDate }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-500">

                                                    {{ $this->appointmentHour }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-500">
                                                    {{ $this->appointmentValue }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-500">
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
                        :stepBack="AppointmentReservationLivewire::STEP_DATE_AND_HOUR"
                        :nextStep="AppointmentReservationLivewire::STEP_FORM_CUSTOMER"
                    />
                @endif

                @if ($currentStep == AppointmentReservationLivewire::STEP_FORM_CUSTOMER)
                    <div class="sm:col-span-2">
                        <div class="grid gap-4">
                            <x-input.text
                                label="Nombres"
                                :name="$this->form['name']"
                            />
                            <x-input.text
                                label="Teléfono"
                                :name="$this->form['phone']"
                            />
                            <x-input.text
                                label="Email"
                                type="email"
                                :name="$this->form['email']"
                            />
                            <x-input.textarea
                                label="Nota"
                                :name="$this->form['note']"
                            />
                        </div>
                    </div>

                    <x-website.reservation.footer
                        :stepBack="AppointmentReservationLivewire::STEP_DETAILS"
                        :nextStep="AppointmentReservationLivewire::STEP_FAREWELL"
                    />
                @endif

                @if ($currentStep == AppointmentReservationLivewire::STEP_FAREWELL)
                    Farewell
                @endif

            </div>
        </div>
    </div>
</div>
