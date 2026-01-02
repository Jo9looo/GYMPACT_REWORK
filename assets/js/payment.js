function openPaymentModal(classId, className, price) {
    const modal = document.getElementById('paymentModal');
    document.getElementById('payClassId').value = classId;
    document.getElementById('payClassName').innerText = className;
    document.getElementById('payAmount').innerText = '$' + price;
    
    modal.style.display = 'flex';
}

function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
}

function processPayment(event) {
    event.preventDefault();
    
    const btn = document.getElementById('payBtn');
    const originalText = btn.innerText;
    
    // Simulate processing
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    btn.disabled = true;

    setTimeout(() => {
        // Submit the actual form
        document.getElementById('paymentForm').submit();
    }, 2000);
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('paymentModal');
    if (event.target == modal) {
        closePaymentModal();
    }
}
