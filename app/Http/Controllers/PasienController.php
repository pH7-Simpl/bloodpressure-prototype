<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\BloodPressureReading;
use App\Models\Medicine;
use App\Models\Appointment;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    public function showProfile()
    {
        $pasien = auth()->guard('pasien')->user(); // Assuming authenticated user is a Dokter

        return view('pasien.profile', compact('pasien'));
    }

    public function updateProfile(Request $request)
{
    $pasien = auth()->guard('pasien')->user();

    // Validate the request data
    $request->validate([
        'nama' => 'required|string|max:255',
        'nik' => 'required|numeric',
        'tempat_lahir' => 'required|string',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'agama' => 'required|string',
        'golongan_darah' => 'required|string',
        'no_handphone' => 'required|string',
        'alamat' => 'required|string',
        'provinsi' => 'required|string',
        'kab_kota' => 'required|string',
        'kecamatan' => 'required|string',
        'email' => 'required|email',
        'password' => 'nullable|string|min:8|confirmed',
        'kategori_pasien' => 'required|in:Umum,BPJS',
        'no_bpjs' => 'required|string',
    ]);

    // Update the Dokter model with the validated data
    $pasien->update($request->all());

    return redirect()->route('pasien.profile')->with('success', 'Profile updated successfully!');
}
    public function showBloodPressureData($patient_id)
    {
        // Fetch blood pressure readings for the specific patient
        $readings = BloodPressureReading::where('patient_id', $patient_id)->get();

        // If no readings are found, redirect with a message
        if ($readings->isEmpty()) {
            return redirect()->route('pasien.dashboard')->with('error', 'No blood pressure readings available.');
        }

        // Pass the readings to the view
        return view('pasien.blood_pressure_data', compact('readings'));
    }
    public function home()
    {
        $pasien = Auth::guard('pasien')->user();

        // Retrieve the blood pressure readings for the patient
        $readings = BloodPressureReading::where('pasien_id', $pasien->id)
            ->orderBy('date', 'asc') // Sort by most recent reading
            ->get();

        // Retrieve the medicines for the patient and filter out expired ones
        $medicines = Medicine::where('pasien_id', $pasien->id)
            ->where(function ($query) {
                $query->where('end_date', '>=', now()) // Only include medicines where end date is in the future or not set
                    ->orWhereNull('end_date');
            })
            ->orderBy('start_date', 'asc') // Sort by the most recent start date
            ->get();

        // Retrieve the appointments for the patient and filter out expired ones
        $appointments = Appointment::where('pasien_id', $pasien->id)
            ->where('appointment_date', '>=', now()) // Only include appointments where appointment date is in the future
            ->orderBy('appointment_date', 'asc') // Sort by the nearest appointment date
            ->get();

        $suggestions = Suggestion::where('pasien_id', $pasien->id)
            ->orderBy('suggestion_date', 'asc')
            ->get();

        $kader = $pasien->kader;

        return view('pasien.home', compact('readings', 'medicines', 'appointments', 'suggestions', 'kader'));
    }
}
