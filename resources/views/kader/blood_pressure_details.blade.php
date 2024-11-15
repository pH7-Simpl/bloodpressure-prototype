<h1 class="text-2xl font-bold">Blood Pressure Details for {{ \Carbon\Carbon::parse($reading->date)->format('Y-m-d') }}</h1>
<ul class="mt-4">
    <li>
        Morning: 
        @if($reading->morning_value_systole === null && $reading->morning_value_diastole === null)
            No Records
        @else
            {{ $reading->morning_value_systole ?? 'N/A' }}/{{ $reading->morning_value_diastole ?? 'N/A' }}
        @endif
    </li>
    <li>
        Afternoon: 
        @if($reading->afternoon_value_systole === null && $reading->afternoon_value_diastole === null)
            No Records
        @else
            {{ $reading->afternoon_value_systole ?? 'N/A' }}/{{ $reading->afternoon_value_diastole ?? 'N/A' }}
        @endif
    </li>
    <li>
        Night: 
        @if($reading->night_value_systole === null && $reading->night_value_diastole === null)
            No Records
        @else
            {{ $reading->night_value_systole ?? 'N/A' }}/{{ $reading->night_value_diastole ?? 'N/A' }}
        @endif
    </li>
</ul>

<div class="mt-4 flex gap-4">
    <a href="{{ route('kader.editBloodPressure', $reading->id) }}" class="text-blue-600 hover:underline">Edit</a>

    <form action="{{ route('kader.deleteBloodPressure', $reading->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:underline">Delete</button>
    </form>
</div>

<a href="{{ route('kader.editPatientBloodPressure', $reading->pasien_id) }}" class="text-gray-500 hover:underline mt-4 block">
    Back to Dates
</a>
<a href="{{ route('kader.dashboard') }}" class="text-gray-500 hover:underline mt-4 block">Back to Dashboard</a>
