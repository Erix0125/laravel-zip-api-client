<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Counties') }}
            </h2>
            <div class="flex gap-2">
                @auth
                <a href="{{ route('counties.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add County
                </a>
                @endauth
                <a href="{{ route('export.counties.csv') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Export CSV
                </a>
                <a href="{{ route('export.counties.pdf') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Export PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(count($counties) > 0)
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="border px-4 py-2 text-left">ID</th>
                                <th class="border px-4 py-2 text-left">Name</th>
                                <th class="border px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($counties as $county)
                            <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="border px-4 py-2">{{ $county['id'] }}</td>
                                <td class="border px-4 py-2">{{ $county['name'] }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('counties.show', $county['id']) }}" class="text-blue-500 hover:underline">View</a>
                                    | <a href="{{ route('cities.index', ['countyId' => $county['id']]) }}" class="text-green-500 hover:underline">Cities</a>
                                    @auth
                                    | <a href="{{ route('counties.edit', $county['id']) }}" class="text-yellow-500 hover:underline">Edit</a>
                                    |
                                    <form method="POST" action="{{ route('counties.destroy', $county['id']) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                    @endauth
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-center py-4">No counties found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>