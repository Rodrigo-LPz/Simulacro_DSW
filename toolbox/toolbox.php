<?php
    function saludar(string $nombre = "invitado"): string{
        return "Hola, $nombre\n";
    }

    saludar();
    saludar("Rodrigo");