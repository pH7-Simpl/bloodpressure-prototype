@extends('layouts.appdokter')

@section('content')
<div class="container mt-6 mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Manage Patients</h1>

    <!-- Assigned Patients Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Assigned Patients</h2>

        <!-- Search Form for Assigned Patients -->
        <form method="GET" action="{{ route('dokter.managePatients') }}" class="mb-4">
            <input type="text" name="assigned_search" value="{{ $assignedSearch ?? '' }}"
                placeholder="Search Assigned Patients" class="px-4 py-2 border rounded-md" />
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md ml-2">Search</button>
        </form>

        @if ($assignedPatients->isEmpty())
            <p class="text-gray-600">No patients assigned yet.</p>
        @else
            <ul class="list-disc ml-5 space-y-2 assigned-patients">
                @foreach ($assignedPatients as $patient)
                    <li class="text-gray-800">
                        {{ $patient->nama }}
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


            <!-- Pagination Links for Assigned Patients -->
            {{ $assignedPatients->links() }}
        @endif
    </div>

    <!-- Unassigned Patients Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Unassigned Patients</h2>

        <!-- Search Form for Unassigned Patients -->
        <form method="GET" action="{{ route('dokter.managePatients') }}" class="mb-4">
            <input type="text" name="unassigned_search" value="{{ $unassignedSearch ?? '' }}"
                placeholder="Search Unassigned Patients" class="px-4 py-2 border rounded-md" />
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md ml-2">Search</button>
        </form>

        @if ($unassignedPatients->isEmpty())
            <p>No patients available for assignment.</p>
        @else
            <ul class="list-disc ml-5 space-y-2 unassigned-patients">
                @foreach ($unassignedPatients as $patient)
                    <li class="text-gray-800">
                        {{ $patient->nama }}
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

            <!-- Pagination Links for Unassigned Patients -->
            {{ $unassignedPatients->links() }}
        @endif
    </div>
</div>

<script>
    // Confirm Assign function
    function confirmAssign(patientId) {
        if (confirm('Are you sure you want to assign this patient to your supervision?')) {
            document.getElementById('assign-form-' + patientId).submit();
        }
    }

    // Confirm Unassign function
    function confirmUnassign(patientId) {
        if (confirm('Are you sure you want to unassign this patient from your supervision?')) {
            document.getElementById('unassign-form-' + patientId).submit();
        }
    }
</script>
@endsection