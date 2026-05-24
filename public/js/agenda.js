const editModal = document.getElementById('editModal');
const editModalContent = document.getElementById('editModalContent');
let currentEditTaskId = null;

function openEditModal(taskId) {
    fetch('/agenda/' + taskId + '/data')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('edit_task_id').value = data.task.id;
                document.getElementById('edit_title').value = data.task.title;
                document.getElementById('edit_description').value = data.task.description || '';
                document.getElementById('edit_tags').value = data.task.tags || '';
                document.getElementById('edit_due_date').value = data.task.due_date;
                if (document.getElementById('edit_class_id')) {
                    document.getElementById('edit_class_id').value = data.task.class_id;
                }

                editModal.classList.remove('hidden');
                editModal.classList.add('flex');
                setTimeout(() => {
                    editModalContent.classList.remove('scale-95', 'opacity-0');
                    editModalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
            }
        })
        .catch(error => console.error('Error:', error));
}

function closeEditModal() {
    editModalContent.classList.remove('scale-100', 'opacity-100');
    editModalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        editModal.classList.remove('flex');
        editModal.classList.add('hidden');
    }, 300);
}

document.getElementById('editTaskForm')?.addEventListener('submit', function (e) {
    e.preventDefault();
    const taskId = document.getElementById('edit_task_id').value;
    const formData = new FormData(this);

    fetch('/agenda/' + taskId + '/update', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeEditModal();
                window.location.reload();
            } else {
                alert(data.error || 'Failed to update task');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred');
        });
});

function showDeleteTaskModal(taskId) {
    showConfirmationModal(
        'Delete Task',
        'Are you sure you want to delete this task? This action cannot be undone.',
        () => {
            document.getElementById('deleteTaskForm-' + taskId).submit();
        }
    );
}

const addModal = document.getElementById('addModal');
const addModalContent = document.getElementById('addModalContent');

function openAddModal() {
    addModal.classList.remove('hidden');
    addModal.classList.add('flex');
    setTimeout(() => {
        addModalContent.classList.remove('scale-95', 'opacity-0');
        addModalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeAddModal() {
    addModalContent.classList.remove('scale-100', 'opacity-100');
    addModalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        addModal.classList.remove('flex');
        addModal.classList.add('hidden');
    }, 300);
}

function filterByClass(classId) {
    window.location.href = '/agenda?class=' + classId;
}

addModal?.addEventListener('click', function (e) {
    if (e.target === this) closeAddModal();
});

editModal?.addEventListener('click', function (e) {
    if (e.target === this) closeEditModal();
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        if (addModal && !addModal.classList.contains('hidden')) closeAddModal();
        if (editModal && !editModal.classList.contains('hidden')) closeEditModal();
    }
});

function toggleSection(sectionName) {
    const content = document.getElementById(sectionName + 'Content');
    const arrow = document.getElementById(sectionName + 'Arrow');
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        arrow.style.transform = 'rotate(0deg)';
    } else {
        content.style.display = 'none';
        arrow.style.transform = 'rotate(180deg)';
    }
}

function saveSectionState(sectionName, isCollapsed) {
    localStorage.setItem('agenda_' + sectionName + '_collapsed', isCollapsed);
}

function loadSectionState(sectionName) {
    const isCollapsed = localStorage.getItem('agenda_' + sectionName + '_collapsed') === 'true';
    const content = document.getElementById(sectionName + 'Content');
    const arrow = document.getElementById(sectionName + 'Arrow');
    
    if (content && arrow) {
        if (isCollapsed) {
            content.style.display = 'none';
            arrow.style.transform = 'rotate(180deg)';
        } else {
            content.style.display = 'block';
            arrow.style.transform = 'rotate(0deg)';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    loadSectionState('currentTasks');
    loadSectionState('passedTasks');
});

function toggleSection(sectionName) {
    const content = document.getElementById(sectionName + 'Content');
    const arrow = document.getElementById(sectionName + 'Arrow');
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        arrow.style.transform = 'rotate(0deg)';
        localStorage.setItem('agenda_' + sectionName + '_collapsed', 'false');
    } else {
        content.style.display = 'none';
        arrow.style.transform = 'rotate(180deg)';
        localStorage.setItem('agenda_' + sectionName + '_collapsed', 'true');
    }
}