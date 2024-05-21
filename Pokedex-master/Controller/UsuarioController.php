<?php
session_start();
class UsuarioController
{
    private $model;
    private $presenter;

    public function __construct($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function login() {
        if (isset($_POST['usuario']) && isset($_POST['password'])) {
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];

            $result = $this->model->usuarioLogeado($usuario, $password);

            if ($result && $result->num_rows > 0) {
                // Login exitoso, redirigir o mostrar página de éxito
                $this->presenter->render("view/inicioView.mustache", ["usuario" => $usuario]);
            } else {
                // Login fallido, mostrar mensaje de error
                $this->presenter->render("view/loginView.mustache", ["error" => true, "errorMessages" => ["Credenciales incorrectas."]]);
            }
        } else {
            // Mostrar formulario de login si no se ha enviado ningún dato
            $this->presenter->render("view/loginView.mustache");
        }
    }
}
