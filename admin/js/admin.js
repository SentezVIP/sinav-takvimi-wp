// Oturum kontrolü
function checkAuth() {
    const token = localStorage.getItem('adminToken');
    if (!token) {
        window.location.href = '/admin/login.html';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    checkAuth();
    
    // Takvim başlatma
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        locale: 'tr',
        events: loadExams(), // Sınavları yükle
        height: 'auto',
        themeSystem: 'bootstrap5',
        eventColor: '#3b82f6',
        eventDidMount: function(info) {
            info.el.style.borderRadius = '6px';
        },
        editable: true,
        eventDrop: function(info) {
            updateExam(info.event);
        },
        eventClick: function(info) {
            openEditModal(info.event);
        }
    });
    calendar.render();

    // Sınav ekleme formu
    document.getElementById('examForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const exam = {
            title: document.getElementById('examTitle').value,
            location: document.getElementById('examLocation').value,
            date: document.getElementById('examDate').value,
            time: document.getElementById('examTime').value
        };
        addExam(exam);
        this.reset();
    });

    // Çıkış işlemi
    document.getElementById('logoutBtn').addEventListener('click', function() {
        localStorage.removeItem('adminToken');
        window.location.href = '/admin/login.html';
    });
});

// Sınav ekleme
async function addExam(exam) {
    try {
        const response = await fetch('/api/exams', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('adminToken')}`
            },
            body: JSON.stringify(exam)
        });
        
        if (response.ok) {
            showToast('Sınav başarıyla eklendi', 'success');
            loadExams();
        } else {
            showToast('Sınav eklenirken hata oluştu', 'error');
        }
    } catch (error) {
        showToast('Bir hata oluştu', 'error');
    }
}

// Sınav güncelleme
async function updateExam(exam) {
    try {
        const response = await fetch(`/api/exams/${exam.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('adminToken')}`
            },
            body: JSON.stringify(exam)
        });
        
        if (response.ok) {
            showToast('Sınav başarıyla güncellendi', 'success');
            loadExams();
        } else {
            showToast('Sınav güncellenirken hata oluştu', 'error');
        }
    } catch (error) {
        showToast('Bir hata oluştu', 'error');
    }
}

// Sınav silme
async function deleteExam(examId) {
    if (confirm('Bu sınavı silmek istediğinizden emin misiniz?')) {
        try {
            const response = await fetch(`/api/exams/${examId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('adminToken')}`
                }
            });
            
            if (response.ok) {
                showToast('Sınav başarıyla silindi', 'success');
                loadExams();
            } else {
                showToast('Sınav silinirken hata oluştu', 'error');
            }
        } catch (error) {
            showToast('Bir hata oluştu', 'error');
        }
    }
}

// Toast bildirimi gösterme
function showToast(message, type) {
    const toastContainer = document.querySelector('.toast-container');
    const toast = document.createElement('div');
    toast.className = `toast show bg-${type === 'success' ? 'success' : 'danger'} text-white`;
    toast.innerHTML = `
        <div class="toast-body">
            ${message}
        </div>
    `;
    toastContainer.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
} 