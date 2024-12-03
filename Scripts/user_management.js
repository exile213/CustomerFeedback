document.addEventListener('DOMContentLoaded', function() {
    const userModal = document.getElementById('userModal');
    const deleteModal = document.getElementById('deleteModal');
    const userForm = document.getElementById('userForm');
    const addUserBtn = document.getElementById('addUserBtn');
    const userTableBody = document.getElementById('userTableBody');
    let currentUserId = null;

    addUserBtn.addEventListener('click', () => openModal('create'));

    userForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(userForm);
        const data = Object.fromEntries(formData.entries());
        
        if (currentUserId) {
            data.id = currentUserId;
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
            // Fetch user data and populate form
            const user = initialUsers.find(u => u.id == userId);
            document.getElementById('name').value = user.name;
            document.getElementById('email').value = user.email;
            document.getElementById('role').value = user.role;
            document.getElementById('status').value = user.status;
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

    function createUser(data) {
        fetch('index.php?action=create_user', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                closeModal();
                fetchUsers();
            } else {
                alert('Failed to create user');
            }
        });
    }

    function updateUser(data) {
        fetch('index.php?action=update_user', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                closeModal();
                fetchUsers();
            } else {
                alert('Failed to update user');
            }
        });
    }

    function deleteUser(userId) {
        fetch('index.php?action=delete_user', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: userId }),
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                closeDeleteModal();
                fetchUsers();
            } else {
                alert('Failed to delete user');
            }
        });
    }

    function fetchUsers() {
        fetch('index.php?action=get_users')
        .then(response => response.json())
        .then(users => {
            renderUsers(users);
        });
    }

    function renderUsers(users) {
        userTableBody.innerHTML = '';
        users.forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-2">${user.name}</td>
                <td class="px-4 py-2">${user.email}</td>
                <td class="px-4 py-2">${user.role}</td>
                <td class="px-4 py-2"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-${user.status === 'active' ? 'green' : user.status === 'pending' ? 'yellow' : 'red'}-100 text-${user.status === 'active' ? 'green' : user.status === 'pending' ? 'yellow' : 'red'}-800">${user.status}</span></td>
                <td class="px-4 py-2">
                    <button class="text-indigo-600 hover:text-indigo-900 editUserBtn" data-id="${user.id}">Edit</button>
                    <button class="ml-2 text-red-600 hover:text-red-900 deleteUserBtn" data-id="${user.id}">Delete</button>
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

    // Initial render of users
    renderUsers(initialUsers);
});