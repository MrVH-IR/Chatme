<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-4 text-center">Register</h1>
        <form action="/api/register" method="POST" id="registerForm">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">First Name</label>
                <input type="text" id="name" name="name" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label for="lastname" class="block text-sm font-medium">Last Name</label>
                <input type="text" id="lastname" name="lastname" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" id="email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input type="password" id="password" name="password" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Register</button>
        </form>
    </div>
</body>

</html>
