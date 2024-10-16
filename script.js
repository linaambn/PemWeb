document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const alert = document.getElementById('alert');
    const alertMessage = document.getElementById('alertMessage');
    const closeAlert = document.getElementById('closeAlert');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const Alamat_lengkap = document.getElementById('Alamat lengkap').value.trim();

        if (name === '' || email === '' || Alamat_lengkap === '') {
            showAlert('Semua data harus diisi.');
        } else {
            // Di sini Anda bisa menambahkan kode untuk mengirim data ke server
            console.log('Form submitted:', { name, email });
            form.reset();
        }
    });

    function showAlert(message) {
        alertMessage.textContent = message;
        alert.style.display = 'block';
    }

    closeAlert.addEventListener('click', function() {
        alert.style.display = 'none';
    });
});