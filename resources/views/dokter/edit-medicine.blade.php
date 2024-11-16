@extends('layouts.appdokter')

@section('content')
<div class="min-h-screen bg-cover bg-center flex justify-center items-center bg-no-repeat" style="background-image: url('{{ asset('images/rl.jpg') }}');">
    <div class="max-w-4xl mt-6 w-full bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">Edit Medicine for {{ $pasien->nama }}</h1>

        <!-- Edit Medicine Form -->
        <form action="{{ route('dokter.updateMedicine', ['patientId' => $pasien->id, 'medicineId' => $medicine->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="medicine_name" class="block text-lg font-medium text-gray-700">Medicine Name</label>
                <input type="text" id="medicine_name" name="medicine_name" value="{{ old('medicine_name', $medicine->medicine_name) }}" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
            </div>

            <div class="mb-4">
                <label for="dosage" class="block text-lg font-medium text-gray-700">Dosage</label>
                <input type="text" id="dosage" name="dosage" value="{{ old('dosage', $medicine->dosage) }}" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
            </div>

            <div class="mb-4">
                <label for="start_date" class="block text-lg font-medium text-gray-700">Start Date</label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $medicine->start_date) }}" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
            </div>

            <div class="mb-4">
                <label for="end_date" class="block text-lg font-medium text-gray-700">End Date</label>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $medicine->end_date) }}" class="mt-1 p-2 border border-gray-300 rounded w-full">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Update Medicine</button>
                <a href="{{ route('dokter.managepatientspecificmedicine', $pasien->id) }}" class="text-red-500 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
