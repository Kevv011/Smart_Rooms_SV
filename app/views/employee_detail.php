<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del empleado</title>
</head>

<body style="font-family: 'Open Sans', serif">

    <?php require "app/views/partials/navbar.php"; ?> <!-- NAVBAR -->

    <main class="container mb-3" style="margin-top: 150px;">
        <a href="/<?= $_SESSION['rootFolder'] ?>/Empleado/empleados" class="btn btn-dark mb-3">Regresar</a>

        <h2 class="mb-4 text-center text-capitalize"> <?= htmlspecialchars($empleadoById['nombre']); ?> <?= htmlspecialchars($empleadoById['apellido']); ?></h2>

        <div class="text-center mb-4">
            <i class="fa-solid fa-user-tie" style='font-size:100px'></i>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card-body p-0">
                    <p class="card-text fst-italic fs-5 pb-1 text-capitalize"><?= htmlspecialchars($empleadoById['rol']); ?></p>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><strong>Correo:</strong> <?= htmlspecialchars($empleadoById['correo']); ?></li>
                        <li class="mb-2"><strong>Telefono:</strong> <?= htmlspecialchars($empleadoById['telefono']); ?></li>
                        <li class="mb-2 text-capitalize"><strong>Estado:</strong> <?= htmlspecialchars($empleadoById['estado']); ?> </li>
                        <li class="mb-2"><strong>Fecha de registro:</strong> <?= (new DateTime($empleadoById['usuario_registro']))->format('d/m/Y H:i:s'); ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow p-4 bg-white">
                    <h4 class="mb-3">
                        <strong><strong>ID de empleado:</strong> <?= htmlspecialchars($empleadoById['id_empleado']); ?></strong> <!-- id_empleado de empleado -->
                    </h4>

                    <div class="border rounded">
                        <div class="row g-0">
                            <!-- Huéspedes -->
                            <div class="col-12 border-top p-3">
                                <ul class="list-unstyled mt-3">
                                    <li class="mb-2"><strong>Cargo:</strong> <?= htmlspecialchars($empleadoById['cargo']); ?></li>
                                    <li class="mb-2"><strong>Actualizado:</strong> <?= (new DateTime($empleadoById['actualizado_en']))->format('d/m/Y H:i:s'); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!--Botones para editar o Eliminar-->
                    <?php if ($_SESSION['user_role'] === "administrador") { ?>

                        <button type="button" id="editButton" class="btn w-100 mt-3 text-white mb-2" style="background: linear-gradient(to right,rgb(56, 109, 255),rgb(0, 218, 247)); border: none;">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Editar
                        </button>
                        <button type="button" class="btn btn-danger text-white mt-2" data-bs-toggle="modal" data-bs-target="#modalDelete"> <i class="fa-solid fa-trash me-1"></i>Eliminar</button>
                    <?php
                    }  ?>

                </div>
            </div>
        </div>

        <section id="editForm" class="mt-3" style="display: none;">

            <hr>

            <form action="/<?= $_SESSION['rootFolder'] ?>/Empleado/update_empleado" method="POST" enctype="multipart/form-data" class="container mt-4">
                <!-- Título -->
                <h4 class="text-center mb-4">Editar Información del Empleado</h4>

                <!-- id oculto -->
                <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($empleadoById['id_usuario']); ?>">

                <div class="row g-3">
                    <!-- Nombre -->
                    <div class="col-md-4">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control text-capitalize" id="nombre" name="nombre" value="<?= htmlspecialchars($empleadoById['nombre']); ?>" required>
                    </div>

                    <!-- Apellido -->
                    <div class="col-md-4">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control text-capitalize" id="apellido" name="apellido" value="<?= htmlspecialchars($empleadoById['apellido']); ?>" required>
                    </div>

                    <!-- Correo -->
                    <div class="col-md-4">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($empleadoById['correo']); ?>" required>
                    </div>

                    <!-- Rol -->
                    <input type="hidden" name="rol" value="empleado">

                    <!-- Cargo -->
                    <div class="col-md-6">
                        <label for="cargo" class="form-label">Cargo</label>
                        <input type="text" class="form-control" id="cargo" name="cargo" value="<?= htmlspecialchars($empleadoById['cargo']); ?>" required>
                    </div>

                    <!--Telefono-->
                    <div class="mb-3 col-6">
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
                            <?php
                            $phoneParts = explode(' ', $empleadoById['telefono'], 2);
                            $phoneCode = $phoneParts[0] ?? '+503';
                            $phoneNumber = $phoneParts[1] ?? '';
                            ?>
                            <input type="text" class="form-control border border-top-0" id="phone" name="phone" style="border-radius: 0 0 8px 8px; appearance: none;" value="<?= htmlspecialchars($phoneNumber); ?>" required>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-success me-2">Confirmar Información</button>
                        <a href="/<?= $_SESSION['rootFolder'] ?>/Empleado/detalle_empleado?id=<?= $empleadoById['id_usuario']; ?>" class="btn btn-warning">Cancelar</a>
                    </div>
                </div>
            </form>
        </section>

    </main>
    <?php require "app/views/partials/footer.php"; ?> <!-- FOOTER -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        //Hace aparecer el form de editar y desaparece el boton
        const editButton = document.getElementById('editButton');
        editButton.addEventListener("click", () => {

            const editForm = document.getElementById('editForm');
            editForm.style.display = "block";
            editButton.style.display = "none";
        });
        checkbox.addEventListener('change', toggleFileInput);
        toggleFileInput();
    </script>

    <!-- Manejo de alertas -->
    <?php if (isset($_GET['alert'])): ?>
        <script>
            let alertType = "<?php echo $_GET['alert']; ?>";
            let alertMessage = "<?php echo urldecode($_GET['message']); ?>";

            // Mostrar la alerta con SweetAlert
            if (alertType === "success") {
                Swal.fire({
                    title: '¡Éxito!',
                    text: alertMessage,
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir a la página principal o login después de cerrar la alerta
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Empleado/detalle_empleado?id=<?= $empleadoById['id_usuario']; ?>";
                });
            } else if (alertType === "error") {
                Swal.fire({
                    title: '¡Error!',
                    text: alertMessage,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir a la página principal o login después de cerrar la alerta
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Empleado/detalle_empleado?id=<?= $empleadoById['id_usuario']; ?>";
                });
            }
        </script>
    <?php endif; ?>

</body>

</html>