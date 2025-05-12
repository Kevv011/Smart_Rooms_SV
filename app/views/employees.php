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

                <?php 
                if (!empty($usuarios)) :
                    $alojamiento_disponible = false; ?>

                    <?php foreach ($usuarios as $usuario): ?>
                        <?php if ($usuario['rol'] == 'empleado') {
                            $alojamiento_disponible = true; ?>
                            <div class="card mb-2 shadow-sm p-2 d-flex flex-row align-items-center gap-3">
                                <i class="fa-solid fa-user fs-5 me-2"></i>

                                <div class="flex-grow-1">
                                    <div class="fw-bold mb-1"><?= htmlspecialchars($usuario['id']); ?> - <?= htmlspecialchars($usuario['nombre']); ?></div>
                                </div>

                                <div class="me-3">
                                    <a href="/<?= $_SESSION['rootFolder'] ?>/Usuario/getUsuario?id=<?= $usuario['id']; ?>" class="btn btn-sm btn-primary">Ver</a>
                                </div>
                            </div>
                        <?php } ?>
                    <?php endforeach; ?>

                    <?php if (!$alojamiento_disponible): ?>
                        <p class="mt-3 text-center text-muted alert alert-warning">
                            <strong>No hay empleados disponibles por el momento.</strong>
                        </p>
                    <?php endif; ?>

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