<?php
session_start();

// Si no hay sesión iniciada, redirigir al login
if (!isset($_SESSION['adm'])) {
    header("Location: index.php");
    exit();
}

require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);

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

$filtres = '(objectClass=inetOrgPerson)';
$resultats = $ldap->search($filtres, $domini, Ldap::SEARCH_SCOPE_SUB);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llista d'Usuaris</title>
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
        table {
            width: 60%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #e3f2fd;
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
    <h2>Llista d'Usuaris LDAP</h2>
    <table>
        <tr>
            <th>Usuari</th>
            <th>Unitat Organitzativa (OU)</th>
            <th>Domini</th>
        </tr>
        <?php foreach ($resultats as $usuari) { 
            $dnParts = ldap_explode_dn($usuari['dn'], 1);
            $uid = isset($dnParts[0]) ? htmlspecialchars($dnParts[0]) : 'Desconegut';
            $ou = isset($dnParts[1]) ? htmlspecialchars($dnParts[1]) : 'Desconegut';
        ?>
            <tr>
                <td><?php echo $uid; ?></td>
                <td><?php echo $ou; ?></td>
                <td><?php echo htmlspecialchars($domini); ?></td>
            </tr>
        <?php } ?>
    </table>
    <a href="menu.php">Tornar al menú</a>
</body>
</html>
