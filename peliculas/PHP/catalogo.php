<?php
    $peliculas = [
        [
            "titulo" => "El Señor de los Anillos: La Comunidad del Anillo",
            "director" => "Peter Jackson",
            "anio" => 2001,
            "genero" => "Fantasía",
            "poster" => "Images/lotr1.jpg"
        ],
        [
            "titulo" => "Inception",
            "director" => "Christopher Nolan",
            "anio" => 2010,
            "genero" => "Ciencia Ficción",
            "poster" => "Images/inception.jpg"
        ],
        [
            "titulo" => "Interstellar",
            "director" => "Christopher Nolan",
            "anio" => 2014,
            "genero" => "Ciencia Ficción",
            "poster" => "Images/interstellar.jpg"
        ],
        [
            "titulo" => "Matrix",
            "director" => "Lana y Lilly Wachowski",
            "anio" => 1999,
            "genero" => "Ciencia Ficción",
            "poster" => "Images/matrix.jpg"
        ],
        [
            "titulo" => "Gladiator",
            "director" => "Ridley Scott",
            "anio" => 2000,
            "genero" => "Acción",
            "poster" => "Images/gladiator.jpg"
        ],
        [
            "titulo" => "Parque Jurásico",
            "director" => "Steven Spielberg",
            "anio" => 1993,
            "genero" => "Aventura",
            "poster" => "Images/jurassic_park.jpg"
        ]
    ];

    $cartelera = $peliculas;
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cine Atlantida - Cartelera</title>

        <!-- Icon -->
        <link rel="icon" href="../Images/Icono/cine.png">

        <!-- Fav-Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
            integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        
        <!-- CSS -->
        <link rel="stylesheet" href="../CSS/style.css">
    </head>
    <body>
        <header></header>
        <main>
            <div class="formulario">
                <label for="categoria">Seleccione un género:</label>
                <!-- get-form.html -->
                <form action="PHP/catologo.php" method="get" id="formularioCategoriaPeliculas">
                    <!-- " size="1" " Define el número de opciones visibles de forma simultánea (si es mayor que 1, cambia de un menú desplegable clásico a una lista con barra de desplazamiento). -->
                    <select name="categoria" id="categoria" size="1" autofocus required>
                        <option value="">Selecciona una opción</option>
                        <optgroup label="A">
                            <option value="accion" selected>Acción</option>
                            <option value="aventura">Aventura</option>
                        </optgroup>
                        <optgroup label="C">
                            <option value="ciencia_ficcion">Ciencia Ficción</option>
                        </optgroup>
                        <optgroup label="F">
                            <option value="fantasia">Fantasía</option>
                        </optgroup>
                    </select>
                    <br>
                    <button type="submit">Filtrar</button>
                </form>
            </div>
            <div class="info">
                <h2>
                    <?php foreach ($cartelera as $pelicula => $titulo) echo "Título de la película: " . $titulo; ?>
                </h2>
                <img
                    src="<?php foreach ($cartelera as $pelicula => $poster) echo "../" . $poster; ?>" alt="<?php foreach ($cartelera as $pelicula => $poster) echo "Póster: " . $titulo; ?>">
                <p>
                    <?php foreach ($cartelera as $pelicula => $director) echo "Director: " . $director; ?>
                    <br>
                    <?php foreach ($cartelera as $pelicula => $anio) echo "Año de publicación: " . $direanioctor; ?>
                    <br>
                    <?php foreach ($cartelera as $pelicula => $genero) echo "Género: " . $genero; ?>
                </p>
            </div>


            <!-- Muestra el mensaje (el saludo o el error). -->
            <p class="<?= $esError ? "error" : "saludo" ?>"><?= $mensaje ?></p>

            <!-- Enlace para volver al formulario ("../" sube a la carpeta principal, donde está "index.html"). -->
            <a href="../index.html">Volver al formulario</a>
        </main>
        <footer></footer>
    </body>
</html>

<!-- php -S localhost:8080 -->