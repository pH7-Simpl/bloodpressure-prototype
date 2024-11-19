<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blood Pressure Monitoring</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="min-h-screen flex flex-col bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('images/rl.jpg') }}');">
    <header class="bg-gradient-to-r from-green-700 to-green-500 text-white py-6 shadow-lg">
        <div class="mx-auto px-6 flex justify-between items-center h-full">
            <div class="space-x-4">
                <a href="{{ route('login') }}"
                    class="text-lg font-semibold text-green-700 hover:text-indigo-200 transition">Login</a>
                <a href="{{ route('register') }}"
                    class="text-lg font-semibold text-green-700 hover:text-indigo-200 transition">Register</a>
            </div>
            <!-- Center the text horizontally and vertically -->
            <h1 class="text-4xl font-extrabold flex-grow text-center">
                Welcome to <span class="text-indigo-700">Blood Pressure Monitoring</span>
            </h1>
            <!-- Align the login and register buttons to the right -->
            <div class="space-x-4">
                <a href="{{ route('login') }}"
                    class="text-lg font-semibold text-white hover:text-indigo-200 transition">Login</a>
                <a href="{{ route('register') }}"
                    class="text-lg font-semibold text-white hover:text-indigo-200 transition">Register</a>
            </div>
        </div>
    </header>
    <main class="flex-grow flex flex-col items-center justify-center">
        <div class="mt-8 text-center bg-white shadow-md rounded-lg p-6">
            <h2 class="text-3xl font-bold text-indigo-600">Monitor, Manage, and Improve</h2>
            <p class="mt-4 text-lg text-gray-700">
                A simple yet powerful tool for healthcare workers to track patients' blood pressure readings
                effortlessly.
            </p>
        </div>

        <!-- Chart Section -->
        <div class="mt-8 bg-white shadow-md rounded-lg p-6 w-full max-w-4xl">
            <h3 class="text-2xl font-semibold text-indigo-600 text-center">Patient Assignment Overview</h3>
            <div class="flex justify-around mt-6">
                <!-- Chart for Kader -->
                <div class="w-1/2 p-4">
                    <h3 class="text-center font-semibold text-indigo-600">Patient Assigned By Kader</h3>
                    <canvas id="kaderChart"></canvas>
                </div>
                <!-- Chart for Dokter -->
                <div class="w-1/2 p-4">
                    <h3 class="text-center font-semibold text-indigo-600">Patient Assigned By Doctor</h3>
                    <canvas id="dokterChart"></canvas>
                </div>
            </div>
            <div id="pasienAmount" class="text-center mt-4 text-gray-600"></div>
        </div>

        <div class="mt-8 flex items-center mb-8 grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl px-6">
            <!-- Feature 1 -->
            <div class="bg-white shadow-md rounded-lg p-6 transform hover:-translate-y-2 transition duration-300">
                <h3 class="text-2xl font-semibold text-purple-600">📊 Interactive Charts</h3>
                <p class="mt-2 text-gray-600">
                    View systole and diastole trends in visually appealing charts for better insights.
                </p>
            </div>
            <!-- Feature 2 -->
            <div class="bg-white shadow-md rounded-lg p-6 transform hover:-translate-y-2 transition duration-300">
                <h3 class="text-2xl font-semibold text-blue-600">📝 Record Management</h3>
                <p class="mt-2 text-gray-600">
                    Add, edit, and view patients' readings with ease using an intuitive interface.
                </p>
            </div>
            <!-- Feature 3 -->
            <div class="bg-white shadow-md rounded-lg p-6 transform hover:-translate-y-2 transition duration-300">
                <h3 class="text-2xl font-semibold text-green-600">💡 Easy Navigation</h3>
                <p class="mt-2 text-gray-600">
                    Navigate seamlessly between features and access patient details in just a few clicks.
                </p>
            </div>
            <!-- Feature 4 -->
            <div class="bg-white shadow-md rounded-lg p-6 transform hover:-translate-y-2 transition duration-300">
                <h3 class="text-2xl font-semibold text-yellow-600">🔒 Secure Access</h3>
                <p class="mt-2 text-gray-600">
                    Keep your data safe with built-in security features and user authentication.
                </p>
            </div>
        </div>
    </main>
    <footer class="bg-green-800 text-white py-4 text-center">
        <p class="text-sm">© {{ date('Y') }} Blood Pressure Monitoring. Made with ❤ by {{ config('app.name') }}</p>
    </footer>
    <!-- Chart Script -->
    <script>
        // Fetch assignment stats from backend
        fetch('/assignment-stats')
            .then(response => response.json())
            .then(data => {
                // Kader Chart
                const kaderCtx = document.getElementById('kaderChart').getContext('2d');
                new Chart(kaderCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Assigned', 'Unassigned'],
                        datasets: [{
                            data: [data.kader.assigned, data.kader.total - data.kader.assigned],
                            backgroundColor: ['#4caf50', '#f44336'], // Colors
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    generateLabels: function (chart) {
                                        const data = chart.data.datasets[0].data; // Access dataset data
                                        const total = data.reduce((sum, value) => sum + value, 0); // Calculate total
                                        const labels = chart.data.labels; // Get labels

                                        return labels.map((label, index) => {
                                            const value = data[index];
                                            const percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;

                                            return {
                                                text: `${label} (${percentage}%)`, // Add percentage to label
                                                fillStyle: chart.data.datasets[0].backgroundColor[index],
                                                hidden: false,
                                                index: index,
                                            };
                                        });
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        const total = data.kader.total;
                                        const value = tooltipItem.raw;
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;
                                        return `${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });

                // Dokter Chart
                const dokterCtx = document.getElementById('dokterChart').getContext('2d');
                new Chart(dokterCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Assigned', 'Unassigned'],
                        datasets: [{
                            data: [data.dokter.assigned, data.dokter.total - data.dokter.assigned],
                            backgroundColor: ['#4caf50', '#f44336'], // Colors
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    generateLabels: function (chart) {
                                        const data = chart.data.datasets[0].data; // Access dataset data
                                        const total = data.reduce((sum, value) => sum + value, 0); // Calculate total
                                        const labels = chart.data.labels; // Get labels

                                        return labels.map((label, index) => {
                                            const value = data[index];
                                            const percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;

                                            return {
                                                text: `${label} (${percentage}%)`, // Add percentage to label
                                                fillStyle: chart.data.datasets[0].backgroundColor[index],
                                                hidden: false,
                                                index: index,
                                            };
                                        });
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        const total = data.dokter.total;
                                        const value = tooltipItem.raw;
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;
                                        return `${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
                // Update Dokter Details
                const pasienAmount = data.dokter.total;
                const roundedPasienAmount = Math.floor(pasienAmount / 5) * 5; // Round down to nearest 5
                document.getElementById('pasienAmount').textContent = `Dipercaya oleh ${roundedPasienAmount} pasien ++`;
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>
</body>

</html>