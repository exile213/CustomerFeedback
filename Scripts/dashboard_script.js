// Sample data
const overviewData = [
    { name: "Overall", value: 4.2 },
    { name: "Product", value: 4.5 },
    { name: "Service", value: 5.0 },
    { name: "Purchase", value: 4.3 },
    { name: "Recommend", value: 4.1 },
];

const recentFeedback = [
    { id: 1, name: "John Doe", date: "2023-06-01", overall: 4, product: 5, service: 4, purchase: 4, recommend: 4 },
    { id: 2, name: "Jane Smith", date: "2023-06-02", overall: 5, product: 5, service: 5, purchase: 5, recommend: 5 },
    { id: 3, name: "Bob Johnson", date: "2023-06-03", overall: 3, product: 4, service: 3, purchase: 3, recommend: 3 },
];

// Chart
function createChart() {
    const barChart = document.createElement('canvas');
    const pieChart = document.createElement('canvas');
    document.getElementById('barchart').appendChild(barChart);
    document.getElementById('piechart').appendChild(pieChart);

    new Chart(barChart, {
        type: 'bar',
        data: {
            labels: overviewData.map(item => item.name),
            datasets: [{
                label: 'Average Rating',
                data: overviewData.map(item => item.value),
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
            }
        }
    });

    new Chart(pieChart, {
        type: 'pie',
        data: data,
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
            title: {
              display: true,
              text: 'Chart.js Pie Chart'
            }
          }
        },
    });

    
    
}

// Recent Feedback
function displayRecentFeedback() {
    const recentFeedbackList = document.getElementById('recent-feedback-list');
    recentFeedback.forEach(feedback => {
        const feedbackItem = document.createElement('div');
        feedbackItem.classList.add('feedback-item');
        feedbackItem.innerHTML = `
            <h3>${feedback.name}</h3>
            <p>Date: ${feedback.date}</p>
            <p>Overall: ${feedback.overall}, Product: ${feedback.product}, Service: ${feedback.service}</p>
        `;
        recentFeedbackList.appendChild(feedbackItem);
    });
}

// Detailed Feedback Table
function populateTable() {
    const tableBody = document.getElementById('feedback-table-body');
    recentFeedback.forEach(feedback => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${feedback.date}</td>
            <td>${feedback.name}</td>
            <td>${feedback.overall}</td>
            <td>${feedback.product}</td>
            <td>${feedback.service}</td>
            <td>${feedback.purchase}</td>
            <td>${feedback.recommend}</td>
        `;
        tableBody.appendChild(row);
    });
}

// Search functionality
document.getElementById('search').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#feedback-table-body tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Export functionality (just a placeholder)
document.getElementById('export-btn').addEventListener('click', function() {
    alert('Export functionality would be implemented here.');
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    createChart();
    displayRecentFeedback();
    populateTable();
});