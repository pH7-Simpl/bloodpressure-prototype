<h1 class="text-2xl font-bold">{{ $patient->nama }}'s Blood Pressure Readings</h1>

<ul class="mt-4">
    @foreach($readings as $reading)
        <li class="text-gray-800">
            <a href="{{ route('kader.viewBloodPressure', $reading->id) }}" class="text-blue-600 hover:underline">
                {{ \Carbon\Carbon::parse($reading->date)->format('Y-m-d') }}
            </a>
        </li>
    @endforeach
</ul>

<!-- Button to add a new reading -->
<a href="{{ route('kader.addBloodPressure', $patient->id) }}" class="mt-4 inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
    Add New Reading
</a>

<a href="{{ route('kader.dashboard') }}" class="text-gray-500 hover:underline mt-4 block">Back to Dashboard</a>
