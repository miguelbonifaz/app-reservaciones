<x-app-layout header-title="Usuarios">
    <div class="flex justify-end space-x-2">
        <x-input.link href="{{ route('users.create') }}">
            Crear Usuario
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
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        {{ $user->present()->name() }}
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        {{ $user->present()->email() }}
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        <div class="flex items-center justify-end space-x-8">
                                            <x-input.link href="{{ route('users.edit', $user) }}">
                                                Editar
                                            </x-input.link>                                    
                                            <form
                                                action="{{ route('users.destroy', $user) }}"
                                                method="POST"
                                                onclick="return confirm('¿Seguro desea eliminar este usuario?');">
                                                @csrf
                                                @method('DELETE')
                                                <x-input.button>
                                                    Eliminar
                                                </x-input.button>                                                
                                            </form>
                                        </div>
                                    </td>                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>                
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
