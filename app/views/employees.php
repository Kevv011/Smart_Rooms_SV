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
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($empleados as $empleado): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($empleado['id']); ?></td>
                                        <td class="text-capitalize"><?= htmlspecialchars($empleado['nombre']); ?> <?= htmlspecialchars($empleado['apellido']); ?></td>
                                        <td>
                                            <a href="/<?= $_SESSION['rootFolder'] ?>/Usuario/getUsuario?id=<?= $empleado['id']; ?>" class="btn btn-sm btn-primary">
                                                Ver
                                            </a>
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

</body>

</html>