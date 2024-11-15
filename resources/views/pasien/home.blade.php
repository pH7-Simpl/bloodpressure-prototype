<div class="container">
    <h1>Welcome, {{ Auth::guard('pasien')->user()->nama }} to Pasien Dashboard</h1>
    <p>Here, you can view your blood pressure readings and other information.</p>
    <!-- You can add more features as required -->
</div>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>