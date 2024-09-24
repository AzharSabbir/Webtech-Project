// views/mentorDashboardjsValidation.js
document.addEventListener("DOMContentLoaded", function() {
    const addCourseBtn = document.getElementById("addCourseBtn");
    const addCourseModal = document.getElementById("addCourseModal");
    const closeModal = addCourseModal.querySelector(".close");

    // Open the modal when the "Add Course" button is clicked
    addCourseBtn.onclick = function() {
        addCourseModal.style.display = "block";
    }

    // Close the modal
    closeModal.onclick = function() {
        addCourseModal.style.display = "none";
    }

    // Handle form submission for adding a course
    const addCourseForm = document.getElementById("addCourseForm");
    addCourseForm.onsubmit = function(event) {
        event.preventDefault(); // Prevent the default form submission
        
        const formData = new FormData(addCourseForm);
        formData.append('action', 'add'); // Add action type

        fetch('../controllers/mentorDashboardAction.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                location.reload(); // Reloads the page to show the new course
            } else {
                alert("Failed to add course: " + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Handle course deletion
    document.querySelectorAll('.deleteCourseBtn').forEach(button => {
        button.onclick = function() {
            const courseId = this.dataset.courseId;

            if (confirm("Are you sure you want to delete this course?")) {
                fetch('../controllers/mentorDashboardAction.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ action: 'delete', courseId: courseId }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        location.reload(); // Reloads the page to reflect deletion
                    } else {
                        alert("Failed to delete course: " + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    });
});
