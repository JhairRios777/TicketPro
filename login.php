<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema Web</title>
    
    <!-- Bootstrap CSS -->
    <link href="Content/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="Content/dist/css/custom-themes.css" rel="stylesheet">
    <link href="Content/dist/css/login.css" rel="stylesheet">
    
    <!-- Font Awesome para iconos (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="login-body">
    <!-- Botón de modo oscuro -->
    <button class="btn-theme-toggle-login" id="themeToggleLogin" type="button" aria-label="Alternar tema">
        <i class="fas fa-moon" id="themeIconLogin"></i>
    </button>
    
    <div class="login-container">
        <div class="login-wrapper">
            <!-- Logo y título -->
            <div class="login-header text-center mb-5">
                <div class="login-logo mb-4">
                    <div class="logo-glow"></div>
                    <i class="fas fa-cube"></i>
                </div>
                <h1 class="login-title mb-2">Bienvenido</h1>
                <p class="login-subtitle">Ingresa tus credenciales para continuar</p>
            </div>

            <!-- Formulario de login -->
            <div class="login-card">
                <form id="loginForm">
                    <!-- Campo de usuario -->
                    <div class="form-floating-modern mb-4">
                        <div class="input-wrapper">
                            <i class="input-icon fas fa-user"></i>
                            <input type="text" class="form-control-modern" id="username" 
                                  placeholder=" " required autofocus>
                            <label for="username" class="floating-label">Usuario</label>
                            <div class="input-line"></div>
                        </div>
                    </div>

                    <!-- Campo de contraseña -->
                    <div class="form-floating-modern mb-4">
                        <div class="input-wrapper">
                            <i class="input-icon fas fa-lock"></i>
                            <input type="password" class="form-control-modern" id="password" 
                                  placeholder=" " required>
                            <label for="password" class="floating-label">Contraseña</label>
                            <div class="input-line"></div>
                            <button class="btn-toggle-password" type="button" id="togglePassword" tabindex="-1">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Recordar sesión y olvidé contraseña -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">
                                Recordar sesión
                            </label>
                        </div>
                        <a href="#" class="text-decoration-none forgot-password">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <!-- Botón de login -->
                    <button type="submit" class="btn btn-login-modern w-100 mb-4">
                        <span class="btn-text">
                            <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                        </span>
                        <span class="btn-loader"></span>
                    </button>

                    <!-- Divider -->
                    <div class="divider my-4">
                        <span>o</span>
                    </div>

                    <!-- Botones sociales (opcional) -->
                    <div class="social-login">
                        <button type="button" class="btn btn-social btn-google w-100 mb-3">
                            <i class="fab fa-google"></i>
                            <span>Continuar con Google</span>
                        </button>
                        <button type="button" class="btn btn-social btn-microsoft w-100">
                            <i class="fab fa-microsoft"></i>
                            <span>Continuar con Microsoft</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer del login -->
            <div class="login-footer text-center mt-4">
                <p class="text-muted mb-0">
                    ¿No tienes una cuenta? 
                    <a href="#" class="text-decoration-none">Regístrate aquí</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="Content/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS para login -->
    <script src="Content/dist/js/login.js"></script>
    
    <!-- Custom JS para tema oscuro en login -->
    <script src="Content/dist/js/login-theme.js"></script>
</body>
</html>

