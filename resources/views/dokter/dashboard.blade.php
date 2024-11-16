<!-- resources/views/dokter/dashboard.blade.php -->
@extends('layouts.appdokter')

@section('content')
<div class="min-h-screen bg-cover bg-center flex justify-center items-center" style="background-image: url('{{ asset('images/rl.jpg') }}');">
    <div class="max-w-4xl mt-6 w-full bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">Welcome Dr. {{ Auth::guard('dokter')->user()->nama }} to the Dokter Dashboard</h1>
        <p class="text-gray-600 mb-6">As a doctor, you can manage patient data, view blood pressure readings, and more.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
            <div class="bg-blue-100 p-4 rounded-lg shadow-md hover:bg-blue-200 transition">
                <h3 class="text-xl font-medium text-gray-800 mb-2">View Patient Blood Pressure</h3>
                <p class="text-gray-600">Access and manage patients' blood pressure readings.</p>
                <a href="{{ route('dokter.viewBloodPressure') }}" class="text-blue-500 hover:underline mt-2 inline-block">Go to Blood Pressure</a>
            </div>
            
            <div class="bg-green-100 p-4 rounded-lg shadow-md hover:bg-green-200 transition">
                <h3 class="text-xl font-medium text-gray-800 mb-2">View Medicine Information</h3>
                <p class="text-gray-600">View detailed information about medicines available for patients.</p>
                <a href="{{ route('dokter.managePatientsMedicine') }}" class="text-green-500 hover:underline mt-2 inline-block">Go to Medicines</a>
            </div>

            <div class="bg-yellow-100 p-4 rounded-lg shadow-md hover:bg-yellow-200 transition">
                <h3 class="text-xl font-medium text-gray-800 mb-2">View Suggestions for Lansia</h3>
                <p class="text-gray-600">Get healthcare suggestions and tips for senior citizens (Lansia).</p>
                <a href="#" class="text-yellow-500 hover:underline mt-2 inline-block">Go to Suggestions</a>
            </div>

            <div class="bg-purple-100 p-4 rounded-lg shadow-md hover:bg-purple-200 transition">
                <h3 class="text-xl font-medium text-gray-800 mb-2">View Appointments</h3>
                <p class="text-gray-600">Check and manage upcoming patient appointments.</p>
                <a href="#" class="text-purple-500 hover:underline mt-2 inline-block">Go to Appointments</a>
            </div>
            <div class="bg-purple-100 p-4 rounded-lg shadow-md hover:bg-purple-200 transition">
                <h3 class="text-xl font-medium text-gray-800 mb-2">Add Patient To Manage</h3>
                <p class="text-gray-600">Check and manage patient to be monitored.</p>
                <a href="{{ route('dokter.managePatients') }}" class="text-purple-500 hover:underline mt-2 inline-block">Go to Add</a>
            </div>
        </div>
    </div>
</div>
@endsection
