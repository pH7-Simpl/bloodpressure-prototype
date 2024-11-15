<x-guest-layout>
    <form method="POST" action="{{ route('customregister') }}">
        @csrf
        <select name="role">
            <option value="dokter">Dokter</option>
            <option value="kader">Kader</option>
            <option value="pasien">Pasien</option>
        </select>

        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="nik" placeholder="NIK" required>
        <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" required>
        <input type="date" name="tanggal_lahir" placeholder="Tanggal Lahir" required>
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <select name="jenis_kelamin" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
        <input type="text" name="agama" placeholder="Agama" required>
        <input type="text" name="golongan_darah" placeholder="Golongan Darah" required>
        <input type="text" name="no_hp" placeholder="No. Handphone" required>
        <input type="text" name="alamat" placeholder="Alamat" required>
        <input type="text" name="provinsi" placeholder="Provinsi" required>
        <input type="text" name="kabupaten_kota" placeholder="Kab/Kota" required>
        <input type="text" name="kecamatan" placeholder="Kecamatan" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

        <button type="submit">Register</button>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</x-guest-layout>
