<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrador | Alojamientos</title>

    <!-- Link de archivo de estilos home.css -->
    <link href="/<?= $_SESSION['rootFolder'] ?>/public/css/home.css" rel="stylesheet">
</head>

<body style="font-family: 'Open Sans', serif">

    <?php require "app/views/partials/navbar.php"; ?> <!-- NAVBAR -->

    <main class="container" style="margin-top: 9rem;">

        <section class="d-flex flex-wrap justify-content-between">
            <!-- Boton para crear alojamiento -->
            <div>
                <a href='<?= "/" . $_SESSION['rootFolder'] . "/Alojamiento/create" ?>' class="btn btn-warning">+ Crear</a>
            </div>

            <!-- Ver alojamientos existentes y eliminados -->
            <div class="text-center">
                <div class="btn-group" role="group" aria-label="Opciones de alojamiento">
                    <input type="radio" class="btn-check" name="tipo_alojamiento" id="disponibles" autocomplete="off" checked onclick="showContent('alojamientos-disponibles')">
                    <label class="btn btn-outline-success" for="disponibles" id="label_disponibles">Disponibles</label>

                    <input type="radio" class="btn-check" name="tipo_alojamiento" id="eliminados" autocomplete="off" onclick="showContent('alojamientos-eliminados')">
                    <label class="btn btn-outline-dark" for="eliminados" id="label_eliminados">Eliminados</label>
                </div>
            </div>

            <!-- Form de busqueda de alojamientos -->
            <form action="#" class="d-flex col-12 col-lg-3">
                <div class="input-group mb-3">
                    <span class="input-group-text m-0 p-0 bg-dark" id="addon-wrapping">
                        <button type="submit" class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </span>
                    <input type="search" class="form-control" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </form>
        </section>

        <!-- Listado compacto de alojamientos disponibles y eliminados en renglones -->
        <section class="mt-4 mx-2 mx-md-3">
            <!-- ALOJAMIENTOS DISPONIBLES -->
            <div id="alojamientos-disponibles" class="show-content">
                <h2 class="text-center pb-2">Alojamientos Disponibles</h2>

                <?php if (!empty($alojamientos)) :
                    $alojamiento_disponible = false; ?>

                    <?php foreach ($alojamientos as $alojamiento): ?>
                        <?php if ($alojamiento['eliminado'] == FALSE) {
                            $alojamiento_disponible = true; ?>
                            <div class="card mb-2 shadow-sm p-2 d-flex flex-row align-items-center gap-3">
                                <img src="<?= "/" . $_SESSION['rootFolder'] . htmlspecialchars($alojamiento['imagen']); ?>"
                                    alt="Alojamiento <?= htmlspecialchars($alojamiento['nombre']); ?>"
                                    style="width: 80px; height: 60px; object-fit: cover; border-radius: 6px;">

                                <div class="flex-grow-1">
                                    <div class="fw-bold mb-1"><?= htmlspecialchars($alojamiento['id']); ?> - <?= htmlspecialchars($alojamiento['nombre']); ?></div>
                                </div>

                                <div class="me-3">
                                    <a href="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/getAlojamiento?id=<?= $alojamiento['id']; ?>" class="btn btn-sm btn-primary">Ver</a>
                                </div>
                            </div>
                        <?php } ?>
                    <?php endforeach; ?>

                    <?php if (!$alojamiento_disponible): ?>
                        <p class="mt-3 text-center text-muted alert alert-warning">
                            <strong>No hay alojamientos disponibles por el momento.</strong>
                        </p>
                    <?php endif; ?>

                <?php else: ?>
                    <p class="mt-3 text-center text-muted alert alert-warning">
                        <strong>No se encontraron alojamientos disponibles.</strong>
                    </p>
                <?php endif; ?>
            </div>

            <!-- ALOJAMIENTOS ELIMINADOS -->
            <div id="alojamientos-eliminados" class="show-content" style="display: none;">
                <h2 class="text-center pb-2">Alojamientos Eliminados</h2>

                <?php if (!empty($alojamientos)) :
                    $hayEliminados = false; ?>

                    <?php foreach ($alojamientos as $alojamiento): ?>
                        <?php if ($alojamiento['eliminado'] == TRUE) {
                            $hayEliminados = true; ?>
                            <div class="card mb-2 shadow-sm p-2 d-flex flex-row align-items-center gap-3">
                                <img src="<?= "/" . $_SESSION['rootFolder'] . htmlspecialchars($alojamiento['imagen']); ?>"
                                    alt="Alojamiento <?= htmlspecialchars($alojamiento['nombre']); ?>"
                                    style="width: 80px; height: 60px; object-fit: cover; border-radius: 6px;">

                                <div class="flex-grow-1">
                                    <div class="fw-bold mb-1"><?= htmlspecialchars($alojamiento['id']); ?> - <?= htmlspecialchars($alojamiento['nombre']); ?></div>
                                </div>

                                <div class="me-3">
                                    <a href="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/getAlojamiento?id=<?= $alojamiento['id']; ?>" class="btn btn-sm btn-primary">Ver</a>
                                </div>
                            </div>
                        <?php } ?>
                    <?php endforeach; ?>

                    <?php if (!$hayEliminados): ?>
                        <p class="mt-3 text-center text-muted alert alert-warning">
                            <strong>No hay alojamientos eliminados por el momento.</strong>
                        </p>
                    <?php endif; ?>

                <?php else: ?>
                    <p class="mt-3 text-center text-muted alert alert-warning">
                        <strong>No se encontraron alojamientos eliminados.</strong>
                    </p>
                <?php endif; ?>
            </div>
        </section>

    </main>
    <?php require "app/views/partials/footer.php"; ?> <!-- FOOTER -->

    <!-- Manejo de contenedores de alojamientos DISPONIBLES y ELIMINADOS -->
    <script>
        function showContent(id_alojamiento_container) {
            const a_disponible = document.getElementById("a_disponible");
            const a_eliminado = document.getElementById("a_eliminado");

            //Permite alternar el mostrar alojamientos disponibles y eliminados
            document.querySelectorAll('.show-content').forEach(div => div.style.display = 'none');
            document.getElementById(id_alojamiento_container).style.display = 'block';
        }
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
                    // Redirigir al panel de alojamientos
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Alojamiento/alojamientos/";
                });
            } else if (alertType === "error") {
                Swal.fire({
                    title: '¡Error!',
                    text: alertMessage,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir al panel de alojamientos
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Alojamiento/alojamientos/";
                });
            }
        </script>
    <?php endif; ?>

    <!--BOOTSTRAP JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>