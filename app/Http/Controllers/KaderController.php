<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien; // Import Pasien model
use App\Models\BloodPressureReading;

class KaderController extends Controller
{
    // Show the form to edit a blood pressure record
    public function editRecord($id)
    {
        // Fetch the blood pressure reading for the specific Pasien
        $reading = BloodPressureReading::findOrFail($id); // Find the blood pressure record by ID
        $pasien = $reading->pasien; // Get the related Pasien model

        return view('kader.edit-record', compact('reading', 'pasien')); // Pass both the reading and Pasien to the view
    }

    // Update the patient's blood pressure record
    public function updateRecord(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'morning_value' => 'required|numeric',
            'afternoon_value' => 'required|numeric',
            'night_value' => 'required|numeric',
        ]);

        // Find the record and update it
        $reading = BloodPressureReading::findOrFail($id);
        $reading->morning_value = $request->morning_value;
        $reading->afternoon_value = $request->afternoon_value;
        $reading->night_value = $request->night_value;
        $reading->save();

        return redirect()->route('kader.dashboard')->with('success', 'Record updated successfully');
    }

    public function dashboard() {
        $patients = auth()->guard('kader')->user()->pasiens;
    
        // Return the view with patients data
        return view('kader.dashboard', compact('patients'));
    }
}

