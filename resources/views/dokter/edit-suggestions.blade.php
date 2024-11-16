@extends('layouts.appdokter')

@section('content')
<div class="min-h-screen bg-cover bg-center flex justify-center items-center bg-no-repeat" style="background-image: url('{{ asset('images/rl.jpg') }}');">
    <div class="max-w-4xl mt-6 w-full bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">Edit Suggestion for {{ $pasien->nama }}</h1>

        <!-- Edit Medicine Form -->
        <form action="{{ route('dokter.updateSuggestions', ['patientId' => $pasien->id, 'suggestionId' => $suggestion->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="suggestion_date" class="block text-lg font-medium text-gray-700">Suggestion Date</label>
                <input type="date" id="suggestion_date" name="suggestion_date" value="{{ old('suggestion_date', $suggestion->suggestion_date) }}" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
            </div>

            <div class="mb-4">
                <label for="title" class="block text-lg font-medium text-gray-700">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $suggestion->title) }}" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
            </div>

            <div class="mb-4">
                <label for="content" class="block text-lg font-medium text-gray-700">Content</label>
                <input type="text" id="content" name="content" value="{{ old('content', $suggestion->content) }}" class="mt-1 p-2 border border-gray-300 rounded w-full" required>
            </div>


            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Update Suggestion</button>
                <a href="{{ route('dokter.managepatientspecificsuggestion', $pasien->id) }}" class="text-red-500 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
