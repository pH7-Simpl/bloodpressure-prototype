@extends('layouts.appkader')

@section('content')
<div class="flex justify-center items-center min-h-screen">

    <!-- Kotak putih dengan padding dan sudut melengkung -->
    <div class="bg-white p-6 rounded-lg shadow-lg w-full sm:w-3/4 md:w lg:w-1/3">

        <h1 class="text-2xl font-bold mb-4">Blood Pressure Details for {{ \Carbon\Carbon::parse($reading->date)->format('Y-m-d') }}</h1>

        <!-- Daftar Bacaan -->
        <ul class="space-y-4 mb-6">
            <li class="flex justify-between">
                <span class="font-semibold text-gray-700">Morning:</span>
                <span class="text-gray-600">
                    @if($reading->morning_value_systole === null && $reading->morning_value_diastole === null)
                        <span class="italic text-gray-500">No Records</span>
                    @else
                        {{ $reading->morning_value_systole ?? 'N/A' }}/{{ $reading->morning_value_diastole ?? 'N/A' }}
                    @endif
                </span>
            </li>
            <li class="flex justify-between">
                <span class="font-semibold text-gray-700">Afternoon:</span>
                <span class="text-gray-600">
                    @if($reading->afternoon_value_systole === null && $reading->afternoon_value_diastole === null)
                        <span class="italic text-gray-500">No Records</span>
                    @else
                        {{ $reading->afternoon_value_systole ?? 'N/A' }}/{{ $reading->afternoon_value_diastole ?? 'N/A' }}
                    @endif
                </span>
            </li>
            <li class="flex justify-between">
                <span class="font-semibold text-gray-700">Night:</span>
                <span class="text-gray-600">
                    @if($reading->night_value_systole === null && $reading->night_value_diastole === null)
                        <span class="italic text-gray-500">No Records</span>
                    @else
                        {{ $reading->night_value_systole ?? 'N/A' }}/{{ $reading->night_value_diastole ?? 'N/A' }}
                    @endif
                </span>
            </li>
        </ul>

        <!-- Tombol Edit dan Hapus -->
        <div class="flex justify-between items-center mb-4 space-x-4">
            <a href="{{ route('kader.editBloodPressure', $reading->id) }}" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Edit
            </a>

            <form action="{{ route('kader.deleteBloodPressure', $reading->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-block px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    Delete
                </button>
            </form>
        </div>

        <!-- Tombol Navigasi -->
        <div class="space-y-2 text-center">
            <a href="{{ route('kader.editPatientBloodPressure', $reading->pasien_id) }}" class="inline-block px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                Back to Dates
            </a>
            <a href="{{ route('kader.dashboard') }}" class="inline-block px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                Back to Dashboard
            </a>
        </div>
        
    </div>
</div>
@endsection
