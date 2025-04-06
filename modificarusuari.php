<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);

$mensaje = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $method = $_POST['_method'] ?? 'POST';
    if ($method === 'PUT') {
        if (!empty($_POST['uid']) && !empty($_POST['unorg'])) {
            $uid = $_POST['uid'];
            $unorg = $_POST['unorg'];

            $domini = 'dc=clotfje,dc=net';
            $opcions = [
                'host' => 'zend-jogaal.clotfje.net',
                'username' => 'cn=admin,dc=clotfje,dc=net',
                'password' => 'fjeclot',
                'bindRequiresDn' => true,
                'accountDomainName' => 'clotfje.net',
                'baseDn' => $domini,
            ];

            try {
                $ldap = new Ldap($opcions);
                $ldap->bind();
                
                $dn = 'uid=' . $uid . ',ou=' . $unorg . ',' . $domini;
                $entrada = $ldap->getEntry($dn);
                
                if ($entrada) {
                    if (isset($_POST['modificar'])) {
                        $atributo = $_POST['atributo'];
                        $nuevoValor = $_POST['nuevoValor'];
                        
                        // Modificar atributo
                        Attribute::setAttribute($entrada, $atributo, $nuevoValor);
                        $ldap->update($dn, $entrada);
                        
                        // Redirigir a success.php con mensaje de éxito
                        header("Location: success.php?message=" . urlencode("Atribut '$atributo' modificat correctament a '$nuevoValor'."));
                        exit();
                    }
                } else {
                    // Redirigir a error.php si el usuario no existe
                    header("Location: error.php?error=" . urlencode("L' usuari amb UID '$uid' no existeix a unitat organitzativa '$unorg'."));
                    exit();
                }
            } catch (Exception $e) {
                // Redirigir a error.php en caso de excepción
                header("Location: error.php?error=" . urlencode("Error: " . htmlspecialchars($e->getMessage())));
                exit();
            }
            
        } else {
            // Redirigir a error.php si los campos no están completos
            header("Location: error.php?error=" . urlencode("Completa tots els camps."));
            exit();
        }
    }  
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuari</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            text-align: center;
            padding: 20px;
        }
        h1 {
            color: #007bff;
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
        .message {
            margin: 20px auto;
            padding: 15px;
            font-weight: bold;
            max-width: 600px;
            border-radius: 5px;
            text-align: center;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 2px solid #28a745;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 2px solid #dc3545;
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

    <h1>Modificar Usuari</h1>

    <?php if (!empty($mensaje)) echo $mensaje; ?>

    <form method="POST">
        <input type="hidden" name="_method" value="PUT">
        <label>UID: <input type="text" name="uid" required></label><br>
        <label>Unidad Organizativa: <input type="text" name="unorg" required></label><br><br>
        <input type="submit" value="Cercar Usuari">
        <a href="menu.php">Tornar al menú</a>
    </form>

    <?php if (isset($entrada) && $entrada): ?>
        <h2>Selecciona un atribut a modificar:</h2>
        <form method="POST">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="uid" value="<?php echo $uid; ?>">
            <input type="hidden" name="unorg" value="<?php echo $unorg; ?>">
            <input type="hidden" name="modificar" value="1">

            <label>
                <input type="radio" name="atributo" value="cn" required>
                Nombre Completo (cn): <?php echo $entrada['cn'][0] ?? 'No disponible'; ?>
            </label><br>

            <label>
                <input type="radio" name="atributo" value="postalAddress" required>
                Dirección (postalAddress): <?php echo $entrada['postalAddress'][0] ?? 'No disponible'; ?>
            </label><br>

            <label>
                <input type="radio" name="atributo" value="telephoneNumber" required>
                Teléfono (telephoneNumber): <?php echo $entrada['telephoneNumber'][0] ?? 'No disponible'; ?>
            </label><br>

            <label>
                <input type="radio" name="atributo" value="title" required>
                Título (title): <?php echo $entrada['title'][0] ?? 'No disponible'; ?>
            </label><br>

            <label>
                <input type="radio" name="atributo" value="description" required>
                Descripción (description): <?php echo $entrada['description'][0] ?? 'No disponible'; ?>
            </label><br><br>

            <label for="nuevoValor">Nou valor:</label><br>
            <input type="text" name="nuevoValor" required><br><br>

            <button type="submit" class="btn btn-primary w-100">Modificar Usuari</button>
            
        </form>
    <?php endif; ?>

</body>
</html>
