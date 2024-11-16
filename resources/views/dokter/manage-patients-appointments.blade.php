<!-- resources/views/dokter/manage-patients.blade.php -->
@extends('layouts.appdokter')

@section('content')
<div class="min-h-screen bg-cover bg-center flex justify-center items-center" style="background-image: url('{{ asset('images/rl.jpg') }}');">
    <div class="max-w-4xl mt-6 w-full bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">Manage Appointments for Patients</h1>
        
        <!-- Search Form -->
        <form method="GET" action="{{ route('dokter.managePatientsAppointments') }}" class="mb-4">
            <div class="flex items-center">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    class="w-full border rounded-lg p-2 focus:outline-none focus:ring focus:ring-blue-300" 
                    placeholder="Search by patient name">
                <button 
                    type="submit" 
                    class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">Search</button>
            </div>
        </form>
        <!-- Display Patients -->
        <div class="space-y-4">
            @foreach($pasiens as $pasien)
                <div class="bg-white p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
                    <h3 class="text-xl font-medium text-gray-800 mb-2">{{ $pasien->nama }}</h3>
                    <p class="text-gray-600">NIK: {{ $pasien->nik }}</p>
                    <p class="text-gray-600">Email: {{ $pasien->email }}</p>

                    <!-- View and Add Medicines for the patient -->
                    <div class="mt-4 flex space-x-4">
                        <a href="{{ route('dokter.managepatientspecificappointment', $pasien->id) }}" class="text-blue-500 hover:underline">View Appointments</a>
                        <a href="{{ route('dokter.addAppointmentsForm', $pasien->id) }}" class="text-green-500 hover:underline">Add Appointment</a>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Pagination -->
        <div class="mt-6">
            {{ $pasiens->links() }}
        </div>
    </div>
</div>
@endsection
