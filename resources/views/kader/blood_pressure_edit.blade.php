@extends('layouts.appkader')

@section('content')
<div class="flex justify-center items-center min-h-screen">

    <!-- Kotak putih dengan padding dan sudut melengkung -->
    <div class="bg-white p-6 rounded-lg shadow-lg w-full sm:w-3/4 md:w-1/2 lg:w-1/3">

        <h1 class="text-2xl font-bold mb-4">Edit Blood Pressure for {{ \Carbon\Carbon::parse($reading->date)->format('Y-m-d') }}</h1>

        <!-- Formulir untuk mengedit Blood Pressure -->
        <form action="{{ route('kader.updateBloodPressure', $reading->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="morning_value_systole" class="block text-sm font-medium text-gray-700">Morning Systole:</label>
                <input type="number" name="morning_value_systole" id="morning_value_systole" value="{{ $reading->morning_value_systole }}" class="w-full border-gray-300 rounded-lg p-2 mt-1" step="1" min="0">
            </div>
            
            <div>
                <label for="morning_value_diastole" class="block text-sm font-medium text-gray-700">Morning Diastole:</label>
                <input type="number" name="morning_value_diastole" id="morning_value_diastole" value="{{ $reading->morning_value_diastole }}" class="w-full border-gray-300 rounded-lg p-2 mt-1" step="1" min="0">
            </div>
            
            <div>
                <label for="afternoon_value_systole" class="block text-sm font-medium text-gray-700">Afternoon Systole:</label>
                <input type="number" name="afternoon_value_systole" id="afternoon_value_systole" value="{{ $reading->afternoon_value_systole }}" class="w-full border-gray-300 rounded-lg p-2 mt-1" step="1" min="0">
            </div>
            
            <div>
                <label for="afternoon_value_diastole" class="block text-sm font-medium text-gray-700">Afternoon Diastole:</label>
                <input type="number" name="afternoon_value_diastole" id="afternoon_value_diastole" value="{{ $reading->afternoon_value_diastole }}" class="w-full border-gray-300 rounded-lg p-2 mt-1" step="1" min="0">
            </div>
            
            <div>
                <label for="night_value_systole" class="block text-sm font-medium text-gray-700">Night Systole:</label>
                <input type="number" name="night_value_systole" id="night_value_systole" value="{{ $reading->night_value_systole }}" class="w-full border-gray-300 rounded-lg p-2 mt-1" step="1" min="0">
            </div>
            
            <div>
                <label for="night_value_diastole" class="block text-sm font-medium text-gray-700">Night Diastole:</label>
                <input type="number" name="night_value_diastole" id="night_value_diastole" value="{{ $reading->night_value_diastole }}" class="w-full border-gray-300 rounded-lg p-2 mt-1" step="1" min="0">
            </div>

            <!-- Tombol Update -->
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 mt-4">
                Update
            </button>
        </form>

        <!-- Tombol Navigasi -->
        <div class="space-y-2 mt-6 text-center">
            <a href="{{ route('kader.editPatientBloodPressure', $reading->pasien_id) }}" class="inline-block w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                Back to Dates
            </a>
            <a href="{{ route('kader.dashboard') }}" class="inline-block w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                Back to Dashboard
            </a>
        </div>
        
    </div>
</div>
@endsection
