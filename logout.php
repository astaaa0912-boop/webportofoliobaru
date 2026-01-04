<?php
session_start();

// Menghapus semua variabel session
$_SESSION = array();

// Jika ingin menghapus session cookie (opsional tapi lebih aman)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Menghancurkan session
session_destroy();

// Notifikasi sistem laptop bahwa user berhasil logout
echo "<script>
        alert('Anda telah berhasil logout. Sampai jumpa!');
        window.location.href = 'login.php';
      </script>";
exit();
?>