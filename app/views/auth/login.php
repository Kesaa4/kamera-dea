<div class="login-wrapper">
    <div class="login-container">
        <div class="login-header">
            <div class="login-icon">🔐</div>
            <h2>Sistem Peminjaman Alat</h2>
            <p>Silakan login untuk melanjutkan</p>
        </div>

        <form method="POST" action="?url=auth/login" class="login-form">

            <div class="form-group">
                <label for="email">📧 Email</label>
                <input type="email" 
                       id="email"
                       name="email" 
                       placeholder="Masukkan email Anda" 
                       required
                       autocomplete="email">
            </div>

            <div class="form-group">
                <label for="password">🔒 Password</label>
                <input type="password" 
                       id="password"
                       name="password" 
                       placeholder="Masukkan password Anda" 
                       required
                       autocomplete="current-password">
            </div>

            <button type="submit" class="login-btn">
                Masuk
            </button>

        </form>

        <div class="login-footer">
            <p>© 2026 Sistem Peminjaman Alat</p>
        </div>
    </div>
</div>

<?php
// echo password_hash("123456", PASSWORD_DEFAULT);

