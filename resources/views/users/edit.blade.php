<x-app-layout header-title="{{ $user->present()->name() }}">    
    <div class="px-4">        
        <div class="mx-auto max-w-7xl">
            <x-ui.flash />
            <div class="py-4">                
                <x-forms.user
                    :route="route('users.update',$user)"
                    :user="$user"
                />                                          
            </div>
        </div>
    </div>
</x-app-layout>
