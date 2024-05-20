<?php

class PaginaDeCreacionController
{


    private $model;
    private $presenter;

    public function __construct($PokemonModel, $Presenter)
    {
        $this->model = $PokemonModel;
        $this->presenter = $Presenter;
    }

    public function get($id)
    {
        if ($id === 'nuevo') {

            $this->presenter->render("view/PaginaCreacionView.mustache");
        } else {
            $this->editar($id);
        }
    }

    public function editar($id)
    {

        $pokemonData = $this->model->buscarPokemonId($id);
        // var_dump($pokemonData );
        $this->presenter->render("view/PaginaEdicionView.mustache", ["pokemonData" => $pokemonData]);
    }

    public function insertar()
    {
        $nombre = $_POST['nombre'];
        $numero = $_POST['numeroPokemon'];
        $descripcion = $_POST['descripcion'];
        $tipo = $_POST['tipoPokemon'];

        $directorio_destino = 'img/pokemon/';
        $imagenP = null;
        $imagenT = null;

        if (isset($_FILES['fotoPokemon'])) {
            $imagenP = $_FILES['fotoPokemon']['name'];
            $archivo_temporal = $_FILES['fotoPokemon']['tmp_name'];
            move_uploaded_file($archivo_temporal, $directorio_destino . $imagenP);
        }

        if (isset($_FILES['fotoTipo'])) {
            $imagenT = $_FILES['fotoTipo']['name'];
            $archivo_temporal = $_FILES['fotoTipo']['tmp_name'];
            move_uploaded_file($archivo_temporal, $directorio_destino . $imagenT);
        }

        $this->model->insertarPokemon($imagenP, $imagenT, $nombre, $numero, $descripcion, $tipo);

        header("Location: index.php");
        exit();
    }


    public function editarPokemon()
    {
        $id_a_eliminar = $_POST['id'];
        $this->model->eliminarPokemon($id_a_eliminar);
        $this->insertar();
    }
}