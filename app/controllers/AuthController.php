<?php

require_once "app/models/AuthModel.php";

class AuthController
{
    private $AuthModel;

    public function __construct()
    {
        // Crea una instancia del modelo de Usuario
        $this->AuthModel = new AuthModel();
    }

    // Metodo para manejar el registro de clientes
    public function register()
    {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $phone = $_POST['phone-code'] . ' ' . $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = 'cliente';

        // Verifica si el correo ya está registrado
        $emailExists = $this->AuthModel->getUserByEmail($email);
        if ($emailExists) {
            header("Location: /" . $_SESSION['rootFolder'] . "/Home/index?alert=error&message=" . urlencode("El correo ya está registrado."));
            return;
        }

        // Verifica si el numero de telefono ya está registrado
        $phoneExists = $this->AuthModel->getUserByPhoneNumber($phone);
        if ($phoneExists) {
            header("Location: /" . $_SESSION['rootFolder'] . "/Home/index?alert=error&message=" . urlencode("El número de teléfono ya está registrado."));
            return;
        }

        // Hash de la contraseña
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Registro del nuevo usuario
        $createUser = $this->AuthModel->createUser($name, $surname, $phone, $email, $passwordHash, $role);

        if ($createUser) {
            echo "Registro exitoso. Ahora puedes iniciar sesión.";
            header("Location: /" . $_SESSION['rootFolder'] . "/Home/index?alert=success&message=" . urlencode("Registro exitoso. Ahora puedes iniciar sesión"));
        } else {
            header("Location: /" . $_SESSION['rootFolder'] . "/Home/index?alert=error&message=" . urlencode("Hubo un problema al registrar el usuario. Por favor intenta de nuevo"));
        }
        exit();
    }

    // Función para manejar el inicio de sesión
    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        //Verifica las credenciales antes de iniciar sesion
        $user = $this->AuthModel->verifyCredentials($email, $password);

        if ($user) {

            //Variables de SESION para manejarse en la plataforma
            session_start();
            $_SESSION['id_user'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_role'] = $user['rol'];

            header("Location: /" . $_SESSION['rootFolder'] . "/Home/index?alert=success&message=" . urlencode("Sesión iniciada con exito"));
            exit();
        } else {
            header("Location: /" . $_SESSION['rootFolder'] . "/Home/index?alert=error&message=" . urlencode("Correo o contraseña incorrectos. Intente nuevamente"));
        }
    }

    // Metodo para cerrar la sesion
    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: /" . $_SESSION['rootFolder'] . "/Home/index?alert=success&message=" . urlencode("Ha cerrado la sesión"));
        exit();
    }
}
