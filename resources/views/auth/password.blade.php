<form method="POST" action="{{ route('authenticate') }}">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    <input type="hidden" name="role" value="{{ $role }}">
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Authenticate</button>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</form>