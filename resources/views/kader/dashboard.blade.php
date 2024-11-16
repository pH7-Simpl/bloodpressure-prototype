@extends('layouts.appkader')

@section('content')
<div class="container mt-6 mx-auto p-6 bg-white shadow-md rounded-lg bg-no-repeat">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, {{ Auth::guard('kader')->user()->nama }}!</h1>
    <p class="text-lg text-gray-600 mb-8">As an Ibu Kader, you can view and manage patient health data, including blood
        pressure readings, and assist in maintaining well-being in the community.</p>

    <!-- Edit Blood Pressure Readings Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Patient Blood Pressure Readings</h2>
        <p class="text-gray-600 mb-4">Here, you can manage the blood pressure readings of patients assigned to you.</p>

        <ul class="list-disc ml-5 space-y-2">
            @foreach ($supervisedPatients as $patient)
                <li class="text-gray-800">
                    {{ $patient->nama }}
                    <a href="{{ route('kader.editPatientBloodPressure', $patient->id) }}"
                        class="ml-4 text-blue-600 hover:underline">
                        Edit Blood Pressure
                    </a>

                    <!-- Unassign Button -->
                    <form action="{{ route('kader.unassignPatient', $patient->id) }}" method="POST" class="inline ml-4"
                        id="unassign-form-{{ $patient->id }}">
                        @csrf
                        @method('POST')
                        <button type="button" onclick="confirmUnassign({{ $patient->id }})"
                            class="text-red-600 hover:underline">Unassign</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $supervisedPatients->links() }}
        </div>
    </div>

    <!-- Add Patients to Your Supervision Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Add Patients to Your Supervision</h2>
        <p class="text-gray-600 mb-4">Below are the patients that are not currently supervised by any kader.</p>

        <!-- Search Form -->
        <form method="GET" action="{{ route('kader.dashboard') }}" class="mb-4">
            <input type="text" name="search" value="{{ request()->get('search') }}" placeholder="Search by name"
                class="border border-gray-300 px-4 py-2 rounded-md" />
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Search</button>
        </form>

        @if ($unassignedPatients->isEmpty())
            <p>No patients available for assignment.</p>
        @else
            <ul class="list-disc ml-5 space-y-2">
                @foreach ($unassignedPatients as $patient)
                    <li class="text-gray-800">
                        {{ $patient->nama }}
                        <form action="{{ route('kader.addPatientToKader', $patient->id) }}" method="POST" class="inline ml-4"
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

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $unassignedPatients->links() }}
        </div>
    </div>

    <!-- Health Suggestions Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Health Tips for the Community</h2>
        <p class="text-gray-600 mb-4">As an Ibu Kader, your role is essential in promoting health in the community. Here
            are some tips you can share:</p>
        <ul class="list-disc ml-5 space-y-2 text-gray-600">
            <li>Encourage regular blood pressure check-ups for everyone.</li>
            <li>Ensure patients are taking their prescribed medications on time.</li>
            <li>Help patients maintain a healthy diet and exercise routine.</li>
            <li>Support the community by raising awareness about preventive healthcare.</li>
        </ul>
    </div>
</div>
@endsection
