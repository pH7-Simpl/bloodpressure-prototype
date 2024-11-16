@extends('layouts.appdokter')

@section('content')
<div class="min-h-screen bg-cover bg-center flex justify-center items-center" style="background-image: url('{{ asset('images/rl.jpg') }}');">
    <div class="max-w-4xl mt-6 w-full bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">Medicines for {{ $pasien->nama }}</h1>

        @if($medicines->isEmpty())
            <p class="text-gray-600">No medicines prescribed yet.</p>
        @else
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Medicine</th>
                        <th class="px-4 py-2 text-left">Dosage</th>
                        <th class="px-4 py-2 text-left">Start Date</th>
                        <th class="px-4 py-2 text-left">End Date</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicines as $medicine)
                        <tr>
                            <td class="px-4 py-2">{{ $medicine->medicine_name }}</td>
                            <td class="px-4 py-2">{{ $medicine->dosage }}</td>
                            <td class="px-4 py-2">{{ $medicine->start_date }}</td>
                            <td class="px-4 py-2">{{ $medicine->end_date ?? 'N/A' }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('dokter.editMedicineForm', [$pasien->id, $medicine->id]) }}" class="text-blue-500 hover:underline">Edit</a> |
                                <form action="{{ route('dokter.deleteMedicine', [$pasien->id, $medicine->id]) }}" method="POST" class="inline" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="mt-6 flex justify-between">
            <a href="{{ route('dokter.addMedicineForm', $pasien->id) }}" class="text-green-500 hover:underline">Add Medicine</a>
            <a href="{{ route('dokter.managePatientsMedicine') }}" class="text-blue-500 hover:underline">Back to Managed Patients Medicine</a>
        </div>
    </div>
</div>
<script>
    function confirmDelete() {
        // Display a confirmation dialog
        return confirm('Are you sure you want to delete this medicine?');
    }
</script>
@endsection
