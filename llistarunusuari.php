<?php
session_start();

if (!isset($_SESSION['adm'])) {
    header("Location: index.php");
    exit();
}

require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cercar Usuari</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            text-align: center;
            padding: 20px;
        }
        h2 {
            color: #007bff;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            width: 100%;
            max-width: 600px;
        }
        input[type="text"] {
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #007bff;
            border-radius: 5px;
            width: 100%;
        }
        input[type="submit"], input[type="reset"], .menu-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 10px 0;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover, input[type="reset"]:hover, .menu-btn:hover {
            background-color: #0056b3;
        }
        .result {
            background: #ffffff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: inline-block;
            text-align: left;
            max-width: 600px;
            box-shadow: 0px 0px 10px rgba(0, 123, 255, 0.2);
            width: 100%;
        }
        .atribut {
            color: #007bff;
            margin: 6px 0;
            font-size: 16px;
        }
        .success {
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }
        .error {
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Escull un usuari per cercar:</h2>

    <?php
    // Verificar si se ha enviado el formulario
    if (isset($_GET['usr']) && isset($_GET['ou'])) {
        $uid = htmlspecialchars($_GET['usr'], ENT_QUOTES, 'UTF-8');
        $unorg = htmlspecialchars($_GET['ou'], ENT_QUOTES, 'UTF-8');

        if (!empty($uid) && !empty($unorg)) {
            $domini = 'dc=clotfje,dc=net';
            $opcions = [
                'host' => 'zend-jogaal.clotfje.net',
                'username' => "cn=admin,$domini",
                'password' => 'fjeclot',
                'bindRequiresDn' => true,
                'accountDomainName' => 'clotfje.net',
                'baseDn' => $domini,
            ];

            try {
                $ldap = new Ldap($opcions);
                $ldap->bind();

                $dn = "uid=$uid,ou=$unorg,$domini";

                if ($ldap->exists($dn)) {
                    $usuari = $ldap->getEntry($dn);
                    echo "<div class='result'>";
                    echo "<p class='atribut'><strong>DN:</strong> " . htmlspecialchars($usuari["dn"]) . "</p>";
                    foreach ($usuari as $atribut => $dada) {
                        if ($atribut != "dn") {
                            echo "<p class='atribut'><strong>" . htmlspecialchars($atribut) . ":</strong> " . 
                                 htmlspecialchars(is_array($dada) ? implode(", ", $dada) : $dada) . "</p>";
                        }
                    }
                    echo "</div>";
                    echo "<p class='success'>L'Usuari '$uid' trobat correctament.</p>";
                } else {
                    // Redirigir a error.php con el mensaje de error
                    header("Location: error.php?error=L'usuari '$uid' no existeix a la OU '$unorg'.");
                    exit();
                }

            } catch (Exception $e) {
                // Redirigir a error.php con el mensaje de error
                header("Location: error.php?error=" . urlencode($e->getMessage()));
                exit();
            }
        } else {
            // Redirigir a error.php si falta información
            header("Location: error.php?error=Per favor, completa tots els camps.");
            exit();
        }
    }
    ?>

    <form action="llistarunusuari.php" method="GET">
        <label for="ou">Unitat organitzativa:</label>
        <input type="text" name="ou" id="ou" required><br>
        <label for="usr">Usuari:</label>
        <input type="text" name="usr" id="usr" required><br>
        <input type="submit" value="Cercar Usuari">
        <!-- Botón para volver al menú -->
        <a href="menu.php" class="menu-btn">Tornar al menú</a>
    </form>

</body>
</html>
