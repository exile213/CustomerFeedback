<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotional Messages</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <?php require "views/Partials/sidebar.php"?>
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navigation bar -->
            <header class="bg-indigo-500  border-b">
                <div class="flex justify-between items-center px-6 py-4">
                    <h1 class="text-xl font-semibold text-gray-800">Promotional Messages</h1>
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
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <div class="max-w-7xl mx-auto space-y-6">
                    <!-- Message Creation Form -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold mb-4">Create Promotional Message</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Message Type</label>
                                <div class="flex space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="messageType" value="sms" class="form-radio" checked>
                                        <span class="ml-2">SMS</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="messageType" value="email" class="form-radio">
                                        <span class="ml-2">Email</span>
                                    </label>
                                </div>
                            </div>
                            <div id="subjectField" class="hidden">
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                <input type="text" id="subject" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter email subject">
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <textarea id="message" rows="4" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter your promotional message here..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Customer List -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold mb-4">Contact List</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Select</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">John Doe</td>
                                        <td class="px-6 py-4 whitespace-nowrap">john@example.com</td>
                                        <td class="px-6 py-4 whitespace-nowrap">+1234567890</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">Jane Smith</td>
                                        <td class="px-6 py-4 whitespace-nowrap">jane@example.com</td>
                                        <td class="px-6 py-4 whitespace-nowrap">+1987654321</td>
                                    </tr>
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            <button id="sendMessage" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Send Message
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Show/hide subject field based on message type
        const messageTypeRadios = document.querySelectorAll('input[name="messageType"]');
        const subjectField = document.getElementById('subjectField');

        messageTypeRadios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                if (e.target.value === 'email') {
                    subjectField.classList.remove('hidden');
                } else {
                    subjectField.classList.add('hidden');
                }
            });
        });

        // Handle send message button click
        document.getElementById('sendMessage').addEventListener('click', () => {
            const messageType = document.querySelector('input[name="messageType"]:checked').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;
            const selectedCustomers = Array.from(document.querySelectorAll('input[type="checkbox"]:checked'))
                .map(checkbox => checkbox.closest('tr').querySelector('td:nth-child(2)').textContent);

            console.log('Sending message:', { type: messageType, subject, message, recipients: selectedCustomers });
            // Implement actual sending logic here
        });
    </script>
</body>
</html>