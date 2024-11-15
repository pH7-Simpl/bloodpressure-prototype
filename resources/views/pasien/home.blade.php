@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, {{ Auth::guard('pasien')->user()->nama }} to pasien Dashboard!</h1>
    <p class="text-lg text-gray-600 mb-8">Here, you can view your health data, appointments, and receive suggestions for maintaining your well-being.</p>

    <!-- Blood Pressure Readings Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Blood Pressure Readings</h2>
        @if($readings->isEmpty())
            <p class="text-gray-600">No blood pressure readings available yet.</p>
        @else
            <ul class="list-disc ml-5 space-y-2">
                @foreach($readings as $reading)
                    <li class="text-gray-800">
                        {{ $reading->date }} - 
                        Morning: {{ $reading->morning_value }} / Afternoon: {{ $reading->afternoon_value }} / Night: {{ $reading->night_value }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Medicine Suggestions Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Prescribed Medicines</h2>
        @if($medicines->isEmpty())
            <p class="text-gray-600">No medicines have been prescribed to you.</p>
        @else
            <ul class="list-disc ml-5 space-y-2">
                @foreach($medicines as $medicine)
                    <li class="text-gray-800">
                        {{ $medicine->medicine_name }} - Dosage: {{ $medicine->dosage }}<br>
                        Start Date: {{ $medicine->start_date }} - End Date: {{ $medicine->end_date }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Appointments Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Upcoming Appointments</h2>
        @if($appointments->isEmpty())
            <p class="text-gray-600">You don't have any upcoming appointments.</p>
        @else
            <ul class="list-disc ml-5 space-y-2">
                @foreach($appointments as $appointment)
                    <li class="text-gray-800">
                        <strong>{{ $appointment->title }}</strong><br>
                        {{ $appointment->appointment_date }}<br>
                        Doctor: Dr. {{ $appointment->dokter->nama }}<br>
                        Description: {{ $appointment->description }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Suggestions Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Health Suggestions</h2>
        <p class="text-gray-600">Here are some health tips for you to stay in good shape:</p>
        <ul class="list-disc ml-5 space-y-2 text-gray-600">
            <li>Stay hydrated by drinking plenty of water.</li>
            <li>Take your medication as prescribed by your doctor.</li>
            <li>Maintain a balanced diet and exercise regularly.</li>
        </ul>
    </div>

    <!-- Logout Button -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-200 font-semibold">Logout</button>
    </form>
</div>
@endsection
