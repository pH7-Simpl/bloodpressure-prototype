@extends('layouts.appkader')

@section('content')
<div class="flex justify-center items-center min-h-screen">

    <!-- Kotak putih dengan padding dan sudut melengkung -->
    <div class="bg-white p-6 rounded-lg shadow-lg w-full sm:w-3/4 lg:w-1/3">

        <h1 class="text-2xl font-bold mb-4">{{ $patient->nama }}'s Blood Pressure Readings</h1>

        <!-- Menampilkan hasil pembacaan tekanan darah berdasarkan filter -->
        <ul class="mt-4">
            @foreach($readings as $reading)
                <li class="text-gray-800">
                    <a href="{{ route('kader.viewBloodPressure', $reading->id) }}" class="text-blue-600 hover:underline">
                        {{ \Carbon\Carbon::parse($reading->date)->format('Y-m-d') }}
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Button untuk menambah pembacaan tekanan darah baru -->
        <a href="{{ route('kader.addBloodPressure', $patient->id) }}" class="mt-4 inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
            Add New Reading
        </a>

        <!-- Tombol kembali ke Dashboard -->
        <a href="{{ route('kader.dashboard') }}" class="text-gray-500 hover:underline mt-4 block">
            Back to Dashboard
        </a>
        
    </div>
</div>
@endsection
