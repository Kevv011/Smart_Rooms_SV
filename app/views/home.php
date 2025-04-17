<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smart Rooms SV | Alojamientos de El Salvador</title>

    <!-- Link de archivo de estilos home.css -->
    <link href="/<?= $_SESSION['rootFolder'] ?>/public/css/home.css" rel="stylesheet">
</head>

<body style="font-family: 'Open Sans', serif">

    <?php require "app/views/partials/navbar.php"; ?> <!-- NAVBAR -->

    <main>
        <div class="central-container d-flex flex-column justify-content-center align-items-center">

            <!--SECTION de contenido-->
            <section class="container d-flex flex-column">
                <div>
                    <p class="title-text text-white text-center">Encuentra el descanso que mereces</p>
                    <p class="subtitle-text text-white text-center">Escoge entre alojamientos en lugares únicos, ideales
                        para desconectar del día a día.</p>
                </div>
                <div class="line-separator my-4 text-black">.</div>
                <div class="text-center">
                    <button class="btn btn-dark border" type="button" onclick="location.href='#cards-presentation'">Ver
                        alojamientos</button>
                </div>
            </section>
        </div>

        <?php include "app/views/partials/card-container-decoration.php"; ?> <!--CONTENEDOR de cards de decoracion-->

        <div class="container d-flex justify-content-center my-5">
            <div class="text-white bg-dark" style="height:1px; width:100%;">.</div>
        </div>

        <!-- Sección de alojamientos ingresados -->
        <section class="my-4">
            <!-- Barra de búsqueda -->
            <div class="text-center">
                <h1>Explora casas y hoteles, encuentra el lugar ideal</h1>
                <form class="container form-buscar d-flex gap-2 mt-4" action="">
                    <input type="search" name="buscarAlojamiento" class="form-control rounded-pill"
                        placeholder="Busca un alojamiento...">
                    <button class="btn btn-light rounded-circle" type="submit" style="background:orange;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>

            <!--Cards de Alojamientos-->
            <div id="cards-presentation" class="row mt-5 mx-2 mx-md-3">
                <?php if (!empty($alojamientos)): ?>
                    <?php foreach ($alojamientos as $alojamiento): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card position-relative border-0 shadow-sm">
                                <div class="img-card-alojamiento position-relative">
                                    <a class="text-dark text-decoration-none" href="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/getAlojamiento?id=<?= $alojamiento['id']; ?>" target="_self">
                                        <img class="img-alojamiento img-fluid rounded-top"
                                            src="<?= "/" . $_SESSION['rootFolder'] . htmlspecialchars($alojamiento['imagen']); ?>"
                                            alt="Alojamiento <?= htmlspecialchars($alojamiento['nombre']); ?>"
                                            style="object-fit: cover; width: 100%; height: 200px;">
                                    </a>
                                </div>
                                <div class="card-body border-0 px-0">
                                    <strong class="text-capitalize d-block"><?= htmlspecialchars($alojamiento['nombre']); ?></strong>
                                    <div class="d-flex gap-2 align-items-center">
                                        <i class="fa-solid fa-person text-muted"></i>
                                        <small class="text-muted">
                                            <?= htmlspecialchars($alojamiento['minpersona']) . " - " . htmlspecialchars($alojamiento['maxpersona']); ?> personas
                                        </small>
                                    </div>
                                    <small class="text-muted text-capitalize d-block"><?= htmlspecialchars($alojamiento['departamento']); ?></small>
                                    <div class="d-flex gap-1 align-items-center mt-2">
                                        <strong>$<?= htmlspecialchars(number_format($alojamiento['precio'], 2)); ?> USD</strong>
                                        <small>/ noche</small>
                                    </div>
                                    <?php if ($alojamiento['mascota']): ?>
                                        <span class="badge bg-success mt-2">Pet friendly</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary mt-2">Sin mascotas</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="mt-3 text-center text-muted alert alert-warning">
                        <strong>No hay alojamientos disponibles por el momento.</strong>
                    </p>
                <?php endif; ?>
            </div>

        </section>

    </main>
    <?php require "app/views/partials/footer.php"; ?> <!-- FOOTER -->

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
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Home/index/";
                });
            } else if (alertType === "error") {
                Swal.fire({
                    title: '¡Error!',
                    text: alertMessage,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir a la página principal o login después de cerrar la alerta
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Home/index/";
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