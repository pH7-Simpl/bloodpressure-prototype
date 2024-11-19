<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\BloodPressureReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Medicine;
use App\Models\Suggestion;
use App\Models\Appointment;
use App\Models\Pasien;
use Illuminate\Support\Facades\Log;
use App\Rules\UniqueAcrossTables;

class DokterController extends Controller
{
    public function showProfile()
    {
        $dokter = auth()->guard('dokter')->user(); // Assuming authenticated user is a Dokter

        return view('dokter.profile', compact('dokter'));
    }

    public function updateProfile(Request $request)
{
    $dokter = auth()->guard('dokter')->user();

    // Validate the request data
    $request->validate([
        'nama' => 'required|string|max:255',
        'nik' => [
            'required',
            'numeric',
            new UniqueAcrossTables(
                ['dokters', 'pasiens', 'kaders'],
                'nik',
                'dokters', // Current table
                $dokter->id // Current record ID
            ),
        ],
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
        'password' => 'nullable|string|min:8',
    ]);

    // Prepare the update data
    $updateData = $request->only([
        'nama',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'golongan_darah',
        'no_handphone',
        'alamat',
        'provinsi',
        'kab_kota',
        'kecamatan',
        'email',
    ]);

    // Hash and add the password if provided
    if ($request->filled('password')) {
        $updateData['password'] = bcrypt($request->password);
    }

    // Update the Dokter model
    $dokter->update($updateData);

    return redirect()->route('dokter.profile')->with('success', 'Profile updated successfully!');
}
public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    $dokter = auth()->guard('dokter')->user();

    // Periksa apakah password saat ini cocok
    if (!Hash::check($request->current_password, $dokter->password)) {
        return back()->withErrors(['current_password' => 'Password saat ini salah.']);
    }

    // Update password
    $dokter->update([
        'password' => bcrypt($request->new_password),
    ]);

    return back()->with('success', 'Password berhasil diubah!');
}

public function deleteAccount()
{
    $dokter = auth()->guard('dokter')->user();

    // Delete the authenticated doctor's account
    $dokter->delete();

    // Redirect to login or home page with a success message
    return redirect('/')->with('success', 'Your account has been deleted successfully.');
}

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

    public function dashboard()
    {
        return view('dokter.dashboard');
    }
    public function searchAssignedPatients(Request $request)
{
    $search = $request->query('search', '');
    $assignedPatients = Pasien::where('assigned_to_dokter', true)
        ->where('nama', 'like', "%{$search}%")
        ->get();

    return response()->json($assignedPatients);
}

