document.addEventListener('DOMContentLoaded', function() {
    const feedbackTable = document.getElementById('feedbackTable');
    const searchInput = document.getElementById('searchInput');
    const exportBtn = document.getElementById('exportBtn');

    let allFeedback = [];

    // Function to populate the table with feedback data
    function populateTable(feedback) {
        const tableBody = feedbackTable.querySelector('tbody');
        tableBody.innerHTML = '';

        feedback.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">${new Date(item.feedback_date).toLocaleDateString()}</td>
                <td class="px-6 py-4 whitespace-nowrap">${item.Name}</td>
                <td class="px-6 py-4">${item.ratings}</td>
                <td class="px-6 py-4">${item.comments || ''}</td>
            `;
            tableBody.appendChild(row);
        });
    }

    // Initial population of the table
    populateTable(initialFeedback);

    // Fetch all feedback data
    fetch('controllers/dashboard-pages/customer-feedback.php?action=get_all_feedback')
        .then(response => response.json())
        .then(data => {
            allFeedback = data;
            populateTable(allFeedback);
        })
        .catch(error => console.error('Error fetching feedback:', error));

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const filteredFeedback = allFeedback.filter(item => 
            item.Name.toLowerCase().includes(searchTerm) ||
            item.comments.toLowerCase().includes(searchTerm) ||
            item.ratings.toLowerCase().includes(searchTerm)
        );
        populateTable(filteredFeedback);
    });

    // Export to CSV functionality
    exportBtn.addEventListener('click', function() {
        let csvContent = "data:text/csv;charset=utf-8,";
        
        // Add headers
        csvContent += "Date,Customer Name,Ratings,Comments\n";
        
        // Add data rows
        allFeedback.forEach(item => {
            const row = [
                new Date(item.feedback_date).toLocaleDateString(),
                item.Name,
                item.ratings,
                item.comments
            ].map(cell => `"${cell}"`).join(',');
            csvContent += row + "\n";
        });
        
        // Create download link
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "customer_feedback.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
});