document.addEventListener('DOMContentLoaded', function() {
    const contactModal = document.getElementById('contactModal');
    const deleteModal = document.getElementById('deleteModal');
    const contactForm = document.getElementById('contactForm');
    const addContactBtn = document.getElementById('addContactBtn');
    const contactTableBody = document.getElementById('contactTableBody');
    let currentContactId = null;

    addContactBtn.addEventListener('click', () => openModal('create'));

    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(contactForm);
        const data = Object.fromEntries(formData.entries());
        
        if (currentContactId) {
            data.id = currentContactId;
            updateContact(data);
        } else {
            createContact(data);
        }
    });

    function openModal(action, contactId = null) {
        currentContactId = contactId;
        document.getElementById('modalTitle').textContent = action === 'create' ? 'Add New Contact' : 'Edit Contact';
        if (action === 'edit') {
            const contact = contacts.find(c => c.id === parseInt(contactId));
            document.getElementById('name').value = contact.name;
            document.getElementById('email').value = contact.email;
            document.getElementById('phone').value = contact.phone;
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

    function createContact(data) {
        fetch('../index.php?action=create_contact', {
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
                fetchContacts();
            } else {
                alert('Failed to create contact');
            }
        });
    }

    function updateContact(data) {
        fetch('index.php?action=update_contact', {
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
                fetchContacts();
            } else {
                alert('Failed to update contact');
            }
        });
    }

    function deleteContact(contactId) {
        fetch('index.php?action=delete_contact', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: contactId }),
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                closeDeleteModal();
                fetchContacts();
            } else {
                alert('Failed to delete contact');
            }
        });
    }

    function fetchContacts() {
        fetch('../index.php?action=get_contacts')
        .then(response => response.json())
        .then(data => {
            contacts = data;
            renderContacts(data);
        });
    }

    function renderContacts(contacts) {
        contactTableBody.innerHTML = '';
        contacts.forEach(contact => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-2">${contact.name}</td>
                <td class="px-4 py-2">${contact.email}</td>
                <td class="px-4 py-2">${contact.phone}</td>
                <td class="px-4 py-2">
                    <button class="text-blue-600 hover:text-blue-800 mr-2 editContactBtn" data-id="${contact.id}">Edit</button>
                    <button class="text-red-600 hover:text-red-800 deleteContactBtn" data-id="${contact.id}">Delete</button>
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