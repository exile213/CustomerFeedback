<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CRM System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-400 via-pink-100 to-blue-200 flex items-center justify-center p-4">
    <div class="bg-white/80 backdrop-blur-sm w-full max-w-md rounded-3xl p-8 shadow-xl">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-500 bg-clip-text text-transparent">
                Welcome back!
            </h1>
            <p class="text-gray-500 mt-2">Please sign in to continue</p>
        </div>

        <form class="space-y-6" method="POST" action="login">
            <div class="space-y-2">
                <label for="email" class="text-sm font-medium text-gray-600 block">Email</label>
                <div class="relative">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring focus:ring-purple-100 transition-all outline-none"
                        placeholder="Enter your email"
                    >
                </div>
            </div>

            <div class="space-y-2">
                <label for="password" class="text-sm font-medium text-gray-600 block">Password</label>
                <div class="relative">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring focus:ring-purple-100 transition-all outline-none"
                        placeholder="Enter your password"
                    >
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center space-x-2">
                    <input
                        type="checkbox"
                        name="remember-me"
                        class="w-4 h-4 rounded border-gray-300 text-purple-500 focus:ring-purple-400"
                    >
                    <span class="text-sm text-gray-500">Remember me</span>
                </label>
            </div>

            <button
                type="submit"
                class="w-full bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white font-semibold py-3 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg"
            >
                Sign in
            </button>
        </form>
    </div>
</body>
</html>