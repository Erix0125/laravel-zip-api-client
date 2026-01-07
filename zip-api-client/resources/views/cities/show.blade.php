<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View City') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                            ID
                        </label>
                        <p class="text-gray-600 dark:text-gray-400">{{ $city['id'] }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                            Name
                        </label>
                        <p class="text-gray-600 dark:text-gray-400">{{ $city['name'] }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                            Zip Code
                        </label>
                        <p class="text-gray-600 dark:text-gray-400">{{ $city['zip'] }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                            County
                        </label>
                        <p class="text-gray-600 dark:text-gray-400">{{ $county['name'] }}</p>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('cities.index', ['countyId' => $countyId]) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </a>
                        @if($auth->check)
                        <a href="{{ route('cities.edit', ['countyId' => $countyId, 'cityId' => $city['id']]) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <form action="{{ route('cities.destroy', ['countyId' => $countyId, 'cityId' => $city['id']]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this city?');">
                                Delete
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>