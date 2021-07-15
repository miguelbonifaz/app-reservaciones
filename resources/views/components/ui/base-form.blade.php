<form action="{{ $route }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid sm:grid-cols-2 gap-6">
                {{ $slot }}
            </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            {{ $footer }}
        </div>
    </div>
</form>
