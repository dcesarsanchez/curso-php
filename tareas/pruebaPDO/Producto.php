<?php
// ---------------------------------------------------------
// 1. CLASE MODELO (Entidad)
// ---------------------------------------------------------
class Producto {
    public $id;
    public $nombre;
    public $precio;
    public $stock;

    // Método auxiliar para mostrar info
    public function info(): string {
        return "[ID: {$this->id}] " . htmlspecialchars($this->nombre)
             . " - Precio: {$this->precio} € (Stock: {$this->stock})";
    }
}
