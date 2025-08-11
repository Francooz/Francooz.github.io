<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Normalizador de Vectores</title>
    <style>
        /* Reinicia márgenes para un diseño consistente */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Fondo de la pagina osea coloes  */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh; /* el fondo cubra toda la pantalla */
            display: flex;
            justify-content: center;
            padding: 20px; /* Dejar espacio arriba y abajo*/
        }

        /* Contenedor principal  */
        .contenedor-principal {
            background-color: white; 
            border-radius: 20px; 
            padding: 40px; /* Espacio interno */
            max-width: 600px; /* Ancho máximo para mantener el diseño compacto (El recuadro de z no moleste) */
        }

        /* Estilo del título principal con texto degradado */
        h1 {
            text-align: center; 
            color: #333; 
            font-size: 2.5rem; /* Tamaño mas grande que h1 predeterminado */
            background: linear-gradient(135deg, #667eea, #764ba2); 
            -webkit-background-clip: text; /* Aplica el degradado al texto y no a su alrededor */
            -webkit-text-fill-color: transparent; /* Hace el texto adquiera el color  */
        }

        /* Contenedor para agrupar elementos de formulario */
        .grupo-formulario {
            margin-bottom: 25px; /* Espacio entre elementos */
        }

        /* Estilo para etiquetas de formulario */
        label {
            margin-bottom: 10px; /* Espacio inferior entre elememtos */
            color: #555;
            font-weight: 600; /* Es como el efecto de una letra en negrito */
        }

        /* Contenedor para los botones de selección de dimensión (2D/3D) */
        .seleccion-dimension {
            display: flex;
            gap: 15px; /* Espacio entre botones */
            justify-content: center;
            margin-bottom: 20px;
        }

        /* Oculta la opcion predeterminada de radio (Osea elimina los circulos de seleccion) */
        .opcion-dimension input[type="radio"] {
            display: none;
        }

        /* Estilo para Los botones que sustituyen a los circulos */
        .etiqueta-dimension {
            display: block;
            padding: 12px 25px; /* Espacio ente la letra y el contorno */
            background-color: #eff2fd;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            color: #667eea;
        }

        /* Estilo para la opción de radio seleccionada */
        .opcion-dimension input[type="radio"]:checked + .etiqueta-dimension {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateY(-2px); /* Efecto de elevación */
        }

        /* Contenedor para los campos de entrada de componentes del vector */
        .entrada-vector {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        /* Estilo para ocultar el campo Z cuando no se necesita */
        .componente-vector.oculto {
            opacity: 0; /* Invisible */
            transform: scale(0);
            width: 0;
            min-width: 0;
            margin: 0; /* Elimina espacio y solo lo usen x y y  */
        }

        /* Estilo para los campos de entrada numéricos */
        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 1.1rem;
            text-align: center;
        }

        /* Estilo para los campos donde se ingresan los numeros */
        input[type="number"]:focus {
            outline: none; /* Elimina borde predeterminado */
            border-color: #667eea;
            box-shadow: 0 0 15px #667eea4d;
            transform: translateY(-2px); /* Efecto de elevación */
        }

        /* Estilo para el botón de enviar */
        .boton-calcular {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Efecto al hacer clic en el botón */
        .boton-calcular:active {
            transform: translateY(-1px); /* Efecto de presión */
        }

        /* Contenedor para los resultados del cálculo */
        .resultado-calculo {
            background: linear-gradient(135deg, #667eea1a, #764ba21a);
            border-radius: 15px;
            padding: 25px;
            margin-top: 25px;
        }

        /* Estilo para el encabezado de los resultados */
        .titulo-resultado {
            font-size: 1.3rem;
            color: #667eea;
            margin-bottom: 15px;
            font-weight: bold; /* Negrita */
            text-align: center;
        }

        /* Estilo para cada paso del cálculo */
        .paso-calculo {
            background: #ffffffcc;
            padding: 15px;
            margin: 10px 0;
            border-radius: 10px;
            border-left: 4px solid #667eea; /* Borde izquierdo para destacar */
        }

        /* Estilo para mostrar vectores y resultados */
        .mostrar-vector {
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
            color: #333;
            background: #ffffffe6;
            padding: 15px;
            border-radius: 10px;
            margin: 10px 0;
            border: 2px solid #667eea4d; /* Borde para mostrar resultados */
        }

        /* Estilo para mensajes de error */
        .mensaje-error {
            background: linear-gradient(135deg, #e74c3c1a, #c0392b1a);
            border: 2px solid #e74c3c4d;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Contenedor principal de la aplicación -->
    <div class="contenedor-principal">

        <!-- Título de la aplicación -->
        <h1>🧮 Normalizador de Vectores</h1>

        <!-- Formulario para ingresar datos del vector -->
        <form method="POST" id="vectorForm">
            <!-- Grupo para seleccionar la dimensión del vector -->
            <div>
                <label>Seleccione el tipo de vector:</label>
                <div class="seleccion-dimension">
                    <div class="opcion-dimension">
                        <input type="radio" name="dimension" value="2d" id="dim2d" <?php echo (!isset($_POST['dimension']) || $_POST['dimension'] === '2d') ? 'checked' : ''; ?>/>
                        <label for="dim2d" class="etiqueta-dimension">📐 Vector 2D</label>
                    </div>
                    <div class="opcion-dimension">
                        <input type="radio" name="dimension" value="3d" id="dim3d" <?php echo (isset($_POST['dimension']) && $_POST['dimension'] === '3d') ? 'checked' : ''; ?>/>
                        <label for="dim3d" class="etiqueta-dimension">📦 Vector 3D</label>
                    </div>
                </div>
            </div>

            <!-- Ingresar valores-->
            <div class="grupo-formulario">
                <label>Ingrese las componentes del vector:</label>
                <div class="entrada-vector">
                    <!-- X -->
                    <div class="componente-vector">
                        <label>X</label>
                        <input type="number" name="x" value="<?php echo isset($_POST['x']) ? htmlspecialchars($_POST['x']) : ''; ?>" required />
                    </div>
                    <!--  Y -->
                    <div class="componente-vector">
                        <label>Y</label>
                        <input type="number" name="y" value="<?php echo isset($_POST['y']) ? htmlspecialchars($_POST['y']) : ''; ?>" required />
                    </div>
                    <!--  Z (visible solo en 3D) -->
                    <div class="componente-vector" id="componenteZ">
                        <label>Z</label>
                        <input type="number" name="z" value="<?php echo isset($_POST['z']) ? htmlspecialchars($_POST['z']) : ''; ?>" />
                    </div>
                </div>
            </div>

            <!-- Botón para enviar el formulario -->
            <button type="submit" class="boton-calcular">🔢 Calcular Vector Unitario</button>
        </form>

        <?php
        // Procesa el formulario cuando se envía
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtiene los valores ingresados
            $dimension = $_POST['dimension']; // si sera 2d o 3d
            $x = $_POST['x'];
            $y = $_POST['y'];
            $z = $_POST['z'];

            // Calcula la magnitud del vector
            if ($dimension === '2d') {
                $magnitude = sqrt($x * $x + $y * $y); // Magnitud para 2D: √(x² + y²)
            } else {
                $magnitude = sqrt($x * $x + $y * $y + $z * $z); // Magnitud para 3D: √(x² + y² + z²)
            }

            // Verifica si la magnitud es 0 (no se puede normalizar)
            if ($magnitude == 0) {
                echo '<div class="resultado-calculo mensaje-error">';
                echo '<strong>❌ Error:</strong> No se puede normalizar el vector cero (magnitud = 0)';
                echo '</div>';
            } else {
                // Calcula las componentes del vector unitario
                $unit_x = $x / $magnitude; // Componente X del vector unitario
                $unit_y = $y / $magnitude; // Componente Y del vector unitario
                $unit_z = ($dimension === '3d') ? $z / $magnitude : 0; // Componente Z (0 si es 2D)

                // Muestra el contenedor de resultados
                echo '<div class="resultado-calculo">';
                echo '<div class="titulo-resultado">📊 Resultados del Cálculo (' . strtoupper($dimension) . ')</div>';

                // Muestra el vector original
                echo '<div class="paso-calculo">';
                echo '<strong>📐 Vector Original:</strong><br>';
                if ($dimension === '2d') {
                    echo '<div class="mostrar-vector">V = (' . $x . ', ' . $y . ')</div>';
                } else {
                    echo '<div class="mostrar-vector">V = (' . $x . ', ' . $y . ', ' . $z . ')</div>';
                }
                echo '</div>';

                // Muestra el cálculo de la magnitud
                echo '<div class="paso-calculo">';
                echo '<strong>📏 Cálculo de la Magnitud:</strong><br>';
                if ($dimension === '2d') {
                    echo '|V| = √(' . $x . '² + ' . $y . '²)<br>';
                    echo '|V| = √(' . $x*$x . ' + ' . $y*$y . ')<br>';
                    echo '|V| = √' . $x*$x + $y*$y . '<br>';
                } else {
                    echo '|V| = √(' . $x . '² + ' . $y . '² + ' . $z . '²)<br>';
                    echo '|V| = √(' . $x*$x . ' + ' . $y*$y . ' + ' . $z*$z . ')<br>';
                    echo '|V| = √' . $x*$x + $y*$y + $z*$z . '<br>';
                }
                echo '<div class="mostrar-vector">|V| = <span class="magnitude">' . number_format($magnitude, 6) . '</span></div>';// number_format es para delimitar el numero de numeros XD que va despues del punto
                echo '</div>';

                // Muestra el vector unitario
                echo '<div class="paso-calculo">';
                echo '<strong>🎯 Vector Unitario (V̂):</strong><br>';
                echo 'V̂ = V / |V|<br>';
                if ($dimension === '2d') {
                    echo 'V̂ = (' . $x . ', ' . $y . ') / ' . number_format($magnitude, 6) . '<br>';
                    echo '<div class="mostrar-vector">V̂ = (' . number_format($unit_x, 6) . ', ' . number_format($unit_y, 6) . ')</div>';
                } else {
                    echo 'V̂ = (' . $x . ', ' . $y  . ', ' . $z . ') / ' . number_format($magnitude, 6) . '<br>';
                    echo '<div class="mostrar-vector">V̂ = (' . number_format($unit_x, 6) . ', ' . number_format($unit_y, 6) . ', ' . number_format($unit_z, 6) . ')</div>';
                }
                echo '</div>';

                // Verifica la magnitud del vector unitario
                if ($dimension === '2d') {
                    $unit_magnitude = sqrt($unit_x * $unit_x + $unit_y * $unit_y); // Magnitud para 2D, $unit_y * $unit_y se multiplica asi mismo para sacar el elevado al cuadrado
                } else {
                    $unit_magnitude = sqrt($unit_x * $unit_x + $unit_y * $unit_y + $unit_z * $unit_z); // Magnitud para 3D
                }
                echo '<div class="paso-calculo">';
                echo '<strong>✅ Verificación:</strong><br>';
                echo 'Magnitud del vector unitario = ' . number_format($unit_magnitude, 6);
                if (abs($unit_magnitude - 1.0) < 0.000001) {
                    echo ' <span style="color: #27ae60;">✓ Correcto (≈ 1.0)</span>'; // Confirma que es correcto
                } else {
                    echo ' <span style="color: #e74c3c;">⚠ Revisar cálculo</span>'; // Indica error
                }
                echo '</div>';

                echo '</div>';
            }
        }
        ?>
    </div>

    <script>
        // JavaScript para controlar la visibilidad del campo Z según la dimensión seleccionada
        document.addEventListener('DOMContentLoaded', function() {
            // Obtiene referencias a los elementos del DOM
            const dim2d = document.getElementById('dim2d'); //  button para 2D
            const dim3d = document.getElementById('dim3d'); //  button para 3D
            const componenteZ = document.getElementById('componenteZ'); // Contenedor del campo Z
            const inputZ = componenteZ.querySelector('input'); // Input del campo Z

            // Función para mostrar u ocultar Z
            function alternarComponenteZ() {
                if (dim2d.checked) {
                    componenteZ.classList.add('oculto'); // Oculta el campo Z para 2D
                    inputZ.removeAttribute('required'); // Elimina el requisito de llenado
                    inputZ.value = ''; // Limpia el valor
                } else {
                    componenteZ.classList.remove('oculto'); // Muestra el campo Z para 3D
                    inputZ.setAttribute('required', 'required'); // Hace el campo obligatorio
                }
            }

            // Ejecuta la función al cargar la página
            alternarComponenteZ();

            // Agrega eventos para actualizar la visibilidad al cambiar la selección
            dim2d.addEventListener('change', alternarComponenteZ);
            dim3d.addEventListener('change', alternarComponenteZ);
        });
    </script>
</body>
</html>
