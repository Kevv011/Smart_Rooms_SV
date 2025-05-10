<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservaciones</title>
</head>

<body style="font-family: 'Open Sans', serif">

    <?php require "app/views/partials/navbar.php"; ?> <!-- NAVBAR -->

    <main class="container mb-3" style="margin-top: 150px;">
        <table class="table table-hover mt-4 text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th class="d-none d-md-table-cell">Imagen</th>
                    <th>Nombre del Alojamiento</th>
                    <th>Fecha de Reservación</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reservaciones)): ?>
                    <?php foreach ($reservaciones as $reserva): ?>
                        <tr>
                            <td><?= htmlspecialchars($reserva['id']) ?></td>
                            <td class="d-none d-md-table-cell">
                                <?php if (!empty($reserva['imagen'])): ?>
                                    <img src="/<?= $_SESSION['rootFolder'] ?>/<?= htmlspecialchars($reserva['imagen']) ?>" alt="Imagen" width="50" height="50" style="object-fit: cover; border-radius: 5px;">
                                <?php else: ?>
                                    <span class="text-muted">Sin imagen</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($reserva['nombre_alojamiento']) ?></td>
                            <td><?= date("d/m/Y", strtotime($reserva['fecha_reservacion'])) ?></td>
                            <td>
                                <span class="badge text-dark
                            <?= $reserva['estado'] === 'pendiente' ? 'bg-warning' : ($reserva['estado'] === 'confirmada' ? 'bg-success' : ($reserva['estado'] === 'cancelada' ? 'bg-danger' : 'bg-secondary')) ?>">
                                    <?= ucfirst($reserva['estado']) ?>
                                </span>
                            </td>
                            <td>
                                <form action="/<?= $_SESSION['rootFolder'] ?>/Reservation/post_reservacion_alojamiento" method="POST">
                                    <input type="hidden" name="id_reservacion" value="<?= $reserva['id'] ?>">
                                    <input type="hidden" name="id_alojamiento" value="<?= $reserva['id_alojamiento'] ?>">
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-eye"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No se encontraron reservaciones.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <?php require "app/views/partials/footer.php"; ?> <!-- FOOTER -->

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Reservation/mis_reservaciones";
                });
            } else if (alertType === "error") {
                Swal.fire({
                    title: '¡Error!',
                    text: alertMessage,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir a la página principal o login después de cerrar la alerta
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Reservation/mis_reservaciones";
                });
            }
        </script>
    <?php endif; ?>

</body>

</html>