<!-- resources/views/dokter/manage-patients.blade.php -->
@extends('layouts.appdokter')

@section('content')
<div class="min-h-screen bg-cover bg-center flex justify-center items-center" style="background-image: url('{{ asset('images/rl.jpg') }}');">
    <div class="max-w-4xl mt-6 w-full bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">Managed Patients</h1>
        <!-- Display Patients -->
        <div class="space-y-4">
            @foreach($pasiens as $pasien)
                <div class="bg-white p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
                    <h3 class="text-xl font-medium text-gray-800 mb-2">{{ $pasien->nama }}</h3>
                    <p class="text-gray-600">NIK: {{ $pasien->nik }}</p>
                    <p class="text-gray-600">Email: {{ $pasien->email }}</p>

                    <!-- View and Add Medicines for the patient -->
                    <div class="mt-4 flex space-x-4">
                        <a href="{{ route('dokter.managepatientspecificmedicine', $pasien->id) }}" class="text-blue-500 hover:underline">View Medicines</a>
                        <a href="{{ route('dokter.addMedicineForm', $pasien->id) }}" class="text-green-500 hover:underline">Add Medicine</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
