<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Columns for: <span class="font-bold">{{ $table->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Form to add new column -->
            <div class="md:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Column</h3>
                        <form action="{{ route('dashboard.columns.store', $table) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="column_name" :value="__('Column Name')" />
                                    <x-text-input id="column_name" class="block mt-1 w-full" type="text" name="column_name" required />
                                </div>
                                <div>
                                    <x-input-label for="column_type" :value="__('Column Type')" />
                                    <select name="column_type" id="column_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="text">Text</option>
                                        <option value="textarea">Textarea</option>
                                        <option value="number">Number</option>
                                        <option value="date">Date</option>
                                        <option value="datetime-local">DateTime</option>
                                        <option value="email">Email</option>
                                        <option value="password">Password</option>
                                        <option value="file">File</option>
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="validation_rules" :value="__('Validation Rules (pipe-separated)')" />
                                    <x-text-input id="validation_rules" placeholder="e.g. required|max:255" class="block mt-1 w-full" type="text" name="validation_rules" />
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-6">
                                <x-primary-button>
                                    {{ __('Add Column') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- List of existing columns -->
            <div class="md:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Existing Columns</h3>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validation</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($table->columns as $column)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $column->column_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $column->column_type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($column->validation_rules)
                                                <code>{{ implode('|', $column->validation_rules) }}</code>
                                            @else
                                                <span class="text-gray-400">None</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No columns defined yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
