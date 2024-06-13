<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Información de encabezado -->
        <h3>Daniel Alejandro Trujillo Lòpez</h3>
        <h3>9A DyGS</h3>
        <h2>Operaciones Básicas</h2>

        <!-- Formulario para ingresar valores y seleccionar operación -->
        <form method="POST">
            <div class="input-group">
                <label for="valor1">Número 1:</label>
                <input type="number" id="valor1" name="valor1" required>
            </div>
            <div class="input-group">
                <label for="valor2">Número 2:</label>
                <input type="number" id="valor2" name="valor2" required>
            </div>
            <div class="button-group">
                <button type="submit" name="operacion" value="sumar">Sumar</button>
                <button type="submit" name="operacion" value="restar">Restar</button>
                <button type="submit" name="operacion" value="multi">Multipplicacion</button>
                <button type="submit" name="operacion" value="div">Division</button>
            </div>
        </form>

        <!-- proceso la solicitud del formulario -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // **Validar datos de entrada**
            $valor1 = filter_input(INPUT_POST, 'valor1', FILTER_VALIDATE_INT);
            $valor2 = filter_input(INPUT_POST, 'valor2', FILTER_VALIDATE_INT);
            $operacion = filter_input(INPUT_POST, 'operacion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $errores = [];

            if ($valor1 === false) {
                $errores[] = "El valor 1 no es un número válido.";
            }

            if ($valor2 === false) {
                $errores[] = "El valor 2 no es un número válido.";
            }

            if (empty($operacion) || !in_array($operacion, ['sumar', 'restar', 'multi', 'div'])) {
                $errores[] = "Operación no válida.";
            }

            // Manejar errores o procesar cálculo
            if (empty($errores)) {
                try {
                    $resultado = 0;

                    // **Realizar cálculo según la operación seleccionada**
                    if ($operacion == "sumar") {
                        $resultado = $valor1 + $valor2;
                    } elseif ($operacion == "restar") {
                        $resultado = $valor1 - $valor2;
                    } elseif ($operacion == "multi") {
                        $resultado = $valor1 * $valor2;
                    }elseif ($operacion == "div") {
                        if ($valor2 == 0) {
                            echo "Error: No se puede dividir por cero.";
                        } else {
                            $resultado = $valor1 / $valor2;
                        }
                    }

                    // Mostrar resultado
                    echo "<div class='result'>Resultado: " . htmlspecialchars($resultado) . "</div>";
                } catch (Exception $e) {
                    // Mostrar mensaje de error
                    echo "<div class='error'>Se ha producido un error: " . htmlspecialchars($e->getMessage()) . "</div>";
                }
            } else {
                // Mostrar mensajes de error
                foreach ($errores as $error) {
                    echo "<div class='error'>" . htmlspecialchars($error) . "</div>";
                }
            }
        }
        ?>
    </div>
</body>
</html>