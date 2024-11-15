@extends('layouts.appkader')

@section('content')
<form method="POST" action="{{ route('kader.storeBloodPressure') }}" class="mt-4 bg-white p-6 rounded-lg shadow-lg max-w-lg mx-auto">
    @csrf

    <input type="hidden" name="pasien_id" value="{{ $patient->id }}">
    <h1 class="text-2xl font-bold">Add Blood Pressure Reading for {{ $patient->nama }}</h1>
    <div class="mb-4">
        <label for="date" class="block font-semibold text-gray-700">Date</label>
        <input type="date" name="date" id="date" required class="w-full border-gray-300 rounded-md px-4 py-2 mt-1 focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div class="mb-4">
        <label for="morning_value_systole" class="block font-semibold text-gray-700">Morning Systole</label>
        <input type="number" name="morning_value_systole" id="morning_value_systole" class="w-full border-gray-300 rounded-md px-4 py-2 mt-1 focus:ring-blue-500 focus:border-blue-500" step="1" min="0">
    </div>

    <div class="mb-4">
        <label for="morning_value_diastole" class="block font-semibold text-gray-700">Morning Diastole</label>
        <input type="number" name="morning_value_diastole" id="morning_value_diastole" class="w-full border-gray-300 rounded-md px-4 py-2 mt-1 focus:ring-blue-500 focus:border-blue-500" step="1" min="0">
    </div>

    <div class="mb-4">
        <label for="afternoon_value_systole" class="block font-semibold text-gray-700">Afternoon Systole</label>
        <input type="number" name="afternoon_value_systole" id="afternoon_value_systole" class="w-full border-gray-300 rounded-md px-4 py-2 mt-1 focus:ring-blue-500 focus:border-blue-500" step="1" min="0">
    </div>

    <div class="mb-4">
        <label for="afternoon_value_diastole" class="block font-semibold text-gray-700">Afternoon Diastole</label>
        <input type="number" name="afternoon_value_diastole" id="afternoon_value_diastole" class="w-full border-gray-300 rounded-md px-4 py-2 mt-1 focus:ring-blue-500 focus:border-blue-500" step="1" min="0">
    </div>

    <div class="mb-4">
        <label for="night_value_systole" class="block font-semibold text-gray-700">Night Systole</label>
        <input type="number" name="night_value_systole" id="night_value_systole" class="w-full border-gray-300 rounded-md px-4 py-2 mt-1 focus:ring-blue-500 focus:border-blue-500" step="1" min="0">
    </div>

    <div class="mb-4">
        <label for="night_value_diastole" class="block font-semibold text-gray-700">Night Diastole</label>
        <input type="number" name="night_value_diastole" id="night_value_diastole" class="w-full border-gray-300 rounded-md px-4 py-2 mt-1 focus:ring-blue-500 focus:border-blue-500" step="1" min="0">
    </div>

    <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        Add Reading
    </button>
    <a href="{{ route('kader.dashboard') }}" class="text-gray-500 hover:underline mt-4 block text-center">Back to Dashboard</a>
</form>
@endsection
