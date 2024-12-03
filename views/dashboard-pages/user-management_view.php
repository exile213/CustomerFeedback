<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin Dashboard</title>
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
                    <li><a href="customer-contacts" class="flex items-center gap-3 text-white/90 hover:text-white p-2 rounded-lg hover:bg-white/10"> <i class="fas fa-address-book w-5"></i><span>Customer Contacts</span></a></li>
                    <li><a href="customer-feedback" class="flex items-center gap-3 text-white/90 hover:text-white p-2 rounded-lg hover:bg-white/10"><i class="fas fa-comments w-5"></i><span>Customer Feedback</span></a></li>
                    <li><a href="user_management" class="flex items-center gap-3 text-white p-2 rounded-lg bg-white/10"><i class="fas fa-users w-5"></i><span>User Management</span></a></li>
                    <li><a href="#" class="flex items-center gap-3 text-white/90 hover:text-white p-2 rounded-lg hover:bg-white/10"><i class="fas fa-cog w-5"></i><span>Settings</span></a></li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navigation bar -->
            <header class="bg-white border-b">
                <div class="flex justify-between items-center px-6 py-4">
                    <h1 class="text-xl font-semibold text-gray-800">User Management</h1>
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="pl-8 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <form method="post" class="inline">
                            <button type="submit" name="logout" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Sign out</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                <div class="max-w-7xl mx-auto">
                    <!-- User Management Content -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-semibold mb-4">User List</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Sample user rows -->
                                    <tr>
                                        <td class="px-4 py-2">John Doe</td>
                                        <td class="px-4 py-2">john@example.com</td>
                                        <td class="px-4 py-2">Admin</td>
                                        <td class="px-4 py-2"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span></td>
                                        <td class="px-4 py-2">
                                            <button class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                            <button class="ml-2 text-red-600 hover:text-red-900">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2">Jane Smith</td>
                                        <td class="px-4 py-2">jane@example.com</td>
                                        <td class="px-4 py-2">User</td>
                                        <td class="px-4 py-2"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span></td>
                                        <td class="px-4 py-2">
                                            <button class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                            <button class="ml-2 text-red-600 hover:text-red-900">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Add New User Form -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold mb-4">Add New User</h2>
                        <form>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                    <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option>User</option>
                                        <option>Admin</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option>Active</option>
                                        <option>Pending</option>
                                        <option>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Add User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>