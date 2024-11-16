<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\BloodPressureReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Medicine;
use App\Models\Pasien;

class DokterController extends Controller
{
    public function prescribeMedicine(Request $request, $pasienId)
    {
        // Validate the incoming request data
        $request->validate([
            'medicine_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        // Create new medicine record
        Medicine::create([
            'dokter_id' => auth()->user()->id, // The authenticated Dokter ID
            'pasien_id' => $pasienId,
            'medicine_name' => $request->medicine_name,
            'dosage' => $request->dosage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->back()->with('success', 'Medicine prescribed successfully');
    }

    public function dashboard() {
        return view('dokter.dashboard');
    }

    public function managePatients(Request $request)
{
    $dokterId = auth()->user()->id;

    // Get the search queries for assigned and unassigned patients
    $assignedSearch = $request->input('assigned_search');
    $unassignedSearch = $request->input('unassigned_search');

    // Fetch assigned patients with pagination and search filter
    $assignedPatients = Pasien::where('dokter_id', $dokterId)
                                ->when($assignedSearch, function($query, $assignedSearch) {
                                    return $query->where('nama', 'like', "%{$assignedSearch}%");
                                })
                                ->paginate(10); // Pagination, 10 patients per page

    // Fetch unassigned patients with pagination and search filter
    $unassignedPatients = Pasien::whereNull('dokter_id')
                                ->when($unassignedSearch, function($query, $unassignedSearch) {
                                    return $query->where('nama', 'like', "%{$unassignedSearch}%");
                                })
                                ->paginate(10); // Pagination, 10 patients per page

    return view('dokter.manage-patients', compact('assignedPatients', 'unassignedPatients', 'assignedSearch', 'unassignedSearch'));
}


    public function addPatient($id)
    {
        $patient = Pasien::findOrFail($id);

        // Assign the logged-in dokter
        $patient->dokter_id = auth()->user()->id;
        $patient->save();

        return redirect()->route('dokter.managePatients')->with('success', 'Patient assigned successfully.');
    }

    public function removePatient($id)
    {
        $patient = Pasien::findOrFail($id);

        // Unassign the dokter
        $patient->dokter_id = null;
        $patient->save();

        return redirect()->route('dokter.managePatients')->with('success', 'Patient unassigned successfully.');
    }
    public function getBloodPressureData($patientId)
{
    
    $readings = BloodPressureReading::where('pasien_id', $patientId)
                ->orderBy('date', 'asc')
                ->get(['date', 'morning_value_systole', 'morning_value_diastole', 'afternoon_value_systole', 'afternoon_value_diastole', 'night_value_systole', 'night_value_diastole']);
    
    return response()->json($readings);
}

public function viewBloodPressure() {
    $assignedPatients  = auth()->guard('dokter')->user()->pasiens;
    
        // Return the view with patients data
        return view('dokter.blood_pressure_view', compact('assignedPatients'));
}

    public function managePatientsMedicine()
    {
        // Fetch patients managed by the logged-in doctor
        $pasiens = Pasien::where('dokter_id', auth()->user()->id)->get();

        return view('dokter.manage-patients-medicine', compact('pasiens'));
    }

    // Add medicine to a specific patient
    public function viewAddMedicine($id)
    {
        $pasien = Pasien::findOrFail($id); // Find the patient
        return view('dokter.add-medicine', compact('pasien'));
    }

    public function viewMedicines($patientId)
    {
        $pasien = Pasien::findOrFail($patientId);
        $medicines = Medicine::where('pasien_id', $pasien->id)->get();
        return view('dokter.managepatientspecificmedicine', compact('pasien', 'medicines'));
    }

    // Method to show the add medicine form
    public function addMedicineForm($patientId)
    {
        $pasien = Pasien::findOrFail($patientId);
        return view('dokter.add-medicine', compact('pasien'));
    }

    // Method to store a new medicine
    public function storeMedicine(Request $request, $patientId)
    {
        $validated = $request->validate([
            'medicine_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        Medicine::create([
            'dokter_id' => Auth::guard('dokter')->user()->id,
            'pasien_id' => $patientId,
            'medicine_name' => $validated['medicine_name'],
            'dosage' => $validated['dosage'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        return redirect()->route('dokter.managepatientspecificmedicine', $patientId)->with('success', 'Medicine added successfully.');
    }

    // Method to show the edit medicine form
    public function editMedicineForm($patientId, $medicineId)
    {
        $pasien = Pasien::findOrFail($patientId);
        $medicine = Medicine::findOrFail($medicineId);
        return view('dokter.edit-medicine', compact('pasien', 'medicine'));
    }

    // Method to update a medicine
    public function updateMedicine(Request $request, $patientId, $medicineId)
{
    // Find the medicine by its ID
    $medicine = Medicine::findOrFail($medicineId);

    // Validate the form data
    $validated = $request->validate([
        'medicine_name' => 'required|string|max:255',
        'dosage' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ]);

    // Update the medicine
    $medicine->update([
        'medicine_name' => $validated['medicine_name'],
        'dosage' => $validated['dosage'],
        'start_date' => $validated['start_date'],
        'end_date' => $validated['end_date'],
    ]);

    // Redirect back to the manage patient medicine page
    return redirect()->route('dokter.managepatientspecificmedicine', $patientId)->with('success', 'Medicine updated successfully.');
}

    // Method to delete a medicine
    public function deleteMedicine($patientId, $medicineId)
    {
        $medicine = Medicine::findOrFail($medicineId);
        $medicine->delete();

        return redirect()->route('dokter.managepatientspecificmedicine', $patientId)->with('success', 'Medicine deleted successfully.');
    }
}
