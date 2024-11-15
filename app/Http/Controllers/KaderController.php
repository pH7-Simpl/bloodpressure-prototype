<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien; // Import Pasien model
use App\Models\BloodPressureReading;

class KaderController extends Controller
{

    public function editPatientBloodPressure($id)
{
    // Find the patient
    $patient = auth()->guard('kader')->user()->pasiens()->findOrFail($id);

    // Fetch all blood pressure readings for the patient
    $readings = $patient->bloodPressureReadings;

    // Return a view to display the dates
    return view('kader.blood_pressure_dates', compact('patient', 'readings'));
}

public function viewBloodPressure($id)
{
    // Fetch the specific blood pressure reading
    $reading = auth()->guard('kader')->user()->pasiens()
        ->with('bloodPressureReadings')
        ->whereHas('bloodPressureReadings', function ($query) use ($id) {
            $query->where('id', $id);
        })
        ->firstOrFail()
        ->bloodPressureReadings
        ->find($id);

    // Return a view to display the details
    return view('kader.blood_pressure_details', compact('reading'));
}

public function addBloodPressure(Pasien $patient)
{
    return view('kader.blood_pressure_add', compact('patient'));
}

public function storeBloodPressure(Request $request)
{
    $request->validate([
        'pasien_id' => 'required|exists:pasiens,id',
        'date' => 'required|date',
        'morning_value_systole' => 'nullable|integer|min:0',
        'morning_value_diastole' => 'nullable|integer|min:0',
        'afternoon_value_systole' => 'nullable|integer|min:0',
        'afternoon_value_diastole' => 'nullable|integer|min:0',
        'night_value_systole' => 'nullable|integer|min:0',
        'night_value_diastole' => 'nullable|integer|min:0',
    ]);

    BloodPressureReading::create($request->all());

    return redirect()->route('kader.editPatientBloodPressure', $request->pasien_id)->with('success', 'New blood pressure reading added.');
}

public function editBloodPressure($id)
{
    $reading = BloodPressureReading::findOrFail($id);
    return view('kader.blood_pressure_edit', compact('reading'));
}

public function updateBloodPressure(Request $request, $id)
{
    $request->validate([
        'morning_value_systole' => 'nullable|integer',
        'morning_value_diastole' => 'nullable|integer',
        'afternoon_value_systole' => 'nullable|integer',
        'afternoon_value_diastole' => 'nullable|integer',
        'night_value_systole' => 'nullable|integer',
        'night_value_diastole' => 'nullable|integer',
    ]);

    $reading = BloodPressureReading::findOrFail($id);
    $reading->update($request->all());

    return redirect()->route('kader.editPatientBloodPressure', $reading->pasien_id)
                     ->with('success', 'Blood pressure reading updated successfully.');
}

public function deleteBloodPressure($id)
{
    $reading = BloodPressureReading::findOrFail($id);
    $reading->delete();

    return redirect()->route('kader.editPatientBloodPressure', $reading->pasien_id)
                     ->with('success', 'Blood pressure reading deleted successfully.');
}

    public function dashboard() {
        $patients = auth()->guard('kader')->user()->pasiens;
    
        // Return the view with patients data
        return view('kader.dashboard', compact('patients'));
    }
}

