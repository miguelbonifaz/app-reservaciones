<form wire:submit.prevent="onSubmit">
    <div>
        <x-ui.flash/>
    </div>
    @csrf
    <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label for="customer_id" class="block text-sm font-medium leading-5 text-gray-700">
                        Cliente
                    </label>
                    <livewire:customer-select
                        name="customer_id"
                        wire:model="customer_id"
                        :searchable="true"
                        :value="request('customer_id')"
                        placeholder="Seleccione un cliente"
                    />
                </div>
                <div>
                    <label for="service_id" class="block text-sm font-medium leading-5 text-gray-700">
                        Servicios
                    </label>
                    <livewire:service-select
                        name="service_id"
                        wire:model="service_id"
                        placeholder="Seleccione un servicio"
                        :value="request('service_id')"
                    />
                </div>
                <div>
                    <label for="employee_id" class="block text-sm font-medium leading-5 text-gray-700">
                        Profesionales
                    </label>
                    <livewire:employee-select
                        name="employee_id"
                        wire:model="employee_id"
                        placeholder="Seleccione un profesional"
                        :value="request('employee_id')"
                        :depends-on="['service_id']"
                    />
                </div>
                <div>
                    <x-input.text
                        name="date"
                        wire:model="date"
                        label="Fecha"
                        type="date"
                    />
                </div>
                <div>
                    <x-input.text
                        name="start_time"
                        wire:model="start_time"
                        label="Hora inicio"
                        type="time"
                    />
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

