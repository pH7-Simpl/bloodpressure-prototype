@extends('layouts.appdokter')

@section('content')
<div class="min-h-screen bg-cover bg-center flex justify-center items-center bg-no-repeat" style="background-image: url('{{ asset('images/rl.jpg') }}');">
    <div class="max-w-4xl mt-6 w-full bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">Edit Appointment for {{ $pasien->nama }}</h1>

        <!-- Edit Medicine Form -->
        <form action="{{ route('dokter.updateAppointments', ['patientId' => $pasien->id, 'appointmentId' => $appointment->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-lg font-medium text-gray-700">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $appointment->title) }}" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-lg font-medium text-gray-700">Content</label>
                <input type="text" id="description" name="description" value="{{ old('description', $appointment->description) }}" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
            </div>
            <div class="mb-4">
                <label for="appointment_date" class="block text-lg font-medium text-gray-700">Appointment Date</label>
                <input type="date" id="appointment_date" name="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date) }}" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
            </div>
            <div class="mb-4">
                <label for="appointment_time" class="block text-lg font-medium text-gray-700">Appointment Time</label>
                <input type="time" id="appointment_time" name="appointment_time" value="{{ old('appointment_time', $appointment->appointment_time) }}" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
            </div>


            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Update Appointment</button>
                <a href="{{ route('dokter.managepatientspecificappointment', $pasien->id) }}" class="text-red-500 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
