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
                        <span class="text-sm text-gray-500">${new Date(item.created_at).toLocaleDateString()}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex items-center space-x-2 text-sm">
                            <i class="ri-star-line text-yellow-400"></i>
                            <span>Overall: ${item.overall_rating}/5</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm">
                            <i class="ri-product-hunt-line text-blue-400"></i>
                            <span>Product: ${item.product_rating}/5</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm">
                            <i class="ri-customer-service-2-line text-green-400"></i>
                            <span>Service: ${item.service_rating}/5</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm">
                            <i class="ri-shopping-cart-line text-purple-400"></i>
                            <span>Purchase: ${item.purchase_rating}/5</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm">
                            <i class="ri-thumb-up-line text-red-400"></i>
                            <span>Recommend: ${item.recommend_rating}/5</span>
                        </div>
                    </div>
                    ${item.comments ? `<p class="text-sm text-gray-700 mt-2">${item.comments}</p>` : ''}
                </div>
                <button 
                    class="px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded-md"
                    onclick="viewFeedbackDetails('${item.id}')"
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
                    <p class="font-medium">Name: ${item.name}</p>
                    <p class="font-small">Email: ${item.email}</p> 
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
            item.name.toLowerCase().includes(searchTerm) ||
            (item.comments && item.comments.toLowerCase().includes(searchTerm)) ||
            item.created_at.toLowerCase().includes(searchTerm) ||
            item.overall_rating.toString().includes(searchTerm)
        );
        populateFeedbackList(filteredFeedback);
    });

    const customerSearchInput = document.getElementById('customerSearch');
    customerSearchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const filteredCustomers = customers.filter(item => 
            item.name.toLowerCase().includes(searchTerm)
        );
        populateCustomerList(filteredCustomers);
    });
}

// View feedback details handler
function viewFeedbackDetails(feedbackId) {
    const feedbackItem = feedback.find(item => item.id === feedbackId);
    if (feedbackItem) {
        alert(`Feedback Details:
        ID: ${feedbackItem.id}
        Name: ${feedbackItem.name}
        Date: ${new Date(feedbackItem.created_at).toLocaleString()}
        Overall Rating: ${feedbackItem.overall_rating}/5
        Product Rating: ${feedbackItem.product_rating}/5
        Service Rating: ${feedbackItem.service_rating}/5
        Purchase Rating: ${feedbackItem.purchase_rating}/5
        Recommend Rating: ${feedbackItem.recommend_rating}/5
        ${feedbackItem.comments ? `Comments: ${feedbackItem.comments}` : 'No comments provided.'}`);
    } else {
        alert('Feedback details not found.');
    }
}

// Add active tab styling
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        .tab-button {
            position: relative;
            transition: all 0.2s;
        }
        
        .tab-button.active {
            color: rgb(17, 24, 39);
        }
        
        .tab-button:not(.active) {
            color: rgb(107, 114, 128);
        }
        
        .tab-button:not(.active):hover {
            color: rgb(55, 65, 81);
        }
        
        .tab-button.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: rgb(17, 24, 39);
        }
    `;
    document.head.appendChild(style);
});

