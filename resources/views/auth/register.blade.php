<x-guest-layout>
    <form method="POST" action="{{ route('customregister') }}">
        @csrf
        <div class="mb-4">
            <label for="role" class="block text-gray-700 font-semibold mb-2">Role</label>
            <select name="role" id="role"
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                onchange="toggleFields()">
                <option value="dokter">Dokter</option>
                <option value="kader">Kader</option>
                <option value="pasien">Pasien</option>
            </select>
        </div>

        <!-- Common Fields for All Roles -->
        <div class="mb-4">
            <input type="text" name="name" placeholder="Name" required
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <input type="text" name="nik" placeholder="NIK" required
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" required
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <input type="date" name="tanggal_lahir" required
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label for="jenis_kelamin" class="block text-gray-700 font-semibold mb-2">Jenis Kelamin</label>
            <select name="jenis_kelamin" required
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="mb-4">
            <input type="text" name="agama" placeholder="Agama" required
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <input type="text" name="golongan_darah" placeholder="Golongan Darah" required
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <input type="text" name="no_hp" placeholder="No. Handphone" required
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <input type="text" name="alamat" placeholder="Alamat" required
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <input type="text" name="provinsi" placeholder="Provinsi" required
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <input type="text" name="kabupaten_kota" placeholder="Kab/Kota" required
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <input type="text" name="kecamatan" placeholder="Kecamatan" required
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <input type="email" name="email" placeholder="Email" required
                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Conditionally Rendered Fields -->
        <div id="role-specific-fields">
            <!-- Password fields for Dokter and Kader only -->
            <div id="password-field" class="mb-4">
                <input type="password" name="password" placeholder="Password" required
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div id="password_confirmation-field" class="mb-6">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Fields specific to Pasien -->
            <div id="kategori_pasien-field" class="mb-4">
                <label for="kategori_pasien" class="block text-gray-700 font-semibold mb-2">Kategori Pasien</label>
                <select name="kategori_pasien" id="kategori_pasien"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onchange="toggleBpjsField()">
                    <option value="Umum">Umum</option>
                    <option value="BPJS">BPJS</option>
                </select>
            </div>
            <div id="no_bpjs-field" class="mb-4 hidden">
                <input type="text" name="no_bpjs" placeholder="No BPJS"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button type="submit" class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mt-4 p-3 bg-red-100 text-red-600 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</x-guest-layout>
<script>
    // Function to toggle password and BPJS fields based on selected role
    function toggleFields() {
        const role = document.getElementById('role').value;
        const passwordField = document.getElementById('password-field');
        const passwordConfirmationField = document.getElementById('password_confirmation-field');
        const kategoriPasienField = document.getElementById('kategori_pasien-field');
        const noBpjsField = document.getElementById('no_bpjs-field');

        // Show/Hide password fields based on role
        if (role === 'pasien') {
            passwordField.style.display = 'none';
            passwordConfirmationField.style.display = 'none';
            kategoriPasienField.style.display = 'block';

            // Remove the required attribute from password and password_confirmation
            document.querySelector('[name="password"]').removeAttribute('required');
            document.querySelector('[name="password_confirmation"]').removeAttribute('required');
        } else {
            passwordField.style.display = 'block';
            passwordConfirmationField.style.display = 'block';
            kategoriPasienField.style.display = 'none';

            // Add the required attribute for password and password_confirmation
            document.querySelector('[name="password"]').setAttribute('required', 'required');
            document.querySelector('[name="password_confirmation"]').setAttribute('required', 'required');
        }

        // Reset BPJS field visibility based on selected kategori_pasien
        if (role === 'pasien' && document.getElementById('kategori_pasien').value === 'BPJS') {
            noBpjsField.style.display = 'block';
        } else {
            noBpjsField.style.display = 'none';
        }
    }

    // Function to toggle No BPJS field based on kategori_pasien selection
    function toggleBpjsField() {
        const kategoriPasien = document.getElementById('kategori_pasien').value;
        const noBpjsField = document.getElementById('no_bpjs-field');

        if (kategoriPasien === 'BPJS') {
            noBpjsField.style.display = 'block';
        } else {
            noBpjsField.style.display = 'none';
        }
    }

    // Initial check for fields based on default role
    window.onload = toggleFields;
</script>
