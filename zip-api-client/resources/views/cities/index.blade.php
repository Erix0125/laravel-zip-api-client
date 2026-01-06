<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Cities in ' . $county['name']) }}
            </h2>
            <div class="flex gap-2">
                @if ($auth->check)
                <a href="{{ route('cities.create', ['countyId' => $countyId]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add City
                </a>
                @endif
                <a href="{{ route('export.cities.csv', ['countyId' => $countyId]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Export CSV
                </a>
                <a href="{{ route('export.cities.pdf', ['countyId' => $countyId]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Export PDF
                </a>
                <a href="{{ route('counties.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Counties
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-600 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-600 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(count($cities) > 0)
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="border px-4 py-2 text-left">ID</th>
                                <th class="border px-4 py-2 text-left">Name</th>
                                <th class="border px-4 py-2 text-left">Zip Code</th>
                                <th class="border px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cities as $city)
                            <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="border px-4 py-2">{{ $city['id'] }}</td>
                                <td class="border px-4 py-2">{{ $city['name'] }}</td>
                                <td class="border px-4 py-2">{{ $city['zip'] }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('cities.show', ['countyId' => $countyId, 'cityId' => $city['id']]) }}" class="text-blue-500 hover:underline">View</a>
                                    @if ($auth->check)
                                    | <a href="{{ route('cities.edit', ['countyId' => $countyId, 'cityId' => $city['id']]) }}" class="text-yellow-500 hover:underline">Edit</a>
                                    |
                                    <form method="POST" action="{{ route('cities.destroy', ['countyId' => $countyId, 'cityId' => $city['id']]) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-center py-4">No cities found in this county.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>