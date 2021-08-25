<x-app-layout header-title="Localidades">
    <x-ui.flash/>
    <div class="flex justify-end space-x-2">
        <button
            type="button"
            class="inline-flex justify-center py-2 px-4 text-sm font-medium text-white bg-gray-900 leading-4 rounded-md border border-transparent shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
            onclick="Livewire.emit('openModal', 'create-location-livewire')">
            Crear localidad
        </button>
    </div>
    <div class="h-4"></div>
    <div class="flex flex-col">
        <div class="-my-2 sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sm:rounded-t-lg">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Nombre
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($locations as $location)
                            <tr>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    {{ $location->present()->name() }}
                                </td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <a onclick="Livewire.emit('openModal', 'update-location-livewire', {{ json_encode(['locationId' => $location->id]) }})" class="cursor-pointer text-indigo-600 hover:text-indigo-900">Editar</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <x-ui.empty-list :count="$locations->count()">
                        No se encuentra ninguna localidad registrada.
                    </x-ui.empty-list>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
