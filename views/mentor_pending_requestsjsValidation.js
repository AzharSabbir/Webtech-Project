// mentor_pending_requestsjsValidation.js

// Show rejection reason input when 'Reject' is selected
function showRejectReason(radio) {
    var form = radio.closest('form');
    var rejectReasonDiv = form.querySelector('[id^=reject-reason]');
    rejectReasonDiv.style.display = 'block';
}

// Hide rejection reason input when 'Accept' is selected
function hideRejectReason(radio) {
    var form = radio.closest('form');
    var rejectReasonDiv = form.querySelector('[id^=reject-reason]');
    rejectReasonDiv.style.display = 'none';
}

// Validate form before submission
function validateForm(form) {
    var action = form.querySelector('input[name="action"]:checked').value;
    if (action === 'reject') {
        var reasonInput = form.querySelector('[name="reason"]');
        if (!reasonInput.value.trim()) {
            alert("Please provide a reason for rejection.");
            return false;
        }
    }
    return true;
}
