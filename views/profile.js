function editField(field) {
    document.getElementById('field').value = field;
    const currentValue = document.getElementById(field + 'Display').textContent;
    document.getElementById('newValue').value = currentValue;
    document.getElementById('editFormModal').style.display = 'block';
}

function closeEditForm() {
    document.getElementById('editFormModal').style.display = 'none';
}
