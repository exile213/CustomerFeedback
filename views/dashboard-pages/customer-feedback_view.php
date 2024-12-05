<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
    <?php require "views/Partials/sidebar.php"?>
    
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navigation bar -->
            <header class="bg-indigo-500 border-b">
                <div class="flex justify-between items-center px-6 py-4">
                    <h1 class="text-xl font-semibold text-gray-800">Customer Feedback</h1>
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="pl-8 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Sign out</button>
                    </div>
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                <div class="max-w-7xl mx-auto">
                    <!-- Feedback Summary -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-semibold mb-4">Feedback Summary</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-indigo-100 p-4 rounded-lg">
                                <h3 class="text-indigo-800 font-semibold">Average Rating</h3>
                                <p class="text-3xl font-bold text-indigo-600">4.5</p>
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                            <div class="bg-green-100 p-4 rounded-lg">
                                <h3 class="text-green-800 font-semibold">Total Reviews</h3>
                                <p class="text-3xl font-bold text-green-600">1,234</p>
                            </div>
                            <div class="bg-yellow-100 p-4 rounded-lg">
                                <h3 class="text-yellow-800 font-semibold">Positive Feedback</h3>
                                <p class="text-3xl font-bold text-yellow-600">85%</p>
                            </div>
                            <div class="bg-red-100 p-4 rounded-lg">
                                <h3 class="text-red-800 font-semibold">Negative Feedback</h3>
                                <p class="text-3xl font-bold text-red-600">15%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Feedback List -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold mb-4">Recent Feedback</h2>
                        <div class="space-y-6">
                            <!-- Feedback Item 1 -->
                            <div class="border-b pb-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="font-sem
