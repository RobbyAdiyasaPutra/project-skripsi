import './bootstrap';
// Mendengarkan channel untuk pengguna tertentu
const userId = window.userId;  // Pastikan userId ada di JavaScript atau di-passing ke view
Echo.channel('App.Models.User.' + userId)
    .listen('MessageSent', (event) => {
        console.log(event.message);  // Proses pesan yang diterima
    });
