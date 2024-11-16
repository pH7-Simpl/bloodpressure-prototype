@extends('layouts.appdokter')

@section('content')
<div class="container mt-6 mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Manage Patients</h1>

    <!-- Assigned Patients Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Assigned Patients</h2>
        @if ($assignedPatients->isEmpty())
            <p class="text-gray-600">No patients assigned yet.</p>
        @else
        <ul class="list-disc ml-5 space-y-2">
            <!-- Removed previous incorrect link to a non-existent $reading variable -->
            @foreach ($assignedPatients as $patient)
                <li class="text-gray-800">
                    {{ $patient->nama }}
                    <!-- Unassign Button -->
                    <form action="{{ route('dokter.removePatient', $patient->id) }}" method="POST" class="inline ml-4"
                        id="unassign-form-{{ $patient->id }}">
                        @csrf
                        @method('POST')
                        <button type="button" onclick="confirmUnassign({{ $patient->id }})"
                            class="text-red-600 hover:underline">Unassign</button>
                    </form>
                </li>
            @endforeach
        </ul>
        @endif
    </div>

    <!-- Unassigned Patients Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Unassigned Patients</h2>
        @if ($unassignedPatients->isEmpty())
        <p>No patients available for assignment.</p>
        @else
        <ul class="list-disc ml-5 space-y-2">
            @foreach ($unassignedPatients as $patient)
            <li class="text-gray-800">
                {{ $patient->nama }}
                <!-- Assign Button -->
                <form action="{{ route('dokter.addPatient', $patient->id) }}" method="POST" class="inline ml-4"
                    id="assign-form-{{ $patient->id }}">
                    @csrf
                    @method('POST')
                    <button type="button" onclick="confirmAssign({{ $patient->id }})"
                        class="text-blue-600 hover:underline">Assign</button>
                    </form>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
</div>
<script>
    // Confirm Assign function
    function confirmAssign(patientId) {
        // Display the confirmation dialog for assigning
        if (confirm('Are you sure you want to assign this patient to your supervision?')) {
            // If confirmed, submit the form
            document.getElementById('assign-form-' + patientId).submit();
        }
    }

    // Confirm Unassign function
    function confirmUnassign(patientId) {
        // Display the confirmation dialog for unassigning
        if (confirm('Are you sure you want to unassign this patient from your supervision?')) {
            // If confirmed, submit the form
            document.getElementById('unassign-form-' + patientId).submit();
        }
    }
    </script>
@endsection