public function searchUnassignedPatients(Request $request)
{
    $search = $request->query('search', '');
    $unassignedPatients = Pasien::where('assigned_to_dokter', false)
        ->where('nama', 'like', "%{$search}%")
        ->get();

    return response()->json($unassignedPatients);
}



    public function managePatients(Request $request)
    {
        $dokterId = auth()->user()->id;

        // Get the search queries for assigned and unassigned patients
        $assignedSearch = $request->input('assigned_search');
        $unassignedSearch = $request->input('unassigned_search');
        
        // Fetch assigned patients with pagination and search filter
        $assignedPatients = Pasien::where('dokter_id', $dokterId)
            ->when($assignedSearch, function ($query, $assignedSearch) {
                return $query->where('nama', 'like', "%{$assignedSearch}%");
            })
            ->paginate(10, ['*'], 'assigned_patients');
        // Fetch unassigned patients with pagination and search filter
        $unassignedPatients = Pasien::whereNull('dokter_id')
            ->when($unassignedSearch, function ($query, $unassignedSearch) {
                return $query->where('nama', 'like', "%{$unassignedSearch}%");
            })
            ->paginate(10, ['*'], 'unassigned_patients');
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

    public function viewBloodPressure()
    {
        $assignedPatients = auth()->guard('dokter')->user()->pasiens;

        // Return the view with patients data
        return view('dokter.blood_pressure_view', compact('assignedPatients'));
    }

    public function managePatientsMedicine(Request $request)
    {
        $dokterId = auth()->user()->id;

        // Ambil input pencarian dari request
        $search = $request->input('search');

        // Fetch patients yang diassign ke dokter dan filter berdasarkan nama jika ada input pencarian
        $pasiens = Pasien::where('dokter_id', $dokterId)
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%");
            })
            ->paginate(5);

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
    
    public function managePatientsSuggestions(Request $request)
    {
        $dokterId = auth()->user()->id;

        // Ambil input pencarian dari request
        $search = $request->input('search');

        // Fetch patients yang diassign ke dokter dan filter berdasarkan nama jika ada input pencarian
        $pasiens = Pasien::where('dokter_id', $dokterId)
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%");
            })
            ->paginate(5);

        return view('dokter.manage-patients-suggestions', compact('pasiens'));
    }

    // Add medicine to a specific patient
    public function viewAddSuggestions($id)
    {
        $pasien = Pasien::findOrFail($id); // Find the patient
        return view('dokter.add-suggestions', compact('pasien'));
    }

    public function viewSuggestions($patientId)
    {
        $pasien = Pasien::findOrFail($patientId);
        $suggestions = Suggestion::where('pasien_id', $pasien->id)->get();
        return view('dokter.managepatientspecificsuggestion', compact('pasien', 'suggestions'));
    }

    // Method to show the add medicine form
    public function addSuggestionsForm($patientId)
    {
        $pasien = Pasien::findOrFail($patientId);
        return view('dokter.add-suggestions', compact('pasien'));
    }

    // Method to store a new medicine
    public function storeSuggestions(Request $request, $patientId)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'suggestion_date' => 'required|date',
        ]);

        Suggestion::create([
            'dokter_id' => Auth::guard('dokter')->user()->id,
            'pasien_id' => $patientId,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'suggestion_date' => $validated['suggestion_date'],
        ]);

        return redirect()->route('dokter.managepatientspecificsuggestion', $patientId)->with('success', 'Suggestion added successfully.');
    }

    // Method to show the edit medicine form
    public function editSuggestionsForm($patientId, $suggestionId)
    {
        $pasien = Pasien::findOrFail($patientId);
        $suggestion = Suggestion::findOrFail($suggestionId);
        return view('dokter.edit-suggestions', compact('pasien', 'suggestion'));
    }

    // Method to update a medicine
    public function updateSuggestions(Request $request, $patientId, $suggestionId)
    {
        // Find the medicine by its ID
        $suggestion = Suggestion::findOrFail($suggestionId);

        // Validate the form data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'suggestion_date' => 'required|date',
        ]);

        // Update the medicine
        $suggestion->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'suggestion_date' => $validated['suggestion_date'],
        ]);

        // Redirect back to the manage patient medicine page
        return redirect()->route('dokter.managepatientspecificsuggestion', $patientId)->with('success', 'Suggestion updated successfully.');
    }

    // Method to delete a medicine
    public function deleteSuggestions($patientId, $suggestionId)
    {
        $suggestion = Suggestion::findOrFail($suggestionId);
        $suggestion->delete();

        return redirect()->route('dokter.managepatientspecificsuggestion', $patientId)->with('success', 'Suggestion deleted successfully.');
    }

    public function managePatientsAppointments(Request $request)
    {
        $dokterId = auth()->user()->id;

        // Ambil input pencarian dari request
        $search = $request->input('search');

        // Fetch patients yang diassign ke dokter dan filter berdasarkan nama jika ada input pencarian
        $pasiens = Pasien::where('dokter_id', $dokterId)
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%");
            })
            ->paginate(5);

        return view('dokter.manage-patients-appointments', compact('pasiens'));
    }

    // Add medicine to a specific patient
    public function viewAddAppointments($id)
    {
        $pasien = Pasien::findOrFail($id); // Find the patient
        return view('dokter.add-appointments', compact('pasien'));
    }

    public function viewAppointments($patientId)
    {
        $pasien = Pasien::findOrFail($patientId);
        $appointments = Appointment::where('pasien_id', $pasien->id)->get();
        return view('dokter.managepatientspecificappointment', compact('pasien', 'appointments'));
    }

    // Method to show the add medicine form
    public function addAppointmentsForm($patientId)
    {
        $pasien = Pasien::findOrFail($patientId);
        return view('dokter.add-appointments', compact('pasien'));
    }

    // Method to store a new medicine
    public function storeAppointments(Request $request, $patientId)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'appointment_date' => 'required|date',
            'appointment_time' => 'nullable|date_format:H:i',
        ]);

        Appointment::create([
            'dokter_id' => Auth::guard('dokter')->user()->id,
            'pasien_id' => $patientId,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
        ]);

        return redirect()->route('dokter.managepatientspecificappointment', $patientId)->with('success', 'Appointment added successfully.');
    }

    // Method to show the edit medicine form
    public function editAppointmentsForm($patientId, $appointmentId)
    {
        $pasien = Pasien::findOrFail($patientId);
        $appointment = Appointment::findOrFail($appointmentId);
        return view('dokter.edit-appointments', compact('pasien', 'appointment'));
    }

    // Method to update a medicine
    public function updateAppointments(Request $request, $patientId, $appointmentId)
    {
        // Find the medicine by its ID
        $appointment = Appointment::findOrFail($appointmentId);

        // Validate the form data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'appointment_date' => 'required|date',
            'appointment_time' => 'nullable|date_format:H:i',
        ]);

        // Update the medicine
        $appointment->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
        ]);

        // Redirect back to the manage patient medicine page
        return redirect()->route('dokter.managepatientspecificappointment', $patientId)->with('success', 'Appointment updated successfully.');
    }

    // Method to delete a medicine
    public function deleteAppointments($patientId, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->delete();

        return redirect()->route('dokter.managepatientspecificappointment', $patientId)->with('success', 'Appointment deleted successfully.');
    }
}
