<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $unorg = $_POST['unorg'];
    $num_id = $_POST['num_id'];
    $grup = $_POST['grup'];
    $dir_pers = $_POST['dir_pers'];
    $sh = $_POST['sh'];
    $cn = $_POST['cn'];
    $sn = $_POST['sn'];
    $nom = $_POST['nom'];
    $mobil = $_POST['mobil'];
    $adressa = $_POST['adressa'];
    $telefon = $_POST['telefon'];
    $titol = $_POST['titol'];
    $descripcio = $_POST['descripcio'];
    $objcl = ['inetOrgPerson', 'organizationalPerson', 'person', 'posixAccount', 'shadowAccount', 'top'];

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
    try {
        $ldap->bind();
        
        $nova_entrada = [];
        Attribute::setAttribute($nova_entrada, 'objectClass', $objcl);
        Attribute::setAttribute($nova_entrada, 'uid', $uid);
        Attribute::setAttribute($nova_entrada, 'uidNumber', $num_id);
        Attribute::setAttribute($nova_entrada, 'gidNumber', $grup);
        Attribute::setAttribute($nova_entrada, 'homeDirectory', $dir_pers);
        Attribute::setAttribute($nova_entrada, 'loginShell', $sh);
        Attribute::setAttribute($nova_entrada, 'cn', $cn);
        Attribute::setAttribute($nova_entrada, 'sn', $sn);
        Attribute::setAttribute($nova_entrada, 'givenName', $nom);
        Attribute::setAttribute($nova_entrada, 'mobile', $mobil);
        Attribute::setAttribute($nova_entrada, 'postalAddress', $adressa);
        Attribute::setAttribute($nova_entrada, 'telephoneNumber', $telefon);
        Attribute::setAttribute($nova_entrada, 'title', $titol);
        Attribute::setAttribute($nova_entrada, 'description', $descripcio);

        $dn = 'uid=' . $uid . ',ou=' . $unorg . ',dc=clotfje,dc=net';

        if ($ldap->add($dn, $nova_entrada)) {
            
            header("Location: success.php?message=" . urlencode('Usuari creat correctament.'));
            exit();
        } else {
            
            header("Location: error.php?error=" . urlencode('Error en la creació de l\'usuari.'));
            exit();
        }
    } catch (Exception $e) {
        
        header("Location: error.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Usuari</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        input[type="text"], input[type="number"] {
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

        .message {
            margin-top: 10px;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
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
    <h2>Crear Usuari</h2>
    <div class="container">
        <form method="POST">
            <label>UID: <input type="text" name="uid" required></label><br>
            <label>Unitat organitzativa: <input type="text" name="unorg" required></label><br>
            <label>ID número: <input type="number" name="num_id" required></label><br>
            <label>Grup: <input type="number" name="grup" required></label><br>
            <label>Directori personal: <input type="text" name="dir_pers" required></label><br>
            <label>Shell: <input type="text" name="sh" required></label><br>
            <label>CN: <input type="text" name="cn" required></label><br>
            <label>SN: <input type="text" name="sn" required></label><br>
            <label>Nom: <input type="text" name="nom" required></label><br>
            <label>Mòbil: <input type="text" name="mobil" required></label><br>
            <label>Adreça: <input type="text" name="adressa" required></label><br>
            <label>Telèfon: <input type="text" name="telefon" required></label><br>
            <label>Títol: <input type="text" name="titol" required></label><br>
            <label>Descripció: <input type="text" name="descripcio" required></label><br>
            <button type="submit" class="btn btn-primary w-100">Crear Usuari</button>
            
        </form>
    </div>
    <br>
    <a href="menu.php">Tornar al menú</a>
</body>
</html>
