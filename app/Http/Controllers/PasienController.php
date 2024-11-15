<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\BloodPressureReading;
use App\Models\Medicine;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
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
    public function home() {
        $pasien = Auth::guard('pasien')->user();
    
        // Retrieve the blood pressure readings for the Lansia user
        $readings = BloodPressureReading::where('pasien_id', $pasien->id)
            ->orderBy('date', 'desc') // Sort by most recent reading
            ->get();

        $medicines = Medicine::where('pasien_id', $pasien->id)
            ->orderBy('start_date', 'desc') // Sort by the most recent start date
            ->get();

        // Retrieve the appointments for the Lansia user
        $appointments = Appointment::where('pasien_id', $pasien->id)
            ->orderBy('appointment_date', 'asc') // Sort by the nearest appointment date
            ->get();

        // Pass the readings to the view
        return view('pasien.home', compact('readings', 'medicines', 'appointments'));
    }
}
