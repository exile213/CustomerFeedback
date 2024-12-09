document.addEventListener('DOMContentLoaded', function() {
    const userModal = document.getElementById('userModal');
    const deleteModal = document.getElementById('deleteModal');
    const userForm = document.getElementById('userForm');
    const addUserBtn = document.getElementById('addUserBtn');
    const userTableBody = document.getElementById('userTableBody');
    let currentUserId = null;
    let initialUsers = [];

    addUserBtn.addEventListener('click', () => openModal('create'));

    userForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(userForm);
        const data = Object.fromEntries(formData.entries());
        
        if (currentUserId) {
            data.EmployeeID = currentUserId;
            updateUser(data);
        } else {
            createUser(data);
        }
    });

    function openModal(action, userId = null) {
        currentUserId = userId;
        document.getElementById('modalTitle').textContent = action === 'create' ? 'Create User' : 'Edit User';
        document.getElementById('passwordField').style.display = action === 'create' ? 'block' : 'none';
        if (action === 'edit') {
            const user = initialUsers.find(u => u.EmployeeID == userId);
            document.getElementById('name').value = user.name;
            document.getElementById('email').value = user.email;
            document.getElementById('role').value = user.role;
            document.getElementById('status').value = user.Status;
        } else {
            userForm.reset();
        }
        userModal.classList.remove('hidden');
    }

    function closeModal() {
        userModal.classList.add('hidden');
    }

    function openDeleteModal(userId) {
        currentUserId = userId;
        deleteModal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
    }

    document.getElementById('confirmDelete').addEventListener('click', () => {
        deleteUser(currentUserId);
    });

    async function handleResponse(response) {
        const contentType = response.headers.get("content-type");
        if (contentType && contentType.indexOf("application/json") !== -1) {
            return response.json();
        } else {
            throw new Error("Oops, we haven't got JSON!");
        }
    }

    async function createUser(data) {
        try {
            const response = await fetch('controllers/dashboard-pages/user-management.php?action=create_user', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });
            const result = await handleResponse(response);
            if (result.success) {
                closeModal();
                fetchUsers();
            } else {
                alert('Failed to create user: ' + (result.error || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while creating the user. Please try again.');
        }
    }

    async function updateUser(data) {
        try {
            const response = await fetch('controllers/dashboard-pages/user-management.php?action=update_user', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });
            const result = await handleResponse(response);
            if (result.success) {
                closeModal();
                fetchUsers();
            } else {
                alert('Failed to update user: ' + (result.error || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while updating the user. Please try again.');
        }
    }

    async function deleteUser(userId) {
        try {
            const response = await fetch('controllers/dashboard-pages/user-management.php?action=delete_user', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ EmployeeID: userId }),
            });
            const result = await handleResponse(response);
            if (result.success) {
                closeDeleteModal();
                fetchUsers();
            } else {
                alert('Failed to delete user: ' + (result.error || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while deleting the user. Please try again.');
        }
    }

    async function fetchUsers() {
        try {
            const response = await fetch('controllers/dashboard-pages/user-management.php?action=get_users');
            const users = await handleResponse(response);
            initialUsers = users;
            renderUsers(users);
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while fetching users. Please refresh the page and try again.');
        }
    }

    function renderUsers(users) {
        userTableBody.innerHTML = '';
        users.forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-2">${user.name}</td>
                <td class="px-4 py-2">${user.email}</td>
                <td class="px-4 py-2">${user.role}</td>
                <td class="px-4 py-2"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-${user.Status === 'active' ? 'green' : user.Status === 'pending' ? 'yellow' : 'red'}-100 text-${user.Status === 'active' ? 'green' : user.Status === 'pending' ? 'yellow' : 'red'}-800">${user.Status}</span></td>
                <td class="px-4 py-2">
                    <button class="text-indigo-600 hover:text-indigo-900 editUserBtn" data-id="${user.EmployeeID}">Edit</button>
                    <button class="ml-2 text-red-600 hover:text-red-900 deleteUserBtn" data-id="${user.EmployeeID}">Delete</button>
                </td>
            `;
            userTableBody.appendChild(row);
        });
    }

    // Add event listeners for edit and delete buttons
    userTableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('editUserBtn')) {
            openModal('edit', e.target.dataset.id);
        } else if (e.target.classList.contains('deleteUserBtn')) {
            openDeleteModal(e.target.dataset.id);
        }
    });

    // Add event listeners for closing modals
    document.querySelectorAll('.modal-close').forEach(button => {
        button.addEventListener('click', () => {
            closeModal();
            closeDeleteModal();
        });
    });

    // Initial fetch of users
    fetchUsers();
});