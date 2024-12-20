<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" x-init="{{-- Echo.channel('messages') --}}
                console.log('Event received ***********************')

                 {{-- Echo.private('users.{{ auth()->id() }}')
                    .listen('OrderEvent', (event) => {
                        console.log(event)
                    }) --}}

                Echo.private(`chat.{{ auth()->id() }}`)
                    .listen('MessageSent', (response) => {
                        console.log('Event received:', response)
                    })

                    ">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
