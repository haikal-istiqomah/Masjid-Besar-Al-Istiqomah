<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4 text-center">Login Admin</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-600 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" required class="w-full border rounded px-3 py-2">
            </div>

            <button class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
                Login
            </button>
        </form>
    </div>

</body>
</html>
