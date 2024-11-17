@extends('layouts.apppasien')

@section('content')
<div class="container mx-auto mt-6 p-6 bg-white shadow-md rounded-lg bg-no-repeat">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, {{ Auth::guard('pasien')->user()->nama }} to your Dashboard!</h1>
    
    @if($kader)
        <p class="text-lg text-gray-600 mb-4">Your assigned Kader: <strong>{{ $kader->nama }}</strong></p>
    @else
        <p class="text-lg text-gray-600 mb-4">You do not have an assigned Kader yet.</p>
    @endif

    <p class="text-lg text-gray-600 mb-8">Here, you can view your health data, appointments, and receive suggestions for maintaining your well-being.</p>
    
    <!-- Blood Pressure Chart -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Your Blood Pressure Chart</h2>
        <div id="chart-container" class="mt-8">
            @if($readings->isEmpty())
            <p class="text-gray-600">No blood pressure readings available yet.</p>
            @else
            <div class="mt-6">
                <canvas id="bloodPressureChart"></canvas>
            </div>
            @endif
        </div>
    </div>

    <!-- Medicine Suggestions Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Prescribed Medicines</h2>
        @if($medicines->isEmpty())
            <p class="text-gray-600">No active medicines have been prescribed to you.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($medicines as $medicine)
                    <div class="bg-blue-100 p-4 rounded-lg shadow-lg">
                        <h3 class="font-semibold text-lg text-blue-700">{{ $medicine->medicine_name }}</h3>
                        <p class="text-gray-700">Dosage: {{ $medicine->dosage }}</p>
                        <p class="text-gray-600">Start Date: {{ $medicine->start_date }}</p>
                        
                        <!-- End Date (Hide if not available) -->
                        @if($medicine->end_date)
                            <p class="text-gray-600">End Date: {{ $medicine->end_date }}</p>
                        @else
                            <p class="text-gray-400"></p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Appointments Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Upcoming Appointments</h2>
        @if($appointments->isEmpty())
            <p class="text-gray-600">You don't have any upcoming appointments.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($appointments as $appointment)
                    <div class="bg-green-100 p-4 rounded-lg shadow-lg">
                        <h3 class="font-semibold text-lg text-green-700">{{ $appointment->title }}</h3>
                        <p class="text-gray-700">Date: {{ $appointment->appointment_date }} - {{ $appointment->appointment_time }}</p>
                        <p class="text-gray-600">Doctor: Dr. {{ $appointment->dokter->nama }}</p>
                        <p class="text-gray-600">Description: {{ $appointment->description }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Suggestion Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Suggestion from the Doctor</h2>
        @if($suggestions->isEmpty())
            <p class="text-gray-600">You don't have any suggestions yet.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($suggestions as $suggestion)
                    <div class="bg-yellow-100 p-4 rounded-lg shadow-lg">
                        <h3 class="font-semibold text-lg text-yellow-700">{{ $suggestion->title }}</h3>
                        <p class="text-gray-700">Date: {{ $suggestion->suggestion_date }}</p>
                        <p class="text-gray-600">Doctor: Dr. {{ $suggestion->dokter->nama }}</p>
                        <p class="text-gray-600">Suggestion: {{ $suggestion->content }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Prepare the data from Blade variables
        const readings = @json($readings); // Get the readings as a JavaScript object
        const labels = readings.map(reading => {
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