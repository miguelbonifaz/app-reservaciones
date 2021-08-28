<x-base-form route="{{ $route }}">
    <div class="sm:col-span-2">
        <p class="mb-2 text-lg font-bold text-gray-800">Información Empleado</p>
        <hr class="border-t border-gray-200 sm:col-span-2">
    </div>

    <x-input.text
        name="name"
        value="{{old('name', $employee->name)}}"
        label="Nombre"
    />

    <x-input.text
        name="email"
        value="{{old('email', $employee->email)}}"
        label="email"
    />

    <x-input.text
        name="phone"
        value="{{old('phone', $employee->phone)}}"
        label="Teléfono"
    />
    <div class="sm:col-span-2">
        <p class="mb-2 text-lg font-bold text-gray-800">Asignación de servicios</p>
        @foreach ($services as $service)
            <div class="inline-flex items-center py-2 px-4 mt-1 mr-2 mb-2 space-x-1 bg-gray-50 rounded-full shadow-sm">
                <input
                    {{ collect(old('servicesId', $employee->services->pluck('id')))->contains($service->id) ? 'checked' : '' }}
                    id="service_{{ $service->id }}"
                    name="servicesId[]"
                    value="{{ $service->id }}"
                    type="checkbox"
                    class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                <label
                    for="service_{{ $service->id }}"
                    class="block ml-2 text-sm text-gray-900">
                    {{ $service->present()->name() }}
                </label>
            </div>
        @endforeach
        <x-input.error type="servicesId"/>
    </div>

    @if ($isEditView)
        <hr class="sm:col-span-2">
        <div class="sm:col-span-2">
            <p class="mb-2 text-lg font-bold text-gray-800">Escoje una localidad para actualizar un horario de
                trabajo
            </p>
            <div class="flex justify-end">
                <button
                    type="button"
                    onclick="Livewire.emit('openModal', 'assign-new-location-to-an-employee-livewire', {{ json_encode(["employeeId" => $employee->id]) }})"
                    class="inline-flex mb-4 items-center py-2 px-4 border font-bold border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Asignar nueva localidad
                </button>
            </div>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($employee->locations as $location)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $location->present()->name() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end">
                                                <a
                                                    href="{{ route('employees.locations.index', [$employee, $location]) }}"
                                                    class="mr-4 text-indigo-600 hover:text-indigo-900">Editar</a>
                                                <a
                                                    href="{{ route('employees.locations.destroy', [$employee, $location]) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">Eliminar</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <x-ui.empty-list :count="$employee->locations->count()">
                                No se encuentra asignado ninguna localidad
                            </x-ui.empty-list>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <x-slot name="footer">
        <x-input.link theme="white" href="{{ route('employees.index') }}">
            Cancelar
        </x-input.link>
        <x-input.button>
            Guardar
        </x-input.button>
    </x-slot>
</x-base-form>
