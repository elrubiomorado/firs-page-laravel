<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chirps') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{route("chirps.store")}}"">
                        @csrf

                        <textarea class=" block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{__('What\'s on your mind?')}}" name="message">{{old("message")}}</textarea>

                        <x-input-error :messages="$errors->get('message')" />

                        <x-primary-button class="mt-4">
                            {{__("Chirp")}}
                        </x-primary-button>

                    </form>
                </div>

                <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm rounded-lg divide-y dark:divide-gray-900">
                    @foreach($chirps as $chirp)
                    <div class="p-6 flex space-x-2 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600 dark:text-gray-400 -scale-x-100">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-gray-800 dark:text-gray-200">{{$chirp -> user->name}}</span>
                                    <small class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{$chirp -> created_at->format("j M Y, g:i a")}}</small>
                                    @if($chirp -> created_at != $chirp->updated_at)
                                        <small class="ml-2 text-sm text-gray-600 dark:text-gray-200">&middot; {{__("Edited")}}</small>
                                    @endif
                                </div>

                            </div>
                            <p class="mt-4 text-lg text-gray-900 dark:text-gray-100">{{$chirp->message}}</p>
                        </div>
                        @can("update", $chirp)
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 dark:text-gray-200">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>

                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                        {{__("Edit Chirp")}}
                                    </x-dropdown-link>
                                    <form  method="post" action="{{route("chirps.destroy", $chirp)}}">
                                        @csrf @method("delete")
                                        <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit()">
                                            {{__("Delete chirp")}}
                                        </x-dropdown-link>
                                    </form>
                                    
                                </x-slot>
                            </x-dropdown>
                        @endcan
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>