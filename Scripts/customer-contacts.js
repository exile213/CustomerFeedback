document.addEventListener('DOMContentLoaded', function() {
    const contactModal = document.getElementById('contactModal');
    const deleteModal = document.getElementById('deleteModal');
    const contactForm = document.getElementById('contactForm');
    const addContactBtn = document.getElementById('addContactBtn');
    const contactTableBody = document.getElementById('contactTableBody');
    let currentContactId = null;
    let contacts = [];

    addContactBtn.addEventListener('click', () => openModal('create'));

    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(contactForm);
        const data = Object.fromEntries(formData.entries());
        
        if (currentContactId) {
            data.CustomerID = currentContactId;
            updateContact(data);
        } else {
            createContact(data);
        }
    });

    function openModal(action, contactId = null) {
        currentContactId = contactId;
        document.getElementById('modalTitle').textContent = action === 'create' ? 'Add New Contact' : 'Edit Contact';
        if (action === 'edit') {
            const contact = contacts.find(c => c.CustomerID === parseInt(contactId));
            document.getElementById('name').value = contact.Name;
            document.getElementById('email').value = contact.Email;
            document.getElementById('phone').value = contact.Phone;
            document.getElementById('date').value = contact.Date;
        } else {
            contactForm.reset();
        }
        contactModal.classList.remove('hidden');
    }

    function closeModal() {
        contactModal.classList.add('hidden');
    }

    function openDeleteModal(contactId) {
        currentContactId = contactId;
        deleteModal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
    }

    document.getElementById('confirmDelete').addEventListener('click', () => {
        deleteContact(currentContactId);
    });

    async function handleResponse(response) {
        const contentType = response.headers.get("content-type");
        if (contentType && contentType.indexOf("application/json") !== -1) {
            return response.json();
        } else {
            throw new Error("Oops, we haven't got JSON!");
        }
    }

    async function createContact(data) {
        try {
            const response = await fetch('controllers/dashboard-pages/customer-contacts.php?action=create_contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });
            const result = await handleResponse(response);
            if (result.success) {
                closeModal();
                fetchContacts();
            } else {
                alert('Failed to create contact: ' + (result.error || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while creating the contact. Please try again.');
        }
    }

    async function updateContact(data) {
        try {
            const response = await fetch('controllers/dashboard-pages/customer-contacts.php?action=update_contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });
            const result = await handleResponse(response);
            if (result.success) {
                closeModal();
                fetchContacts();
            } else {
                alert('Failed to update contact: ' + (result.error || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while updating the contact. Please try again.');
        }
    }

    async function deleteContact(contactId) {
        try {
            const response = await fetch('controllers/dashboard-pages/customer-contacts.php?action=delete_contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ CustomerID: contactId }),
            });
            const result = await handleResponse(response);
            if (result.success) {
                closeDeleteModal();
                fetchContacts();
            } else {
                alert('Failed to delete contact: ' + (result.error || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while deleting the contact. Please try again.');
        }
    }

    async function fetchContacts() {
        try {
            const response = await fetch('controllers/dashboard-pages/customer-contacts.php?action=get_contacts');
            const data = await handleResponse(response);
            contacts = data;
            renderContacts(data);
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while fetching contacts. Please refresh the page and try again.');
        }
    }

    function renderContacts(contacts) {
        contactTableBody.innerHTML = '';
        contacts.forEach(contact => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-2">${contact.Name}</td>
                <td class="px-4 py-2">${contact.Email}</td>
                <td class="px-4 py-2">${contact.Phone}</td>
                <td class="px-4 py-2">${contact.Date}</td>
                <td class="px-4 py-2">
                    <button class="text-blue-600 hover:text-blue-800 mr-2 editContactBtn" data-id="${contact.CustomerID}">Edit</button>
                    <button class="text-red-600 hover:text-red-800 deleteContactBtn" data-id="${contact.CustomerID}">Delete</button>
                </td>
            `;
            contactTableBody.appendChild(row);
        });
    }

    // Add event listeners for edit and delete buttons
    contactTableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('editContactBtn')) {
            openModal('edit', e.target.dataset.id);
        } else if (e.target.classList.contains('deleteContactBtn')) {
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

    // Initial fetch of contacts
    fetchContacts();
});