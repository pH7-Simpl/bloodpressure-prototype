<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blood Pressure Monitoring</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-pink-100 via-purple-200 to-indigo-100 min-h-screen flex flex-col">
    <header class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white py-6 shadow-lg">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-4xl font-extrabold text-center">
                Welcome to <span class="text-yellow-300">Blood Pressure Monitoring</span>
            </h1>
        </div>
    </header>

    <main class="flex-grow flex flex-col items-center justify-center">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-indigo-600">Monitor, Manage, and Improve</h2>
            <p class="mt-4 text-lg text-gray-700">
                A simple yet powerful tool for healthcare workers to track patients' blood pressure readings effortlessly.
            </p>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl px-6">
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

        <div class="mt-8 flex items-center">
            <a href="{{ route('login') }}" class="px-8 py-3 text-lg font-bold text-white bg-pink-500 rounded-lg shadow-lg hover:bg-pink-600 transition">
                Login
            </a>
            <a href="{{ route('register') }}" class="ml-4 px-8 py-3 text-lg font-bold text-white bg-indigo-500 rounded-lg shadow-lg hover:bg-indigo-600 transition">
                Register
            </a>
        </div>
    </main>

    <footer class="bg-indigo-600 text-white py-4 text-center">
        <p class="text-sm">© {{ date('Y') }} Blood Pressure Monitoring. Made with ❤ by {{ config('app.name') }}</p>
    </footer>
</body>
</html>