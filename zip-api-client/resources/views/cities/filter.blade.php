<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Search Cities by Letter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mb-6">
                        <label for="county" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                            Select County
                        </label>
                        <select id="county" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-700 rounded-md">
                            <option value="">-- Choose a County --</option>
                            @foreach($counties as $county)
                            <option value="{{ $county['id'] }}">{{ $county['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="letters-container" class="mb-6" style="display: none;">
                        <p class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                            Select First Letter
                        </p>
                        <div id="letters" class="flex flex-wrap gap-2">
                            <!-- Letters will be loaded here via AJAX -->
                        </div>
                    </div>

                    <div id="loading" style="display: none;" class="text-center py-4">
                        <p class="text-gray-600 dark:text-gray-400">Loading...</p>
                    </div>

                    <div id="results-container" style="display: none;">
                        <!-- Results will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('county').addEventListener('change', function() {
            const countyId = this.value;
            const lettersContainer = document.getElementById('letters-container');
            const lettersDiv = document.getElementById('letters');
            const loading = document.getElementById('loading');
            const resultsContainer = document.getElementById('results-container');

            if (!countyId) {
                lettersContainer.style.display = 'none';
                resultsContainer.style.display = 'none';
                return;
            }

            loading.style.display = 'block';

            fetch(`/cities/filter/letters/${countyId}`)
                .then(response => response.json())
                .then(data => {
                    loading.style.display = 'none';
                    lettersDiv.innerHTML = '';

                    data.letters.forEach(letter => {
                        const btn = document.createElement('a');
                        btn.href = `/cities/filter/${countyId}/${letter}`;
                        btn.className = 'px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded cursor-pointer';
                        btn.textContent = letter;
                        lettersDiv.appendChild(btn);
                    });

                    lettersContainer.style.display = 'block';
                    resultsContainer.style.display = 'none';
                })
                .catch(error => {
                    loading.style.display = 'none';
                    alert('Error loading letters: ' + error);
                });
        });
    </script>
</x-app-layout>