<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;
session_start();
if (!isset($_SESSION['adm'])) {
    header("Location: index.php");
    exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

$mensaje = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['uid']) && !empty($_POST['ou'])) {
        $uid = trim($_POST['uid']);
        $unorg = trim($_POST['ou']);
        $dn = "uid=$uid,ou=$unorg,dc=clotfje,dc=net";

     
        $opcions = [
            'host' => 'zend-jogaal.clotfje.net',
            'username' => 'cn=admin,dc=clotfje,dc=net',
            'password' => 'fjeclot',
            'bindRequiresDn' => true,
            'accountDomainName' => 'clotfje.net',
            'baseDn' => 'dc=clotfje,dc=net',
        ];

        try {
            
            $ldap = new Ldap($opcions);
            $ldap->bind();

            
            if ($ldap->exists($dn)) {
                $ldap->delete($dn);
               
                header("Location: success.php?message=" . urlencode("L'usuari '$uid' eliminat correctament."));
                exit();
            } else {
               
                header("Location: error.php?error=" . urlencode("L'usuari '$uid' no existeix a la OU '$unorg'."));
                exit();
            }
        } catch (Exception $e) {
            
            header("Location: error.php?error=" . urlencode("Error: " . $e->getMessage()));
            exit();
        }
    } else {
        
        header("Location: error.php?error=" . urlencode("Completa tots els camps."));
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuari</title>
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

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            width: 300px;
            margin-top: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin: 8px 0;
        }

        input[type="text"] {
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #007bff;
            border-radius: 5px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 10px 0;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
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
    <h2>Eliminar Usuari</h2>
    <div class="container">
        <form method="POST">
            <label for="uid">UID del Usuari:</label>
            <input type="text" id="uid" name="uid" required>

            <label for="ou">Unitat Organitzativa(OU):</label>
            <input type="text" id="ou" name="ou" required>

            <button type="submit" class="btn btn-primary w-100">Eliminar Usuari</button>
            
            
        </form>

        <a href="menu.php">Tornar al menú</a>
    </div>
</body>
</html>
