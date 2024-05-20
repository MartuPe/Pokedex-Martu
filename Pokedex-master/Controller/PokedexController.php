<?php

class PokedexController
{
    private $model;
    private $presenter;

    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function get()
    {
        if (isset($_GET['eliminar'])) {
            $id_a_eliminar = $_GET['eliminar'];
            $this->model->eliminarPokemon($id_a_eliminar);
        }

        $pokemonData = $this->model->getPokemonData();

        // Preprocesar los tipos para cada Pokémon
        foreach ($pokemonData as &$pokemon) {
            if (isset($pokemon['tipos'])) {
                $pokemon['tipos'] = explode(', ', $pokemon['tipos']);
            } else {
                $pokemon['tipos'] = [];
            }
        }

        $this->presenter->render("view/paginaPrincipalView.mustache", ["pokemonData" => $pokemonData]);
    }

    public function mostrarBusqueda()
    {
        $this->presenter->render("view/buscarPokemonView.mustache", []);
    }


    public function buscarPokemon()
    {
        if (isset($_POST['buscar'])) {
            $palabraBuscada = $_POST['buscar'];
            $pokemon = $this->model->buscarPokemon($palabraBuscada);
            if (empty($pokemon)) {
                $this->get();
            } else {
                $this->presenter->render("view/buscarPokemonView.mustache", ["pokemonData" => $pokemon]);
            }
        } else {
            $this->get(); // Si no hay búsqueda, muestra toda la lista
        }
    }


}
