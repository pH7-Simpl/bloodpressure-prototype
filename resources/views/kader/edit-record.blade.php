@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Edit Blood Pressure Record for {{ $pasien->nama }}</h1>

    <form action="{{ route('kader.updateRecord', $reading->id) }}" method="POST">
        @csrf
        @method('POST')

        <div class="mb-4">
            <label for="morning_value" class="block text-sm font-medium text-gray-700">Morning Blood Pressure</label>
            <input type="number" name="morning_value" id="morning_value" value="{{ old('morning_value', $reading->morning_value) }}" class="mt-1 block w-full px-4 py-2 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            @error('morning_value')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label for="afternoon_value" class="block text-sm font-medium text-gray-700">Afternoon Blood Pressure</label>
            <input type="number" name="afternoon_value" id="afternoon_value" value="{{ old('afternoon_value', $reading->afternoon_value) }}" class="mt-1 block w-full px-4 py-2 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            @error('afternoon_value')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label for="night_value" class="block text-sm font-medium text-gray-700">Night Blood Pressure</label>
            <input type="number" name="night_value" id="night_value" value="{{ old('night_value', $reading->night_value) }}" class="mt-1 block w-full px-4 py-2 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            @error('night_value')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">Update Record</button>
        </div>
    </form>
</div>
@endsection
