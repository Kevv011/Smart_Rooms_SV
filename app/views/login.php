<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro</title>
</head>

<body>
    <div class="register-container">
        <form action="/<?= $_SESSION['rootFolder'] ?>/Auth/login" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope icon" style="color: #3493d3"></i> Correo Electrónico
                </label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="fas fa-lock icon" style="color: #3493d3"></i> Contraseña
                </label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
            </div>
            <div class="text-center">
                <p>¿No tienes una cuenta?
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#register" style="color: #3493d3">Registrarse</button>
                </p>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn text-white fw-bold" style="background-color: #3493d3">Iniciar Sesión</button>
            </div>
        </form>
    </div>
</body>

</html>