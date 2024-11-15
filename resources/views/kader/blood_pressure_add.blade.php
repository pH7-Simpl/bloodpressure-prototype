@extends('layouts.appkader')

@section('content')
<h1 class="text-2xl font-bold">Add Blood Pressure Reading for {{ $patient->nama }}</h1>

<form method="POST" action="{{ route('kader.storeBloodPressure') }}" class="mt-4">
    @csrf

    <input type="hidden" name="pasien_id" value="{{ $patient->id }}">

    <div class="mb-4">
        <label for="date" class="block font-semibold">Date</label>
        <input type="date" name="date" id="date" required class="w-full border-gray-300 rounded-lg">
    </div>

    <div class="mb-4">
        <label for="morning_value_systole" class="block font-semibold">Morning Systole</label>
        <input type="number" name="morning_value_systole" id="morning_value_systole" class="w-full border-gray-300 rounded-lg">
    </div>

    <div class="mb-4">
        <label for="morning_value_diastole" class="block font-semibold">Morning Diastole</label>
        <input type="number" name="morning_value_diastole" id="morning_value_diastole" class="w-full border-gray-300 rounded-lg">
    </div>

    <div class="mb-4">
        <label for="afternoon_value_systole" class="block font-semibold">Afternoon Systole</label>
        <input type="number" name="afternoon_value_systole" id="afternoon_value_systole" class="w-full border-gray-300 rounded-lg">
    </div>

    <div class="mb-4">
        <label for="afternoon_value_diastole" class="block font-semibold">Afternoon Diastole</label>
        <input type="number" name="afternoon_value_diastole" id="afternoon_value_diastole" class="w-full border-gray-300 rounded-lg">
    </div>

    <div class="mb-4">
        <label for="night_value_systole" class="block font-semibold">Night Systole</label>
        <input type="number" name="night_value_systole" id="night_value_systole" class="w-full border-gray-300 rounded-lg">
    </div>

    <div class="mb-4">
        <label for="night_value_diastole" class="block font-semibold">Night Diastole</label>
        <input type="number" name="night_value_diastole" id="night_value_diastole" class="w-full border-gray-300 rounded-lg">
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
        Add Reading
    </button>
</form>

<a href="{{ route('kader.dashboard') }}" class="text-gray-500 hover:underline mt-4 block">Back to Dashboard</a>
@endsection
