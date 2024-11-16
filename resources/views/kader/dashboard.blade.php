@extends('layouts.appkader')

@section('content')
<div class="container mt-6 mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, {{ Auth::guard('kader')->user()->nama }}!</h1>
    <p class="text-lg text-gray-600 mb-8">As an Ibu Kader, you can view and manage patient health data, including blood
        pressure readings, and assist in maintaining well-being in the community.</p>

    <!-- Blood Pressure Readings Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Patient Blood Pressure Readings</h2>
        <p class="text-gray-600 mb-4">Here, you can view the blood pressure readings of patients assigned to
            you.</p>

        <!-- Dropdown for viewing registered patients -->
        <div class="mb-4">
            <label for="patient-dropdown" class="block text-gray-700 font-medium mb-2">View Patients' Blood
                Pressure</label>
            <select id="patient-dropdown"
                class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="" disabled selected>Select a Patient</option>
                @foreach ($supervisedPatients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- Chart Container -->
        <div id="chart-container" class="mt-8 hidden">
            <h2 class="text-xl font-semibold mb-4">Blood Pressure Chart</h2>
            <canvas id="bloodPressureChart"></canvas>
        </div>

    </div>

    <!-- Edit Blood Pressure Readings Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Patient Blood Pressure Readings</h2>
        <p class="text-gray-600 mb-4">Here, you can manage the blood pressure readings of patients assigned to
            you.</p>

        <ul class="list-disc ml-5 space-y-2">
            <!-- Removed previous incorrect link to a non-existent $reading variable -->
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
    </div>

    <!-- Display patients not assigned to any kader -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Add Patients to Your Supervision</h2>
        <p class="text-gray-600 mb-4">Below are the patients that are not currently supervised by any kader.</p>

        @if ($unassignedPatients->isEmpty())
            <p>No patients available for assignment.</p>
        @else
            <ul class="list-disc ml-5 space-y-2">
                @foreach ($unassignedPatients as $patient)
                    <li class="text-gray-800">
                        {{ $patient->nama }}
                        <!-- Assign Button -->
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
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
    document.addEventListener("DOMContentLoaded", function () {
        const chartContainer = document.getElementById('chart-container');
        const patientDropdown = document.getElementById('patient-dropdown');
        let bloodPressureChart;

        patientDropdown.addEventListener('change', function () {
            const patientId = this.value;

            if (patientId) {
                fetch(`/kader/patient/${patientId}/blood-pressure-data`)
                    .then(response => response.json())
                    .then(data => {
                        const labels = data.map(reading => {
        // Parse the date and format it to only include the date
        const date = new Date(reading.date);
        return date.toLocaleDateString('id-ID'); // Adjust locale as needed
    });
                        const systoleData = data.map(reading => reading.morning_value_systole ?? reading.afternoon_value_systole ?? reading.night_value_systole);
                        const diastoleData = data.map(reading => reading.morning_value_diastole ?? reading.afternoon_value_diastole ?? reading.night_value_diastole);

                        if (bloodPressureChart) {
                            bloodPressureChart.destroy();
                        }

                        const ctx = document.getElementById('bloodPressureChart').getContext('2d');
                        bloodPressureChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: 'Systole',
                                        data: systoleData,
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        fill: false,
                                        tension: 0.4
                                    },
                                    {
                                        label: 'Diastole',
                                        data: diastoleData,
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                        fill: false,
                                        tension: 0.4
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: { position: 'top' },
                                    tooltip: { enabled: true },
                                    annotation: {
                                        annotations: {
                                            line1: {
                                                type: 'line',
                                                yMin: 120,
                                                yMax: 120,
                                                borderColor: 'rgba(255, 0, 0, 1)', // Red line for systole
                                                borderWidth: 2,
                                                borderDash: [5, 5], // Dashed line
                                                label: {
                                                    content: 'Normal Systolic BP (120)',
                                                    enabled: true,
                                                    position: 'end',
                                                    backgroundColor: 'rgba(255, 0, 0, 0.5)',
                                                    color: 'white',
                                                    font: { size: 12 }
                                                }
                                            },
                                            line2: {
                                                type: 'line',
                                                yMin: 80,
                                                yMax: 80,
                                                borderColor: 'rgba(255, 0, 0, 1)', // Red line for diastole
                                                borderWidth: 2,
                                                borderDash: [5, 5], // Dashed line
                                                label: {
                                                    content: 'Normal Diastolic BP (80)',
                                                    enabled: true,
                                                    position: 'end',
                                                    backgroundColor: 'rgba(255, 0, 0, 0.5)',
                                                    color: 'white',
                                                    font: { size: 12 }
                                                }
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: { display: true, text: 'Blood Pressure (mmHg)' }
                                    },
                                    x: {
                                        title: { display: true, text: 'Date' }
                                    }
                                }
                            }
                        });

                        chartContainer.classList.remove('hidden');
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }
        });
    });
</script>
