@extends('layouts.appdokter')

@section('content')
<div class="min-h-screen bg-cover bg-center flex justify-center items-center" style="background-image: url('{{ asset('images/rl.jpg') }}');">
    <div class="max-w-4xl mt-6 w-full bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">Add Medicine for {{ $pasien->nama }}</h1>

        <form action="{{ route('dokter.storeMedicine', $pasien->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="medicine_name" class="block text-gray-700">Medicine Name</label>
                <input type="text" id="medicine_name" name="medicine_name" class="w-full border border-gray-300 p-2" required>
            </div>
            <div class="mb-4">
                <label for="dosage" class="block text-gray-700">Dosage</label>
                <input type="text" id="dosage" name="dosage" class="w-full border border-gray-300 p-2" required>
            </div>
            <div class="mb-4">
                <label for="start_date" class="block text-gray-700">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="w-full border border-gray-300 p-2" required>
            </div>
            <div class="mb-4">
                <label for="end_date" class="block text-gray-700">End Date (Optional)</label>
                <input type="date" id="end_date" name="end_date" class="w-full border border-gray-300 p-2">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Medicine</button>
        </form>
    </div>
</div>
@endsection
