<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Login</h2>
    
    <form method="POST" action="{{ route('customlogin') }}">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
            <input type="text" name="name" placeholder="Name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="nik" class="block text-gray-700 font-medium mb-2">NIK</label>
            <input type="text" name="nik" placeholder="NIK" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                {{ __("Don't Have An Account?") }}
            </a>

            <x-primary-button type="button" class="ms-4" onclick="openModal()">
                {{ __('Login') }}
            </x-primary-button>
        </div>

        @if ($errors->any())
            <div class="mt-4 p-3 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>

    <!-- Modal for Password Authentication -->
    <div id="passwordModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">Enter Password</h2>
            
            <form method="POST" action="{{ route('authenticate') }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ old('user_id', $user->id ?? '') }}">
                <input type="hidden" name="role" value="{{ old('role', $role ?? '') }}">
                
                <div class="mb-4">
                    <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-200 font-semibold">Authenticate</button>
            </form>

            @if ($errors->any())
                <div class="mt-4 p-3 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button onclick="closeModal()" class="mt-4 w-full bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition duration-200">Cancel</button>
        </div>
    </div>

    <!-- JavaScript to handle modal -->
    <script>
        function openModal() {
            document.getElementById('passwordModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('passwordModal').classList.add('hidden');
        }
    </script>
</x-guest-layout>
