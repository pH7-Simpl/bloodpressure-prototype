@extends('layouts.appdokter')

@section('content')
<div class="min-h-screen bg-cover bg-center flex justify-center items-center" style="background-image: url('{{ asset('images/rl.jpg') }}');">
    <div class="max-w-4xl mt-6 w-full bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">Add Suggestion for {{ $pasien->nama }}</h1>

        <form action="{{ route('dokter.storeSuggestions', $pasien->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="suggestion_date" class="block text-gray-700">Suggestion Date</label>
                <input type="date" id="suggestion_date" name="suggestion_date" class="w-full border border-gray-300 p-2" required>
            </div>
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Suggestion Title</label>
                <input type="text" id="title" name="title" class="w-full border border-gray-300 p-2" required>
            </div>
            <div class="mb-4">
                <label for="content" class="block text-gray-700">Content</label>
                <input type="text" id="content" name="content" class="w-full border border-gray-300 p-2" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Suggestion</button>
        </form>
    </div>
</div>
@endsection
