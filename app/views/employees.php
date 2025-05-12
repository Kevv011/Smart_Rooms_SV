<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrador | Empleados</title>

    <!-- Link de archivo de estilos home.css -->
    <link href="/<?= $_SESSION['rootFolder'] ?>/public/css/home.css" rel="stylesheet">
</head>

<body style="font-family: 'Open Sans', serif">

    <?php require "app/views/partials/navbar.php"; ?> <!-- NAVBAR -->

    <main class="container" style="margin-top: 9rem;">

        <section class="d-flex flex-wrap justify-content-between">
            <!-- Boton para crear alojamiento -->
            <div>
                <a href='' class="btn btn-warning">+ Añadir empleado</a>
            </div>

            <!-- Ver alojamientos existentes y eliminados -->
            <div class="text-center">
                <div class="btn-group" role="group" aria-label="Opciones de alojamiento">
                    <input type="radio" class="btn-check" name="tipo_alojamiento" id="disponibles" autocomplete="off" checked onclick="showContent('empleados-disponibles')">
                    <label class="btn btn-outline-success" for="disponibles" id="label_disponibles">Activos</label>

                </div>
            </div>
        </section>

        <!-- Listado compacto de alojamientos disponibles y eliminados en renglones -->
        <section class="mt-4 mx-2 mx-md-3">
            <!-- ALOJAMIENTOS DISPONIBLES -->
            <div id="empleados-disponibles" class="show-content">
                <h2 class="text-center pb-2">Empleados Disponibles</h2>

                <?php if (!empty($empleados)) : ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Fecha creación</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($empleados as $empleado): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($empleado['id']); ?></td>
                                        <td class="text-capitalize"><?= htmlspecialchars($empleado['nombre']); ?> <?= htmlspecialchars($empleado['apellido']); ?></td>
                                        <td><?= htmlspecialchars((new DateTime($empleado['fecha_registro']))->format('d/m/Y')); ?></td>
                                        <td class="col-1">

                                            <form action="/<?= $_SESSION['rootFolder'] ?>/Empleado/post_detalle_empleado" method="POST">
                                                <input type="hidden" value="<?= $empleado['id'] ?>" name="id_usuario">
                                                <button type="submit" class="btn btn-sm btn-primary">Ver</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="mt-3 text-center text-muted alert alert-warning">
                        <strong>No se encontraron empleados disponibles.</strong>
                    </p>
                <?php endif; ?>
            </div>
        </section>

    </main>
    <?php require "app/views/partials/footer.php"; ?> <!-- FOOTER -->

    <!--BOOTSTRAP JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

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
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Empleado/empleados";
                });
            } else if (alertType === "error") {
                Swal.fire({
                    title: '¡Error!',
                    text: alertMessage,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir a la página principal o login después de cerrar la alerta
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Empleado/empleados";
                });
            }
        </script>
    <?php endif; ?>

</body>

</html>