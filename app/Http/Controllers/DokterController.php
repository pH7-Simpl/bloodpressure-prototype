<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
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

    public function viewMedicines($pasienId)
    {
        // Retrieve all medicines for the given pasien
        $medicines = Medicine::where('pasien_id', $pasienId)->get();
        return view('dokter.medicines', compact('medicines'));
    }

    public function dashboard() {
        return view('dokter.dashboard');
    }
}
