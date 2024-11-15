<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Pasien;
use App\Models\BloodPressureReading;

class KaderController extends Controller
{
    // Show the form to edit a blood pressure record
    // app/Http/Controllers/KaderController.php
public function editRecord($id)
{
    // Fetch the patient's blood pressure record
    $reading = BloodPressureReading::findOrFail($id);
    return view('kader.editRecord', compact('reading'));
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
        $patients = Patient::where('kader_id', auth()->guard('kader')->user()->id)->get();

        // Return the view with patients data
        return view('kader.dashboard', compact('patients'));
    }
}
