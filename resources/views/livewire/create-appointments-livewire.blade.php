<form wire:submit.prevent="onSubmit">
    <div>
        <x-ui.flash/>
    </div>
    @csrf
    <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label for="customer_id" class="mb-1 block text-sm font-medium leading-5 text-gray-700">
                        Cliente
                    </label>
                    <livewire:customer-select
                        name="customer_id"
                        wire:model="customer_id"
                        :value="request('customer_id')"
                        placeholder="Seleccione un cliente"
                        :searchable="true"
                    />
                </div>
                <div>
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
                <div>
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
                <div>
                    @if ($this->form['employee_id'])
                        <livewire:date-picker-livewire
                            :employeeId="$this->form['employee_id']"
                        />
                        <x-ui.error :type="$this->form['date']"/>
                    @else
                        Escoje un profesional
                    @endif
                </div>
                <div>
                    <x-input.select
                        label="Hora"
                        wire:model="form.start_time"
                        name="form.start_time">
                        @foreach ($this->availableHours as $hour)
                            <option value="{{ $hour['hour'] }}">{{ $hour['hour'] }}</option>
                        @endforeach
                    </x-input.select>
                </div>
                <div class="sm:col-span-2">
                    <x-input.textarea
                        name="note"
                        wire:model="note"
                        label="Nota"
                    />
                </div>
            </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <x-input.link theme="white" href="{{ $cancelUrl ?? '#' }}">
                Cancelar
            </x-input.link>
            <x-input.button>
                Guardar
            </x-input.button>
        </div>
    </div>
</form>

