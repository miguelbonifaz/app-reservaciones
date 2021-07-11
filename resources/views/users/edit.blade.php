<x-app-layout header-title="{{ $user->present()->name() }}">
    <div class="px-4">
        <div class="mx-auto max-w-7xl">
            <div class="py-4">                
                <x-base-form :route="route('users.update',$user)">
                    <x-input.text
                        name="name"
                        label="Nombre"
                        value="{{old('name', $user->name)}}"
                    />
                    <x-input.text
                        name="email"
                        label="email"
                        value="{{old('email', $user->email)}}"
                    />                
                    <x-input.text
                        name="password"
                        label="Password"
                        type="password"
                    />
                    <div>
                        <x-input.text
                        label="Foto"
                        name="avatar"                        
                        type="file" />                        
                    </div>                                                                                               
                    <x-slot name="footer">
                        <x-input.link theme="white" href="{{ route('users.index') }}">
                            Cancelar
                        </x-input.link>
                        <x-input.button>
                            Guardar
                        </x-input.button>
                    </x-slot>
                </x-base-form>
                @if ($user->getFirstMedia('avatar') != null)
                    <form action="{{ route('users.remove',$user) }}" method="post">                            
                        @csrf                            
                            <button
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800"
                                type="submit">
                                Eliminar foto
                            </button>
                    </form>   
                @endif                               
            </div>
        </div>
    </div>
</x-app-layout>