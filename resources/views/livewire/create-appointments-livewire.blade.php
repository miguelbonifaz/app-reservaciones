<form wire:submit.prevent="onSubmit">
    <div>
        <x-ui.flash/>
    </div>
    @csrf
    <div class="overflow-hidden shadow sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="customer_id" class="block mb-1 text-sm font-medium leading-5 text-gray-700">
                        Cliente
                    </label>
                    <livewire:customer-select
                        name="form.customer_id"
                        wire:model="form.customer_id"
                        :value="request('form.customer_id')"
                        placeholder="Seleccione un cliente"
                        :searchable="true"
                    />
                    <x-ui.error type="form.customer_id" />
                </div>
                <div class="grid gap-6 sm:col-span-2 lg:grid-cols-3">
                    <div>
                        <x-input.select
                            label="Escoje un servicio"
                            name="form.service_id"
                            wire:model.lazy="form.service_id"
                            placeholder="Escoja un servicio">
                            @foreach ($this->services as $service)
                                <option value="{{ $service->id }}">{{ $service->present()->name() }}</option>
                            @endforeach
                        </x-input.select>
                    </div>
                    <div>
                        <x-input.select
                            label="Escoje un profesional"
                            name="form.employee_id"
                            wire:model.lazy="form.employee_id"
                            placeholder="Escoja un profesional">
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->present()->name() }}</option>
                            @endforeach
                        </x-input.select>
                    </div>
                    <div>
                        <x-input.select
                            label="Localidad"
                            name="form.location_id"
                            wire:model.lazy="form.location_id"
                            placeholder="Escoja una localidad">
                            @foreach ($this->locations as $location)
                                <option value="{{ $location->id }}">{{ $location->present()->name() }}</option>
                            @endforeach
                        </x-input.select>
                    </div>
                </div>
                <div>
                    @if ($this->form['location_id'])
                        <livewire:date-picker-livewire
                            wire:key="date-picker-{{ $this->form['location_id'] }}"
                            :locationId="$this->form['location_id']"
                            :employeeId="$this->form['employee_id']"
                            :dateSelected="null"
                            :index="null"
                        />
                        <x-ui.error type="form.date"/>
                    @else
                        Escoje un profesional
                        <x-ui.error type="form.date"/>
                    @endif
                </div>
                <div>
                    <x-input.select
                        label="Hora"
                        wire:model="form.start_time"
                        name="form.start_time">
                        @foreach ($this->availableHours as $hour)
                            <option value="{{ $hour }}">{{ $hour }}</option>
                        @endforeach
                    </x-input.select>
                </div>
                <div class="sm:col-span-2">
                    <x-input.textarea
                        name="note"
                        wire:model="form.note"
                        label="Nota"
                    />
                </div>
            </div>
        </div>
        <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
            <x-input.link theme="white" href="{{ $cancelUrl ?? '#' }}">
                Cancelar
            </x-input.link>
            <x-input.button>
                Guardar
            </x-input.button>
        </div>
    </div>
</form>

