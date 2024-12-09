<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CRM System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
        .shapes {
            position: absolute;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .shape {
            position: absolute;
            background: rgba(255, 156, 118, 0.4);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            transform: rotate(-25deg);
        }
        .shape-1 {
            height: 150px;
            width: 150px;
            top: 20%;
            left: 10%;
            animation: float 6s ease-in-out infinite;
        }
        .shape-2 {
            height: 100px;
            width: 100px;
            top: 60%;
            left: 30%;
            animation: float 8s ease-in-out infinite;
        }
        .shape-3 {
            height: 200px;
            width: 200px;
            top: 40%;
            right: 20%;
            animation: float 7s ease-in-out infinite;
        }
        @keyframes float {
            0% {
                transform: translateY(0) rotate(-25deg);
            }
            50% {
                transform: translateY(-20px) rotate(-25deg);
            }
            100% {
                transform: translateY(0) rotate(-25deg);
            }
        }
        .parallax-container {
            perspective: 1000px;
        }
        .parallax-card {
            transform-style: preserve-3d;
        }
    </style>

</head>
<body class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 min-h-screen flex items-center justify-center p-4">
<div class="shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
</div>
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