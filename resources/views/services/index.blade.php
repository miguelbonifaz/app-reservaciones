<x-app-layout header-title="Servicios">
    <x-ui.flash/>
    <div class="flex justify-end space-x-2">
        <x-input.link href="{{ route('services.create') }}">
            Crear Servicio
        </x-input.link>
    </div>
    <div class="h-4"></div>
    <div class="flex flex-col">
        <div class="-my-2 sm:-mx-6 lg:-mx-8">
            <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8">
                <div class="border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sm:rounded-t-lg">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Nombre
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Descripción
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Valor
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($services as $service)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                    {{ $service->present()->name() }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <p>
                                        {{ $service->present()->description() }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        Duración: {{ $service->present()->duration() }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $service->present()->value() }}
                                </td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <div class="flex justify-end items-center space-x-8">
                                        <a href="{{ route('services.edit',$service) }}">
                                            Editar
                                        </a>
                                        <form
                                            action="{{ route('services.destroy', $service) }}"
                                            method="POST"
                                            onclick="return confirm('¿Seguro desea eliminar este servicio?');">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="font-medium text-teal-600 hover:text-teal-900 focus:outline-none focus:underline">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <x-ui.empty-list :count="$services->count()">
                        No se encuentra ningún servicio registrado.
                    </x-ui.empty-list>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
