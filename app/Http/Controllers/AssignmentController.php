<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

class AssignmentController extends Controller
{
    public function getAssignmentStats()
    {
        $totalPatients = Pasien::count();

        $kaderAssigned = Pasien::whereNotNull('kader_id')->count();
        $dokterAssigned = Pasien::whereNotNull('dokter_id')->count();

        $kaderPercentage = $totalPatients > 0 ? ($kaderAssigned / $totalPatients) * 100 : 0;
        $dokterPercentage = $totalPatients > 0 ? ($dokterAssigned / $totalPatients) * 100 : 0;

        return response()->json([
            'kader' => [
                'assigned' => $kaderAssigned,
                'total' => $totalPatients,
                'percentage' => $kaderPercentage,
            ],
            'dokter' => [
                'assigned' => $dokterAssigned,
                'total' => $totalPatients,
                'percentage' => $dokterPercentage,
            ],
        ]);
    }
}
