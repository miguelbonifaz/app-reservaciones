<x-app-layout header-title="Nuevo Usuario">
    <div class="px-4">
        <div class="mx-auto max-w-7xl">
            <div class="py-4">
                <x-forms.user
                    :route="route('users.store')"
                    :user="$user"
                    :redirectUrl="request('redirectUrl')"
                />
            </div>
        </div>
    </div>
</x-app-layout>
