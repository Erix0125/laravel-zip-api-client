<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cities in ' . $county['name'] . ' starting with ' . $selectedLetter) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <a href="{{ route('cities.filter') }}" class="text-blue-500 hover:underline">← Back to Filter</a>
                    </div>

                    @if(count($cities) > 0)
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="border px-4 py-2 text-left">City Name</th>
                                <th class="border px-4 py-2 text-left">Zip Code</th>
                                <th class="border px-4 py-2 text-left">County</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cities as $city)
                            <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="border px-4 py-2">
                                    <a href="{{ route('cities.show', ['countyId' => $countyId, 'cityId' => $city['id']]) }}" class="text-blue-500 hover:underline">
                                        {{ $city['name'] }}
                                    </a>
                                </td>
                                <td class="border px-4 py-2">{{ $city['zip'] }}</td>
                                <td class="border px-4 py-2">{{ $city['county'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-center py-4 text-gray-600 dark:text-gray-400">
                        No cities found starting with "{{ $selectedLetter }}" in {{ $county['name'] }}.
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>