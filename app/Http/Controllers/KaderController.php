<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien; // Import Pasien model
use App\Models\BloodPressureReading;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;

class KaderController extends Controller
{
    public function showProfile()
    {
        $kader = auth()->guard('kader')->user(); // Assuming authenticated user is a Dokter

        return view('kader.profile', compact('kader'));
    }

    public function updateProfile(Request $request)
{
    $kader = auth()->guard('kader')->user();

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
    ]);

    // Update the Dokter model with the validated data
    $kader->update($request->all());

    // If a new password is provided, hash it before updating
    if ($request->filled('password')) {
        $kader->password = bcrypt($request->password);
        $kader->save();
    }

    return redirect()->route('kader.profile')->with('success', 'Profile updated successfully!');
}
public function deleteAccount()
{
    $kader = auth()->guard('kader')->user();

    // Delete the authenticated kader's account
    $kader->delete();

    // Redirect to login or home page with a success message
    return redirect('/')->with('success', 'Your account has been deleted successfully.');
}

    public function editPatientBloodPressure($id)
{
    // Find the patient
    $patient = auth()->guard('kader')->user()->pasiens()->findOrFail($id);

    // Fetch all blood pressure readings for the patient
    $readings = $patient->bloodPressureReadings()->orderBy('date', 'asc')->get();

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

public function nameSearch(Request $request)
{
    $search = $request->get('search');

    if ($search) {
        $unassignedPatients = Pasien::whereNull('kader_id')
            ->where('nama', 'LIKE', '%' . $search . '%')
            ->paginate(10, ['*'], 'unassigned_patients'); // Paginate results based on search
    } else {
        $unassignedPatients = Pasien::whereNull('kader_id')->paginate(10, ['*'], 'unassigned_patients'); // Default to pagination without search
    }

    return view('kader.dashboard', compact('unassignedPatients'));
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

public function dashboard(Request $request) {
    $kaderId = auth()->user()->id;
    $assignedSearch = $request->input('assigned_search');
    $search = $request->get('search');
    if ($search) {
        $unassignedPatients = Pasien::whereNull('kader_id')
            ->where('nama', 'LIKE', '%' . $search . '%')
            ->paginate(10, ['*'], 'unassigned_patients');
    } else {
        $unassignedPatients = Pasien::whereNull('kader_id')->paginate(10, ['*'], 'unassigned_patients');
    }

    // Fetch supervised patients for Edit Blood Pressure Readings
    $assignedPatients = Pasien::where('kader_id', $kaderId)
            ->when($assignedSearch, function ($query, $assignedSearch) {
                return $query->where('nama', 'like', "%{$assignedSearch}%");
            })
            ->paginate(10, ['*'], 'assigned_patients');
    $allAssignedPatients = Pasien::where('kader_id', $kaderId)->get();

    return view('kader.dashboard', compact('allAssignedPatients', 'unassignedPatients', 'assignedPatients', 'unassignedPatients', 'assignedSearch'));
}
}

