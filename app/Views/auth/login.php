<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Asset Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            min-height: 100vh;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .login-header {
            background: #0d6efd;
            color: white;
            padding: 32px;
            text-align: center;
        }

        .login-logo {
            width: 110px;
            height: 80px;
            object-fit: contain;
            background: rgba(255,255,255,0.15);
            border-radius: 14px;
            padding: 8px;
        }

        .login-body {
            padding: 35px;
        }

        .form-control,
        .input-group-text,
        .btn {
            border-radius: 10px;
        }

        .btn-login {
            padding: 12px;
            font-weight: bold;
        }

        .system-title {
            font-size: 22px;
            font-weight: bold;
        }

        .system-subtitle {
            font-size: 14px;
            opacity: .9;
        }

        .footer-login {
            font-size: 13px;
            opacity: .85;
            line-height: 1.7;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height:100vh;">
        <div class="col-lg-4 col-md-6">

            <div class="card shadow-lg login-card">
                <div class="login-header">
                    <img src="<?= base_url('assets/img/logo-ams.png'); ?>"
                         alt="Logo AMS"
                         class="login-logo">

                    <div class="system-title mt-3">
                        Asset Management System
                    </div>

                    <div class="system-subtitle">
                        Enterprise Asset Monitoring & Cost Tracking
                    </div>
                </div>

                <div class="login-body">
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error'); ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/login/proses'); ?>" method="post">
                        <div class="mb-3">
                            <label class="form-label">Email</label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="Masukkan email"
                                    required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    placeholder="Masukkan password"
                                    required>

                                <button type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="togglePassword()">
                                    <i class="bi bi-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-login">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Login
                        </button>
                    </form>
                </div>
            </div>

            <div class="text-center text-white mt-4 footer-login">
                Asset Management System v1.0
                <br>
                Enterprise Asset Monitoring & Cost Tracking
                <br>
                © 2026 All Rights Reserved
            </div>

        </div>
    </div>
</div>

<script>
    function togglePassword()
    {
        const password = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');

        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>

</body>
</html>