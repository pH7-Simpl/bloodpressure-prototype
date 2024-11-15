<h1 class="text-2xl font-bold">Edit Blood Pressure for {{ \Carbon\Carbon::parse($reading->date)->format('Y-m-d') }}</h1>

<form action="{{ route('kader.updateBloodPressure', $reading->id) }}" method="POST" class="mt-4">
    @csrf
    @method('PUT')

    <div>
        <label for="morning_value_systole">Morning Systole:</label>
        <input type="number" name="morning_value_systole" id="morning_value_systole" value="{{ $reading->morning_value_systole }}" class="border-gray-300 rounded">
    </div>
    <div>
        <label for="morning_value_diastole">Morning Diastole:</label>
        <input type="number" name="morning_value_diastole" id="morning_value_diastole" value="{{ $reading->morning_value_diastole }}" class="border-gray-300 rounded">
    </div>
    <div>
        <label for="afternoon_value_systole">Afternoon Systole:</label>
        <input type="number" name="afternoon_value_systole" id="afternoon_value_systole" value="{{ $reading->afternoon_value_systole }}" class="border-gray-300 rounded">
    </div>
    <div>
        <label for="afternoon_value_diastole">Afternoon Diastole:</label>
        <input type="number" name="afternoon_value_diastole" id="afternoon_value_diastole" value="{{ $reading->afternoon_value_diastole }}" class="border-gray-300 rounded">
    </div>
    <div>
        <label for="night_value_systole">Night Systole:</label>
        <input type="number" name="night_value_systole" id="night_value_systole" value="{{ $reading->night_value_systole }}" class="border-gray-300 rounded">
    </div>
    <div>
        <label for="night_value_diastole">Night Diastole:</label>
        <input type="number" name="night_value_diastole" id="night_value_diastole" value="{{ $reading->night_value_diastole }}" class="border-gray-300 rounded">
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Update</button>
</form>

<a href="{{ route('kader.editPatientBloodPressure', $reading->pasien_id) }}" class="text-gray-500 hover:underline mt-4 block">
    Back to Dates
</a>