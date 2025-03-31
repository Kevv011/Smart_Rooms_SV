<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Link de archivo de estilos register.css -->
    <link href="/<?= $_SESSION['rootFolder'] ?>/public/css/register.css" rel="stylesheet">
</head>

<body>
    <div class="register-container">
        <form action="/<?= $_SESSION['rootFolder'] ?>/Auth/register" method="POST">

            <p class="fw-bold fs-5 mb-3">¡Te damos la bienvenida a Smart Rooms SV!</p>

            <!--Correo-->
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope icon" style="color: #3493d3"></i> Correo
                </label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <!--Nombres y apelidos-->
            <div class="d-flex justify-content-between">
                <div class="mb-3 me-1 me-md-0">
                    <label for="name" class="form-label">
                        <i class="fas fa-user icon" style="color: #3493d3"></i> Nombres
                    </label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="surname" class="form-label">
                        <i class="fas fa-user icon" style="color: #3493d3"></i> Apellidos
                    </label>
                    <input type="text" class="form-control" id="surname" name="surname" required>
                </div>
            </div>

            <!--Telefono-->
            <div class="mb-3">
                <label for="phone" class="form-label">
                    <i class="fa-solid fa-phone" style="color: #3493d3"></i> Teléfono
                </label>
                <div>
                    <select class="form-select" style="border-radius: 8px 8px 0 0;" name="phone-code" required>
                        <option disabled>Selecciona un país</option>
                        <option value="+61">Australia (+61)</option>
                        <option value="+54">Argentina (+54)</option>
                        <option value="+55">Brasil (+55)</option>
                        <option value="+1">Canadá (+1)</option>
                        <option value="+56">Chile (+56)</option>
                        <option value="+86">China (+86)</option>
                        <option value="+57">Colombia (+57)</option>
                        <option value="+506">Costa Rica (+506)</option>
                        <option value="+53">Cuba (+53)</option>
                        <option value="+593">Ecuador (+593)</option>
                        <option value="+20">Egipto (+20)</option>
                        <option selected value="+503">El Salvador (+503)</option>
                        <option value="+34">España (+34)</option>
                        <option value="+1">Estados Unidos (+1)</option>
                        <option value="+33">Francia (+33)</option>
                        <option value="+49">Alemania (+49)</option>
                        <option value="+502">Guatemala (+502)</option>
                        <option value="+504">Honduras (+504)</option>
                        <option value="+91">India (+91)</option>
                        <option value="+81">Japón (+81)</option>
                        <option value="+52">México (+52)</option>
                        <option value="+505">Nicaragua (+505)</option>
                        <option value="+507">Panamá (+507)</option>
                        <option value="+595">Paraguay (+595)</option>
                        <option value="+51">Perú (+51)</option>
                        <option value="+44">Reino Unido (+44)</option>
                        <option value="+7">Rusia (+7)</option>
                        <option value="+1">República Dominicana (+1)</option>
                        <option value="+82">Corea del Sur (+82)</option>
                        <option value="+27">Sudáfrica (+27)</option>
                        <option value="+90">Turquía (+90)</option>
                        <option value="+598">Uruguay (+598)</option>
                        <option value="+58">Venezuela (+58)</option>
                        <option value="+39">Italia (+39)</option>
                        <option value="+971">Emiratos Árabes Unidos (+971)</option>
                    </select>
                    <input type="number" class="form-control border border-top-0 phone-input" id="phone" name="phone" style="border-radius: 0 0 8px 8px; appearance: none;" required>
                </div>
            </div>

            <!--Contraseña-->
            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="fas fa-lock icon" style="color: #3493d3"></i> Contraseña
                </label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <!--Iniciar sesion si existe una cuenta-->
            <div class="text-center">
                <p>¿Ya tienes una cuenta?
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#login" style="color: #3493d3">Iniciar Sesión</button>
                </p>
            </div>

            <!--Boton para confirmar registro-->
            <div class="d-grid">
                <button type="submit" class="btn text-white fw-bold" style="background-color: #3493d3">Registrarse</button>
            </div>
        </form>
    </div>
</body>

</html>