<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien; // Import Pasien model
use App\Models\BloodPressureReading;
use Illuminate\Support\Facades\Auth;

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
public function getBloodPressureData($patientId)
{
    
    $readings = BloodPressureReading::where('pasien_id', $patientId)
                ->orderBy('date', 'asc')
                ->get(['date', 'morning_value_systole', 'morning_value_diastole', 'afternoon_value_systole', 'afternoon_value_diastole', 'night_value_systole', 'night_value_diastole']);
    
    return response()->json($readings);
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

public function addPatientToKader($patient_id)
    {
        // Find the patient by ID
        $patient = Pasien::findOrFail($patient_id);

        // Ensure the patient is not already assigned to a kader
        if ($patient->kader_id === null) {
            // Assign the patient to the current logged-in kader
            $patient->kader_id = Auth::guard('kader')->user()->id;
            $patient->save();

            return redirect()->route('kader.dashboard')->with('success', 'Patient added to your supervision.');
        }

        return redirect()->route('kader.dashboard')->with('error', 'This patient is already assigned to another kader.');
    }

    public function unassignPatient($patient_id)
{
    // Find the patient by ID
    $patient = Pasien::findOrFail($patient_id);

    // Check if the patient is assigned to the current logged-in kader
    if ($patient->kader_id == Auth::guard('kader')->user()->id) {
        // Unassign the patient from the current kader
        $patient->kader_id = null;
        $patient->save();

        return redirect()->route('kader.dashboard')->with('success', 'Patient has been unassigned from your supervision.');
    }

    return redirect()->route('kader.dashboard')->with('error', 'You do not have permission to unassign this patient.');
}

    public function dashboard() {
        $unassignedPatients  = Pasien::whereNull('kader_id')->get();
        $supervisedPatients  = auth()->guard('kader')->user()->pasiens;
    
        // Return the view with patients data
        return view('kader.dashboard', compact('supervisedPatients', 'unassignedPatients'));
    }
}

