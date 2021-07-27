<div>
    <div class="overflow-hidden sm:rounded-md max-w-5xl mx-auto">
        <div class="bg-white">
            <div class="grid sm:grid-cols-2 gap-6">
                @if ($currentStep == \App\Http\Livewire\AppointmentReservationLivewire::STEP_SERVICE_AND_EMPLOYEE)
                    <div>
                        <label
                            for="form.service_id"
                            class="block mb-1 text-sm font-bold text-left text-gray-700">Servicio</label>
                        <livewire:service-select-livewire
                            name="form.service_id"
                            wire:model="form.service_id"
                            placeholder="Escoje un servicio"
                            :value="old('service_id', $this->form['service_id'])"
                        />
                        <x-ui.error type="form.service_id"/>
                    </div>
                    <div>
                        <label
                            for="form.employee_id"
                            class="block mb-1 text-sm font-bold text-left text-gray-700">Profesionales</label>
                        <livewire:employee-select-livewire
                            name="form.employee_id"
                            wire:model="form.employee_id"
                            placeholder="Escoje un servicio"
                            :value="old('employee_id', $this->form['employee_id'])"
                        />
                        <x-ui.error type="form.employee_id"/>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
