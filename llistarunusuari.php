<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;
ini_set('display_errors', 0);
if ($_GET['usr'] && $_GET['ou']) {
    $domini = 'dc=clotfje,dc=net';
    $opcions = [
        'host' => 'zend-jogaal.clotfje.net',
        'username' => "cn=admin,$domini",
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'clotfje.net',
        'baseDn' => 'dc=clotfje,dc=net',
    ];
    $ldap = new Ldap($opcions);
    $ldap->bind();
    $entrada = 'uid=' . $_GET['usr'] . ',ou=' . $_GET['ou'] . ',dc=clotfje,dc=net';
    $usuari = $ldap->getEntry($entrada);
    echo "<div class='result'><b><u>" . $usuari["dn"] . "</b></u><br>";
    foreach ($usuari as $atribut => $dada) {
        if ($atribut != "dn") echo $atribut . ": " . $dada[0] . '<br>';
    }
    echo "</div>";
}
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
        }
        input[type="text"] {
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #007bff;
            border-radius: 5px;
        }
        input[type="submit"], input[type="reset"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #0056b3;
        }
        .result {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h2>Escull un usuari per cercar:</h2>
    <form action="http://zend-jogaal.clotfje.net/daw2_sm8a3_projecte_garcia_joan/llistarunusuari.php" method="GET">
        <label for="ou">Unitat organitzativa:</label>
        <input type="text" name="ou" id="ou" required><br>
        <label for="usr">Usuari:</label>
        <input type="text" name="usr" id="usr" required><br>
        <input type="submit" value="Cercar Usuari">
        <input type="reset" value="Netejar">
    </form>
    <br>
    <a href="menu.php">Tornar al menú</a>
</body>
</html>
