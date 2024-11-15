@extends('layouts.appkader')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, {{ Auth::guard('kader')->user()->nama }}!</h1>
    <p class="text-lg text-gray-600 mb-8">As an Ibu Kader, you can view and manage patient health data, including blood pressure readings, and assist in maintaining well-being in the community.</p>

    <!-- Blood Pressure Readings Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Patient Blood Pressure Readings</h2>
        <p class="text-gray-600 mb-4">Here, you can view and manage the blood pressure readings of patients assigned to you.</p>
        
        <ul class="list-disc ml-5 space-y-2">
        @foreach($patients as $patient)
            @foreach($patient->bloodPressureReadings as $reading)
                <li class="text-gray-800">
                    <a href="{{ route('kader.editRecord', $reading->id) }}" class="text-blue-600 hover:underline">
                        {{ $patient->nama }} - Blood Pressure Record (Date: {{ $reading->date }})
                    </a>
                </li>
            @endforeach
        @endforeach
        </ul>   
    </div>

    <!-- Edit Blood Pressure Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Blood Pressure Records</h2>
        <p class="text-gray-600 mb-4">You can add or update blood pressure records for the patients under your supervision.</p>
        
        <!-- Removed previous incorrect link to a non-existent $reading variable -->
        <a href="{{ route('kader.editRecord', ['id' => 1]) }}" class="inline-block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200 font-semibold">
            Add/Update Blood Pressure Record
        </a>
    </div>

    <!-- Health Suggestions Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Health Tips for the Community</h2>
        <p class="text-gray-600 mb-4">As an Ibu Kader, your role is essential in promoting health in the community. Here are some tips you can share:</p>
        <ul class="list-disc ml-5 space-y-2 text-gray-600">
            <li>Encourage regular blood pressure check-ups for everyone.</li>
            <li>Ensure patients are taking their prescribed medications on time.</li>
            <li>Help patients maintain a healthy diet and exercise routine.</li>
            <li>Support the community by raising awareness about preventive healthcare.</li>
        </ul>
    </div>

    <!-- Logout Button -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-200 font-semibold">Logout</button>
    </form>
</div>
@endsection
