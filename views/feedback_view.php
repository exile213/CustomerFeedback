<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-400 via-pink-100 to-blue-200">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-md p-8">
            <h1 class="text-3xl font-bold text-center text-purple-600 mb-2">Customer Feedback</h1>
            <p class="text-gray-500 text-center mb-8">Please share your experience with us</p>
            
            <form id="feedbackForm" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="tel" id="phone" name="phone" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date of Visit</label>
                    <input type="date" id="date" name="date" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Overall Experience</label>
                        <div class="star-rating flex gap-3 justify-center" data-rating="overall_rating">
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="1"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="2"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="3"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="4"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="5"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Quality</label>
                        <div class="star-rating flex gap-3 justify-center" data-rating="product_rating">
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="1"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="2"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="3"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="4"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="5"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Customer Service</label>
                        <div class="star-rating flex gap-3 justify-center" data-rating="service_rating">
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="1"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="2"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="3"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="4"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="5"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Experience</label>
                        <div class="star-rating flex gap-3 justify-center" data-rating="purchase_rating">
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="1"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="2"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="3"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="4"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="5"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Likelihood to Recommend</label>
                        <div class="star-rating flex gap-3 justify-center" data-rating="recommend_rating">
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="1"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="2"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="3"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="4"></i>
                            <i class="fas fa-star text-gray-300 hover:text-yellow-400 cursor-pointer text-xl" data-value="5"></i>
                        </div>
                    </div>

                    <div>
                        <label for="comments" class="block text-sm font-medium text-gray-700 mb-1">Additional Comments</label>
                        <textarea id="comments" name="comments" rows="3" 
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full py-3 px-4 rounded-lg bg-gradient-to-r from-purple-600 to-blue-500 text-white font-medium hover:from-purple-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                    Submit Feedback
                </button>
            </form>
        </div>
    </div>
    <script src="Scripts/Feedback_Script.js"></script>
</body>
</html>

