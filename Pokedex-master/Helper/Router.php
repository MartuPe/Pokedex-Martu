<?php

class Router
{


    public function __construct()
    {
    }

    public function route($controller ,$action)
    {
        switch ($controller){

            case 'PaginaDeVisualizacion':
                $id = $_GET['id'];
                $paginaDeVisualizacionController = Configuration::GetPaginaDeVisualizacionController();
                $paginaDeVisualizacionController->get($id);
                break;

            case 'BuscarPokemon':
                $pokemonController = Configuration::GetPokedexController();

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $pokemonController->buscarPokemon();
                } else {
                    // Si la búsqueda no es un POST, muestra una página de búsqueda o algún comportamiento por defecto
                    $pokemonController->mostrarBusqueda();
                }
                break;

            case 'PaginaDeCreacion':
                $paginaDeCreacionController = Configuration::GetPaginaDeCreacionController();

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                    $paginaDeCreacionController->insertar();


                } else {

                    $id = $_GET['id'];
                    $paginaDeCreacionController->get($id);
                }
                break;
            default:

                $PokedexController=Configuration::GetPokedexController();

                $PokedexController->get();
                break;
        }
    }
}