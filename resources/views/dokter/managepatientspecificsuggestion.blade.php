@extends('layouts.appdokter')

@section('content')
<div class="min-h-screen bg-cover bg-center flex justify-center items-center" style="background-image: url('{{ asset('images/rl.jpg') }}');">
    <div class="max-w-4xl mt-6 w-full bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">Suggestions for {{ $pasien->nama }}</h1>

        @if($suggestions->isEmpty())
            <p class="text-gray-600">No Suggestion made yet.</p>
        @else
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Suggestion Date</th>
                        <th class="px-4 py-2 text-left">Suggestion</th>
                        <th class="px-4 py-2 text-left">Content</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suggestions as $suggestion)
                        <tr>
                            <td class="px-4 py-2">{{ $suggestion->suggestion_date }}</td>
                            <td class="px-4 py-2">{{ $suggestion->title }}</td>
                            <td class="px-4 py-2">{{ $suggestion->content }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('dokter.editSuggestionsForm', [$pasien->id, $suggestion->id]) }}" class="text-blue-500 hover:underline">Edit</a> |
                                <form action="{{ route('dokter.deleteSuggestions', [$pasien->id, $suggestion->id]) }}" method="POST" class="inline" onsubmit="return confirmDelete()">
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
            <a href="{{ route('dokter.addSuggestionsForm', $pasien->id) }}" class="text-green-500 hover:underline">Add Suggestion</a>
            <a href="{{ route('dokter.managePatientsSuggestions') }}" class="text-blue-500 hover:underline">Back to Managed Patients Suggestions</a>
        </div>
    </div>
</div>
<script>
    function confirmDelete() {
        // Display a confirmation dialog
        return confirm('Are you sure you want to delete this suggestion?');
    }
</script>
@endsection
