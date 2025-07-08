<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Logic to show Create or Edit --}}
            Create New {{ Str::singular($table->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- The form tag will point to store or update --}}
                    <form action="{{ route('dynamic.store', $table->slug) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            @foreach ($columns as $column)
                                <div>
                                    <x-input-label :for="$column->column_slug" :value="$column->column_name" />

                                    @switch($column->column_type)
                                        @case('textarea')
                                            <textarea id="{{ $column->column_slug }}" name="{{ $column->column_slug }}" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old($column->column_slug) }}</textarea>
                                        @break

                                        @case('file')
                                            <x-text-input id="{{ $column->column_slug }}" class="block mt-1 w-full" type="file" name="{{ $column->column_slug }}" />
                                        @break

                                        @default
                                            <x-text-input id="{{ $column->column_slug }}" class="block mt-1 w-full" type="{{ $column->column_type }}" name="{{ $column->column_slug }}" :value="old($column->column_slug)" />
                                    @endswitch

                                    <x-input-error :messages="$errors->get($column->column_slug)" class="mt-2" />
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Save Data') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
