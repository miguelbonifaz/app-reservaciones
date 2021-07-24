<x-app-layout header-title="Clientes">
    <x-ui.flash />
    <div class="flex justify-end space-x-2">
        <x-input.link href="{{ route('customers.create') }}">
            Crear Cliente
        </x-input.link>
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
                                Email
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Teléfono
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Cédula
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">

                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($customers as $customer)
                            <tr>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    {{ $customer->present()->name() }}
                                </td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    {{ $customer->present()->email() }}
                                </td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    {{ $customer->present()->phone() }}
                                </td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    {{ $customer->present()->identificationNumber() }}
                                </td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <div class="flex items-center justify-end space-x-8">
                                        <a href="{{ route('customers.edit',$customer) }}">
                                            Editar
                                        </a>
                                        <form
                                            action="{{ route('customers.destroy', $customer) }}"
                                            method="POST"
                                            onclick="return confirm('¿Seguro desea eliminar este cliente?');">
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
                    <x-ui.empty-list :count="$customers->count()">
                        No se encuentra ningún cliente registrado.
                    </x-ui.empty-list>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
