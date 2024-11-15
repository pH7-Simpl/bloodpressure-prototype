<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authenticate</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #1a202c; /* Dark background */
            color: #fff; /* Text color for contrast */
            font-family: Arial, sans-serif;
        }

        .auth-container {
            background: #2d3748; /* Slightly lighter dark background */
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        input[type="password"], button {
            width: 80%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            border: none;
            font-size: 1rem;
        }

        input[type="password"] {
            background: #edf2f7;
            color: #2d3748;
        }

        button {
            background: #4a90e2;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background: #357abd;
        }

        .alert-danger {
            background: #e53e3e;
            color: #fff;
            padding: 1rem;
            margin-top: 1rem;
            border-radius: 5px;
        }

        .alert-danger ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h1 class="text-lg font-bold">Authenticate</h1>
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
    </div>
</body>
</html>
