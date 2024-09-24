// Global variables
let cart = [];
let enrollmentData = {}; // This should be populated from the server-side script

// Load cart from cookies when the window loads
window.onload = function() {
    const storedCart = getCookie('cart');
    if (storedCart) {
        cart = JSON.parse(storedCart);
        updateCartItemsList();
        updateCartButtonStates(); // Reflect cart state on buttons
    }
};

// --------------------------- Cart Functions ---------------------------

// Function to toggle cart status for a course
function toggleCart(courseId) {
    const cartButton = document.getElementById(`cart-btn-${courseId}`);
    if (cart.includes(courseId)) {
        cart = cart.filter(id => id !== courseId); // Remove from cart
        cartButton.innerText = "Add to Cart"; 
    } else {
        cart.push(courseId); // Add to cart
        cartButton.innerText = "Added to Cart"; 
    }
    setCookie('cart', JSON.stringify(cart), 7);
    updateCartItemsList(); // Update the cart items list
}

// Function to update cart items list
function updateCartItemsList() {
    const cartItemsList = document.getElementById('cartItemsList');
    cartItemsList.innerHTML = ''; 

    if (cart.length > 0) {
        cart.forEach(courseId => {
            const listItem = document.createElement('li');
            listItem.textContent = 'Course ID: ' + courseId; 
            
            // Check enrollment status for the course
            const enrollmentStatus = enrollmentData[courseId]; // Get enrollment status
            let buttonText = "Enroll"; // Default button text
            let buttonEnabled = true; // Default state
            
            if (enrollmentStatus === 'pending') {
                buttonText = "Pending"; // If enrollment is pending
                buttonEnabled = false; // Disable button if pending
            } else if (enrollmentStatus === 'accepted') {
                buttonText = "Enrolled"; // If already enrolled
                buttonEnabled = false; // Disable button if enrolled
            }
            
            // Create Enroll button with dynamic text
            const enrollButton = document.createElement('button');
            enrollButton.innerText = buttonText;
            enrollButton.disabled = !buttonEnabled; // Disable button based on status
            enrollButton.onclick = function() {
                if (buttonEnabled) {
                    openEnrollmentForm(courseId);
                    closeCartModal(); 
                }
            };
            
            // Create Remove button
            const removeButton = document.createElement('button');
            removeButton.innerText = "Remove";
            removeButton.onclick = function() {
                // Remove the course ID from the cart
                cart = cart.filter(id => id !== courseId);
                setCookie('cart', JSON.stringify(cart), 7);
                updateCartItemsList(); // Update the list
                updateCartButtonStates(); // Update button states immediately
            };
            
            listItem.appendChild(enrollButton);
            listItem.appendChild(removeButton);
            cartItemsList.appendChild(listItem);
        });
    } else {
        cartItemsList.innerHTML = '<li>No items in the cart.</li>';
    }
}

// Function to update cart button states
function updateCartButtonStates() {
    cart.forEach(courseId => {
        const cartButton = document.getElementById(`cart-btn-${courseId}`);
        if (cartButton) {
            cartButton.innerText = "Added to Cart"; // Change button text for courses in cart
        }
    });
    // Reset buttons for courses not in the cart
    const allButtons = document.querySelectorAll('.cart-btn');
    allButtons.forEach(button => {
        const courseId = button.id.split('-')[2]; // Extract course ID from button ID
        if (!cart.includes(parseInt(courseId))) {
            button.innerText = "Add to Cart"; // Reset to default if not in cart
        }
    });
}

// --------------------------- Enrollment Functions ---------------------------

// Function to open enrollment form
function openEnrollmentForm(courseId) {
    document.getElementById('course_id').value = courseId;
    document.getElementById('enrollmentFormModal').style.display = 'block';
}

// Function to close enrollment form
function closeEnrollmentForm() {
    document.getElementById('enrollmentFormModal').style.display = 'none';
}

// --------------------------- Notification Functions ---------------------------

// Function to toggle notification modal
function toggleNotificationModal() {
    console.log('Notification icon clicked'); // Log message for debugging
    const notificationModal = document.getElementById('notificationModal');
    if (notificationModal.style.display === 'block') {
        notificationModal.style.display = 'none'; // Hide the modal
    } else {
        notificationModal.style.display = 'block'; // Show the modal
        markNotificationsAsSeen(); // Mark notifications as seen when modal opens
    }
}

function closeNotificationModal() {
    const notificationModal = document.getElementById('notificationModal');
    notificationModal.style.display = 'none'; // Hide the modal
}

function markNotificationsAsSeen() {
    const email = document.getElementById('studentEmail').value; // Assuming you have the student's email in a hidden input
    if (email) {
        fetch('markNotificationsAsSeen.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email: email }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Notifications marked as seen');
            } else {
                console.error(data.error);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// --------------------------- Modal Functions ---------------------------

// Function to toggle cart modal
function toggleCartModal() {
    const cartModal = document.getElementById('cartModal');
    if (cartModal.style.display === 'block') {
        cartModal.style.display = 'none'; // Hide the cart modal
    } else {
        cartModal.style.display = 'block'; // Show the cart modal
    }
}

function closeCartModal() {
    const cartModal = document.getElementById('cartModal');
    cartModal.style.display = 'none'; // Hide the cart modal
}

// --------------------------- Cookie Functions ---------------------------

// Function to set cookies
function setCookie(name, value, days) {
    const expires = new Date(Date.now() + days * 864e5).toUTCString();
    document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=/';
}

// Function to get cookies
function getCookie(name) {
    return document.cookie.split('; ').reduce((r, c) => {
        const [key, val] = c.split('=');
        return key === name ? decodeURIComponent(val) : r;
    }, '');
}
