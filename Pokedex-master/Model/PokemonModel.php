<?php

class PokemonModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getPokemonData()
    {
        $sql = "SELECT * FROM apipokemon";
        return $this->database->query($sql);

    }

    public function buscarPokemon($palabraBuscada = "")
    {
        $sql = "SELECT * FROM apipokemon WHERE tipo = '$palabraBuscada'  OR 
                nombre = '$palabraBuscada' OR numero = '$palabraBuscada'";

        return $this->database->query($sql);
    }


    public function buscarPokemonId($id)
    {
        $sql = "SELECT * FROM apipokemon WHERE id = '$id'";

        return $this->database->query($sql);

    }

    public function obtenerIdTipo($tipo)
    {

        $sql = "SELECT id FROM tipo WHERE nombre = ?";
        $stmt = $this->database->prepare($sql);
        $stmt->bind_param("s", $tipo);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row ? $row['id'] : null; // Devuelve el ID del tipo o null si no se encuentra
    }

    public function insertarPokemon($imagenPokemon, $imagenTipo, $nombre, $numero, $descripcion, $tipo)
    {
        $sql = "INSERT INTO apipokemon (imagenPokemon, imagenTipo, nombre, numero, descripcion, tipo)
                VALUES ('$imagenPokemon', '$imagenTipo', '$nombre', $numero, '$descripcion', '$tipo')";

        $this->database->execute($sql);


    }


    public function insertarTipoPokemon($pokemon_id, $tipo_id)
    {
        $pokemon_id = intval($pokemon_id); // Asegurarse de que $pokemon_id sea un entero
        $tipo_id = intval($tipo_id); // Asegurarse de que $tipo_id sea un entero

        // Crear la consulta SQL para insertar un nuevo tipo de Pokémon
        $sql = "INSERT INTO pokemon_tipo (pokemon_id, tipo_id)
                VALUES ($pokemon_id, $tipo_id)";

        $this->database->execute($sql);
    }

    public function eliminarPokemon($id_a_eliminar)
    {

        $sql = "DELETE FROM apipokemon WHERE id = '$id_a_eliminar'";
        $this->database->execute($sql);

    }

    public function obtenerTiposDisponibles()
    {
        $sql = "SELECT nombre FROM tipo";
        return $this->database->query($sql);
    }

}