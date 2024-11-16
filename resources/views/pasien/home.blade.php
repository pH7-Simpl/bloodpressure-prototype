@extends('layouts.apppasien')

@section('content')
<div class="container mx-auto mt-6 p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, {{ Auth::guard('pasien')->user()->nama }} to your Dashboard!</h1>
    <p class="text-lg text-gray-600 mb-8">Here, you can view your health data, appointments, and receive suggestions for maintaining your well-being.</p>

    @if($readings->isEmpty())
        <p class="text-gray-600">No blood pressure readings available yet.</p>
    @else

        <!-- Blood Pressure Chart -->
        <div class="mt-6">
            <canvas id="bloodPressureChart"></canvas>
        </div>
    @endif
    <!-- Blood Pressure Chart -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Your Blood Pressure Chart</h2>
        <div id="chart-container" class="mt-8">
            <canvas id="bloodPressureChart"></canvas>
        </div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Prepare the data from Blade variables
        const readings = @json($readings); // Get the readings as a JavaScript object
        const labels = data.map(reading => {
        // Parse the date and format it to only include the date
        const date = new Date(reading.date);
        return date.toLocaleDateString('id-ID'); // Adjust locale as needed
    });
        const systoleData = readings.map(reading => reading.morning_value_systole ?? reading.afternoon_value_systole ?? reading.night_value_systole);
        const diastoleData = readings.map(reading => reading.morning_value_diastole ?? reading.afternoon_value_diastole ?? reading.night_value_diastole);

        // Create the chart
        const ctx = document.getElementById('bloodPressureChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Systole',
                        data: systoleData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Diastole',
                        data: diastoleData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        // Red line at normal blood pressure
                        label: 'Normal Systolic Pressure',
                        data: new Array(labels.length).fill(120),
                        borderColor: 'rgba(255, 0, 0, 0.6)',
                        borderDash: [5, 5], // dashed line
                        fill: false,
                        tension: 0
                    },
                    {
                        // Red line at normal blood pressure (diastolic)
                        label: 'Normal Diastolic Pressure',
                        data: new Array(labels.length).fill(80),
                        borderColor: 'rgba(255, 0, 0, 0.6)',
                        borderDash: [5, 5], // dashed line
                        fill: false,
                        tension: 0
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Blood Pressure (mmHg)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    });
</script>
