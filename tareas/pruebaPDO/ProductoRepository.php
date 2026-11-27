<?php
require_once 'Producto.php';

// ---------------------------------------------------------
// 2. CLASE REPOSITORIO (Maneja la lógica PDO)
// ---------------------------------------------------------
class ProductoRepository {
    private PDO $pdo;

    // Inyección de dependencia: recibe la conexión ya creada
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // --- CREATE (Insertar) ---
    public function crear(Producto $producto): int {
        $sql = "INSERT INTO productos (nombre, precio, stock) VALUES (:nombre, :precio, :stock)";
        $stmt = $this->pdo->prepare($sql);

        // bindValue: toma el valor de la propiedad en este momento
        $stmt->bindValue(':nombre', $producto->nombre);
        $stmt->bindValue(':precio', $producto->precio);
        $stmt->bindValue(':stock',  $producto->stock, PDO::PARAM_INT);

        $stmt->execute();

        // Asignamos el ID generado al objeto
        $producto->id = (int)$this->pdo->lastInsertId();
        return $producto->id;
    }

    // --- READ (Leer todos) - Uso de FETCH_CLASS ---
    public function obtenerTodos(): array {
        $sql = "SELECT * FROM productos ORDER BY id";
        $stmt = $this->pdo->query($sql);

        // Cada fila se convierte directamente en un objeto Producto
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    // --- READ (Leer uno) ---
    public function obtenerPorId(int $id): Producto|false {
        $sql = "SELECT * FROM productos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // El resultado será un objeto Producto (o false si no existe)
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Producto');
        return $stmt->fetch();
    }

    // --- UPDATE (Actualizar) ---
    public function actualizar(Producto $producto): bool {
        $sql = "UPDATE productos SET nombre = :nombre, precio = :precio, stock = :stock WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':nombre', $producto->nombre);
        $stmt->bindValue(':precio', $producto->precio);
        $stmt->bindValue(':stock',  $producto->stock, PDO::PARAM_INT);
        $stmt->bindValue(':id',     $producto->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // --- DELETE (Eliminar) ---
    public function eliminar(int $id): int {
        $sql = "DELETE FROM productos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount(); // Número de filas borradas
    }
}
