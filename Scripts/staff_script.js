// Sample customer data
const customers = [
    {
        name: "John Doe",
        email: "john@example.com",
        phone: "123-456-7890",
    },
    {
        name: "Jane Smith",
        email: "jane@example.com",
        phone: "098-765-4321",
    },
    {
        name: "Mike Johnson",
        email: "mike@example.com",
        phone: "555-123-4567",
    },
    {
        name: "Sarah Williams",
        email: "sarah@example.com",
        phone: "777-888-9999",
    },
];

// Initialize when document loads
document.addEventListener('DOMContentLoaded', function() {
    initializeTabs();
    populateCustomerList(customers);
    initializeSearch();
});

// Tab functionality
function initializeTabs() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons and content
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'border-b-2', 'border-gray-900');
                btn.classList.add('text-gray-500', 'hover:text-gray-700');
            });
            tabContents.forEach(content => content.classList.add('hidden'));

            // Add active class to clicked button and show content
            button.classList.add('active', 'border-b-2', 'border-gray-900');
            button.classList.remove('text-gray-500', 'hover:text-gray-700');
            const tabId = button.dataset.tab;
            document.getElementById(tabId).classList.remove('hidden');
        });
    });

    // Set initial active tab
    document.querySelector('.tab-button[data-tab="customers"]').click();
}

// Populate customer list
function populateCustomerList(customerData) {
    const customerList = document.getElementById('customerList');
    customerList.innerHTML = customerData.map(customer => `
        <div class="flex items-start space-x-4 rounded-lg border p-4">
            <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded-full bg-gray-100">
                <span class="text-lg font-semibold text-gray-600">
                    ${getInitials(customer.name)}
                </span>
            </div>
            <div class="flex-1 space-y-1">
                <p class="font-medium">${customer.name}</p>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <i class="ri-mail-line"></i>
                    <span>${customer.email}</span>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <i class="ri-phone-line"></i>
                    <span>${customer.phone}</span>
                </div>
            </div>
            <button 
                class="px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded-md"
                onclick="viewCustomerDetails('${customer.email}')"
            >
                View Details
            </button>
        </div>
    `).join('');
}

// Initialize search functionality
function initializeSearch() {
    const searchInput = document.getElementById('customerSearch');
    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const filteredCustomers = customers.filter(customer => 
            customer.name.toLowerCase().includes(searchTerm) ||
            customer.email.toLowerCase().includes(searchTerm) ||
            customer.phone.includes(searchTerm)
        );
        populateCustomerList(filteredCustomers);
    });
}

// Utility function to get initials from name
function getInitials(name) {
    return name
        .split(' ')
        .map(word => word[0])
        .join('')
        .toUpperCase();
}

// View customer details handler
function viewCustomerDetails(email) {
    // This would typically open a modal or navigate to a customer details page
    alert(`Viewing details for customer: ${email}`);
}

// Logout handler
document.querySelector('button:contains("Logout")').addEventListener('click', () => {
    if (confirm('Are you sure you want to logout?')) {
        // Here you would typically handle logout through the server
        window.location.href = '/login';
    }
});

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