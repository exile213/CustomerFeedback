<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Contacts - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-600 text-white p-6">
            <div class="flex items-center gap-2 mb-8">
                <i class="fas fa-chart-line text-2xl"></i>
                <h2 class="text-2xl font-bold">Dashboard</h2>
            </div>
            <nav>
                <ul class="space-y-4">
                    <li><a href="dashboard" class="flex items-center gap-3 text-white/90 hover:text-white p-2 rounded-lg hover:bg-white/10"><i class="fas fa-home w-5"></i><span>Dashboard</span></a></li>
                    <li><a href="customer-contacts" class="flex items-center gap-3 text-white p-2 rounded-lg bg-white/10"><i class="fas fa-address-book w-5"></i><span>Customer Contacts</span></a></li>
                    <li><a href="customer-feedback" class="flex items-center gap-3 text-white/90 hover:text-white p-2 rounded-lg hover:bg-white/10"><i class="fas fa-comments w-5"></i><span>Customer Feedback</span></a></li>
                    <li><a href="user-management" class="flex items-center gap-3 text-white/90 hover:text-white p-2 rounded-lg hover:bg-white/10"><i class="fas fa-users w-5"></i><span>User Management</span></a></li>
                    <li><a href="#" class="flex items-center gap-3 text-white/90 hover:text-white p-2 rounded-lg hover:bg-white/10"><i class="fas fa-cog w-5"></i><span>Settings</span></a></li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navigation bar -->
            <header class="bg-white border-b">
                <div class="flex justify-between items-center px-6 py-4">
                    <h1 class="text-xl font-semibold text-gray-800">Customer Contacts</h1>
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
                    <!-- Customer Contacts List -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Customer Contacts</h2>
                            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Add New Contact</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-2">John Doe</td>
                                        <td class="px-4 py-2">john@example.com</td>
                                        <td class="px-4 py-2">+1 234 567 8901</td>
                                        <td class="px-4 py-2">Acme Inc.</td>
                                        <td class="px-4 py-2">
                                            <button class="text-blue-600 hover:text-blue-800 mr-2">Edit</button>
                                            <button class="text-red-600 hover:text-red-800">Delete</button>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="px-4 py-2">Jane Smith</td>
                                        <td class="px-4 py-2">jane@example.com</td>
                                        <td class="px-4 py-2">+1 987 654 3210</td>
                                        <td class="px-4 py-2">XYZ Corp</td>
                                        <td class="px-4 py-2">
                                            <button class="text-blue-600 hover:text-blue-800 mr-2">Edit</button>
                                            <button class="text-red-600 hover:text-red-800">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2">Alice Johnson</td>
                                        <td class="px-4 py-2">alice@example.com</td>
                                        <td class="px-4 py-2">+1 555 123 4567</td>
                                        <td class="px-4 py-2">Tech Solutions</td>
                                        <td class="px-4 py-2">
                                            <button class="text-blue-600 hover:text-blue-800 mr-2">Edit</button>
                                            <button class="text-red-600 hover:text-red-800">Delete</button>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="px-4 py-2">Bob Wilson</td>
                                        <td class="px-4 py-2">bob@example.com</td>
                                        <td class="px-4 py-2">+1 777 888 9999</td>
                                        <td class="px-4 py-2">Global Enterprises</td>
                                        <td class="px-4 py-2">
                                            <button class="text-blue-600 hover:text-blue-800 mr-2">Edit</button>
                                            <button class="text-red-600 hover:text-red-800">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <div class="text-sm text-gray-500">
                                Showing 1 to 4 of 4 entries
                            </div>
                            <div class="flex gap-2">
                                <button class="px-3 py-1 border rounded text-sm" disabled>Previous</button>
                                <button class="px-3 py-1 border rounded text-sm bg-indigo-600 text-white">1</button>
                                <button class="px-3 py-1 border rounded text-sm" disabled>Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>

