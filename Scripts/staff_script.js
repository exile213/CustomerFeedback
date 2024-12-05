// Initialize when document loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Feedback data:', feedback);
    console.log('Customers data:', customers);
    initializeTabs();
    populateFeedbackList(feedback);
    populateCustomerList(customers);
    initializeSearch();
});

// Tab functionality
function initializeTabs() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            tabButtons.forEach(btn => btn.classList.remove('active', 'border-gray-800', 'text-gray-800'));
            tabContents.forEach(content => content.classList.add('hidden'));

            button.classList.add('active', 'border-gray-800', 'text-gray-800');
            const tabId = button.dataset.tab;
            document.getElementById(tabId).classList.remove('hidden');
        });
    });
}

// Populate feedback list
function populateFeedbackList(feedbackData) {
    const feedbackList = document.getElementById('feedbackList');
    if (feedbackData && feedbackData.length > 0) {
        feedbackList.innerHTML = feedbackData.map(item => `
            <div class="flex items-start space-x-4 rounded-lg border p-4">
                <div class="flex-1 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium">${item.Name}</span>
                        <span class="text-sm text-gray-500">${new Date(item.feedback_date).toLocaleDateString()}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        ${item.ratings.split(', ').map(rating => {
                            const [category, score] = rating.split(': ');
                            let icon = '';
                            switch(category) {
                                case 'Overall Satisfaction':
                                    icon = 'ri-star-line text-yellow-400';
                                    break;
                                case 'Product Quality':
                                    icon = 'ri-product-hunt-line text-blue-400';
                                    break;
                                case 'Customer Service':
                                    icon = 'ri-customer-service-2-line text-green-400';
                                    break;
                                case 'Purchasing Experience':
                                    icon = 'ri-shopping-cart-line text-purple-400';
                                    break;
                                case 'Recommendation Likelihood':
                                    icon = 'ri-thumb-up-line text-red-400';
                                    break;
                                default:
                                    icon = 'ri-question-line text-gray-400';
                            }
                            return `
                                <div class="flex items-center space-x-2 text-sm">
                                    <i class="${icon}"></i>
                                    <span>${category}: ${score}/5</span>
                                </div>
                            `;
                        }).join('')}
                    </div>
                    ${item.comments ? `<p class="text-sm text-gray-600 mt-2">${item.comments}</p>` : ''}
                </div>
                <button 
                    class="px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded-md"
                    onclick="viewFeedbackDetails('${item.FeedbackID}')"
                >
                    View Details
                </button>
            </div>
        `).join('');
    } else {
        feedbackList.innerHTML = '<p class="text-gray-500">No feedback available.</p>';
    }
}

// Populate customer list
function populateCustomerList(customerData) {
    const customerList = document.getElementById('customerList');
    if (customerData && customerData.length > 0) {
        customerList.innerHTML = customerData.map(item => `
            <div class="flex items-start space-x-4 rounded-lg border p-4">
                <div class="flex-1 space-y-1">
                    <p class="font-medium">Name: ${item.Name}</p>
                    <p class="text-sm">Email: ${item.Email}</p> 
                    <p class="text-sm">Phone Number: ${item.Phone}</p> 
                </div>
            </div>
        `).join('');
    } else {
        customerList.innerHTML = '<p class="text-gray-500">No customers available.</p>';
    }
}

// Initialize search functionality
function initializeSearch() {
    const feedbackSearchInput = document.getElementById('feedbackSearch');
    feedbackSearchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const filteredFeedback = feedback.filter(item => 
            item.Name.toLowerCase().includes(searchTerm) ||
            (item.comments && item.comments.toLowerCase().includes(searchTerm)) ||
            item.feedback_date.toLowerCase().includes(searchTerm) ||
            item.ratings.toLowerCase().includes(searchTerm)
        );
        populateFeedbackList(filteredFeedback);
    });

    const customerSearchInput = document.getElementById('customerSearch');
    customerSearchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const filteredCustomers = customers.filter(item => 
            item.Name.toLowerCase().includes(searchTerm) ||
            item.Email.toLowerCase().includes(searchTerm)
        );
        populateCustomerList(filteredCustomers);
    });
}

// View feedback details handler
function viewFeedbackDetails(feedbackId) {
    const feedbackItem = feedback.find(item => item.FeedbackID === feedbackId);
    if (feedbackItem) {
        alert(`Feedback Details:
        ID: ${feedbackItem.FeedbackID}
        Name: ${feedbackItem.Name}
        Date: ${new Date(feedbackItem.feedback_date).toLocaleString()}
        Ratings: ${feedbackItem.ratings}
        ${feedbackItem.comments ? `Comments: ${feedbackItem.comments}` : 'No comments provided.'}`);
    } else {
        alert('Feedback details not found.');
    }
}

