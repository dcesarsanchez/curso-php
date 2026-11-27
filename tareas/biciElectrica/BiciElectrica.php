<?php
/**
 * Fichero: BiciElectrica.php
 * Implementa la clase para la gestión de bicicletas eléctricas.
 */
class BiciElectrica {

    // Atributos privados
    private int $id;         // Identificador de la bicicleta (entero)
    private int $coordx;     // Coordenada X (entero)
    private int $coordy;     // Coordenada Y (entero)
    private int $bateria;    // Carga de la batería en tanto por ciento (entero)
    private bool $operativa; // Estado de la bicicleta (true operativa - false no disponible)

    /**
     * Constructor para inicializar el objeto BiciElectrica.
     */
    public function __construct($id, $coordx, $coordy, $bateria, $operativa) {
        $this->id        = (int)$id;
        $this->coordx    = (int)$coordx;
        $this->coordy    = (int)$coordy;
        $this->bateria   = (int)$bateria;
        $this->operativa = (bool)(int)$operativa;   // "1" -> true, "0" -> false
    }

    /**
     * Métodos mágicos getter y setter
     */
    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }

    public function __set($name, $value) {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    /**
     * Método __toString
     * Devuelve el id de la bicicleta y el estado de la batería.
     */
    public function __toString(): string {
        return "Identificador: $this->id Bateria $this->bateria %";
    }

    /**
     * Devuelve la distancia entre las coordenadas pasadas como parámetro
     * y las coordenadas de la bicicleta.
     * Distancia entre dos puntos: d = √((x2 - x1)² + (y2 - y1)²)
     */
    public function distancia($x, $y): float {
        return sqrt(($this->coordx - $x) ** 2 + ($this->coordy - $y) ** 2);
    }
}
