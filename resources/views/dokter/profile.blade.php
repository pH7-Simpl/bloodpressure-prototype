@extends('layouts.appdokter')

@section('content')
<div class="container mx-auto mt-8">

    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Profile Dokter</h1>
        <!-- Update Profile Form -->
        <form action="{{ route('dokter.updateprofile') }}" method="POST" class="space-y-4">
            @csrf
            @method('POST')
            <div class="grid grid-cols-2 gap-4">
                <!-- Input Nama -->
                <div>
                    <label for="nama" class="block font-semibold">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $dokter->nama) }}"
                        class="w-full border-gray-300 rounded-md @error('nama') border-red-500 @enderror">
                    @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Input NIK -->
                <div>
                    <label for="nik" class="block font-semibold">NIK</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik', $dokter->nik) }}"
                        class="w-full border-gray-300 rounded-md @error('nik') border-red-500 @enderror">
                    @error('nik') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Input Tempat Lahir -->
                <div>
                    <label for="tempat_lahir" class="block font-semibold">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir"
                        value="{{ old('tempat_lahir', $dokter->tempat_lahir) }}"
                        class="w-full border-gray-300 rounded-md @error('tempat_lahir') border-red-500 @enderror">
                    @error('tempat_lahir') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Input Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir" class="block font-semibold">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $dokter->tanggal_lahir) }}"
                        class="w-full border-gray-300 rounded-md @error('tanggal_lahir') border-red-500 @enderror">
                    @error('tanggal_lahir') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label for="jenis_kelamin" class="block font-semibold">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="w-full border-gray-300 rounded-md">
                        <option value="Laki-laki" {{ old('jenis_kelamin', $dokter->jenis_kelamin) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $dokter->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="no_handphone" class="block font-semibold">Nomor Handphone</label>
                    <input type="text" name="no_handphone" id="no_handphone"
                        value="{{ old('no_handphone', $dokter->no_handphone) }}"
                        class="w-full border-gray-300 rounded-md">
                </div>                

                <div>
                    <label for="agama" class="block font-semibold">Agama</label>
                    <input type="text" name="agama" id="agama" value="{{ old('agama', $dokter->agama) }}"
                        class="w-full border-gray-300 rounded-md @error('agama') border-red-500 @enderror">
                    @error('agama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="golongan_darah" class="block font-semibold">Golongan Darah</label>
                    <input type="text" name="golongan_darah" id="golongan_darah"
                        value="{{ old('golongan_darah', $dokter->golongan_darah) }}"
                        class="w-full border-gray-300 rounded-md">
                </div>

                <!-- Input Email -->
                <div>
                    <label for="email" class="block font-semibold">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $dokter->email) }}"
                        class="w-full border-gray-300 rounded-md @error('email') border-red-500 @enderror">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Input Provinsi --}}
                <div>
                    <label for="provinsi" class="block font-semibold">Provinsi</label>
                    <input type="text" name="provinsi" id="provinsi" value="{{ old('provinsi', $dokter->provinsi) }}"
                        class="w-full border-gray-300 rounded-md">
                </div>
                {{-- Input Kabupaten Kota --}}
                <div>
                    <label for="kab_kota" class="block font-semibold">Kabupaten/Kota</label>
                    <input type="text" name="kab_kota" id="kab_kota" value="{{ old('kab_kota', $dokter->kab_kota) }}"
                        class="w-full border-gray-300 rounded-md">
                </div>
                {{-- Input Kecamatan --}}
                <div>
                    <label for="kecamatan" class="block font-semibold">Kecamatan</label>
                    <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', $dokter->kecamatan) }}"
                        class="w-full border-gray-300 rounded-md">
                </div>
                {{-- Input Alamat --}}
                <div>
                    <label for="alamat" class="block font-semibold">Alamat</label>
                    <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $dokter->alamat) }}"
                        class="w-full border-gray-300 rounded-md">
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block font-semibold">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full border-gray-300 rounded-md @error('password') border-red-500 @enderror">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <small class="text-gray-500">Kosongkan jika tidak ingin merubah password</small>
                </div>
            </div>

            <!-- Update Profile Button -->
            <div class="mt-6 flex items-center space-x-4">
                <!-- Tombol Ganti Password -->
                <button type="button" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600"
                    data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    Ganti Password
                </button>
                <!-- Tombol Update Profile -->
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Update Profile
                </button>
            </div>

            <!-- Modal untuk Ganti Password -->
            <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="changePasswordModalLabel">Ganti Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('dokter.updatepassword') }}" method="POST" id="changePasswordForm">
                                @csrf
                                @method('POST')
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control @error('current_password') is-invalid @enderror">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <input type="password" name="new_password" id="new_password"
                                        class="form-control @error('new_password') is-invalid @enderror">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password
                                        Baru</label>
                                    <input type="password" name="new_password_confirmation"
                                        id="new_password_confirmation"
                                        class="form-control @error('new_password_confirmation') is-invalid @enderror">
                                    @error('new_password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Ganti Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Delete Account Section -->
        <div class="mt-6 border-t pt-6">
            <h2 class="text-xl font-semibold text-red-600 mb-4">Delete Account</h2>
            <p class="text-gray-600 mb-4">Deleting your account is irreversible. Proceed with caution.</p>
            <form action="{{ route('dokter.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
                    onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                    Delete Account
                </button>
            </form>
        </div>
    </div>
</div>
@endsection