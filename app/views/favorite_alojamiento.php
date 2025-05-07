<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alojamientos favoritos</title>
</head>

<body style="font-family: 'Open Sans', serif">

    <?php require "app/views/partials/navbar.php"; ?> <!-- NAVBAR -->

    <main class="container" style="margin-top: 9rem;">
        <h2 class="text-center pb-2">Alojamientos favoritos</h2>

        <?php if (!empty($favoritos)) { ?>
            <?php foreach ($favoritos as $favorito) { ?>
                <?php if ($favorito['eliminado'] == FALSE) { ?>
                    <div class="card mb-2 shadow-sm p-2 d-flex flex-row align-items-center gap-3">
                        <img src="<?= "/" . $_SESSION['rootFolder'] . htmlspecialchars($favorito['imagen']); ?>"
                            alt="Alojamiento <?= htmlspecialchars($favorito['nombre']); ?>"
                            style="width: 80px; height: 60px; object-fit: cover; border-radius: 6px;">

                        <div class="flex-grow-1">
                            <div class="fw-bold mb-1"><?= htmlspecialchars($favorito['id']); ?> - <?= htmlspecialchars($favorito['nombre']); ?></div>
                        </div>

                        <div class="me-3">
                            <a href="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/getAlojamiento?id=<?= $favorito['id']; ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-eye fs-5"></i></a>
                            <a href="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/getAlojamiento?id=<?= $favorito['id']; ?>" class="btn btn-sm btn-danger"><i class="fa-solid fa-heart-crack fs-5"></i></a>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

        <?php } else { ?>
            <p class="mt-3 text-center text-muted alert alert-warning d-flex flex-column align-items-center">
                <strong>Aún no tienes alojamientos favoritos. ¡Empieza a guardar tus próximas opciones!</strong>
                <a href="/<?= $_SESSION['rootFolder'] ?>/Home/index/" class="btn btn-dark col-3 mt-2">Ver alojamientos</a>
            </p>
        <?php } ?>

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