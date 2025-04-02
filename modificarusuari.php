<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha spoofeado el método PUT
    $method = $_POST['_method'] ?? 'POST';  // Obtiene el método simulado
    if ($method === 'PUT') {
        // Si el formulario es enviado con el método PUT, se procesan los datos
        if (isset($_POST['uid']) && isset($_POST['unorg'])) {
            // Obtener los datos de entrada
            $uid = $_POST['uid'];
            $unorg = $_POST['unorg'];

            // Establecer la conexión LDAP
            $domini = 'dc=clotfje,dc=net';
            $opcions = [
                'host' => 'zend-jogaal.clotfje.net',
                'username' => 'cn=admin,dc=clotfje,dc=net',
                'password' => 'fjeclot',
                'bindRequiresDn' => true,
                'accountDomainName' => 'clotfje.net',
                'baseDn' => $domini,
            ];

            $ldap = new Ldap($opcions);
            $ldap->bind();

            // Construir el DN de la entrada a modificar
            $dn = 'uid=' . $uid . ',ou=' . $unorg . ',' . $domini;

            // Obtener los atributos actuales del usuario
            $entrada = $ldap->getEntry($dn);

            // Si el usuario existe, mostrar el formulario con los valores actuales
            if ($entrada) {
                if (isset($_POST['modificar'])) {
                    // Si se envían nuevos datos, actualizar la entrada
                    $atributo = $_POST['atributo']; // Atributo seleccionado para modificar
                    $nuevoValor = $_POST['nuevoValor'];

                    // Modificar el atributo seleccionado
                    Attribute::setAttribute($entrada, $atributo, $nuevoValor);

                    // Actualizar la entrada en LDAP
                    $ldap->update($dn, $entrada);
                    echo "Atributo $atributo modificado con éxito.";
                }
            } else {
                echo "<b>El usuario con el UID: $uid no existe en la unidad organizativa: $unorg.</b><br><br>";
            }
        }
    }
} 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario LDAP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #005b99;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #005b99;
            text-align: center;
        }

        form {
            background-color: #ffffff;
            border: 2px solid #005b99;
            padding: 20px;
            max-width: 500px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 91, 153, 0.3);
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            text-align: center;
            color: #005b99;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 2px solid #005b99;
            border-radius: 4px;
            box-sizing: border-box;
            color: #005b99;
        }

        input[type="submit"] {
            background-color: #005b99;
            color: white;
            padding: 12px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #003d66;
        }

        .message {
            text-align: center;
            color: #ff0000;
            font-weight: bold;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 15px;
            background-color: #005b99;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            width: 100%;
        }

        a:hover {
            background-color: #003d66;
        }
    </style>
</head>
<body>

    <h1>Modificar Usuario LDAP</h1>

    <!-- Formulario para ingresar el UID y la unidad organizativa -->
    <form method="POST">
        <input type="hidden" name="_method" value="PUT"> <!-- Spoofing PUT -->
        <label>UID: <input type="text" name="uid" required></label><br>
        <label>Unidad Organizativa: <input type="text" name="unorg" required></label><br><br>
        <input type="submit" value="Buscar Usuario">
        <a href="menu.php">Tornar al menú</a>
    </form>

    <?php if (isset($entrada) && $entrada): ?>
        <!-- Formulario para modificar los atributos si el usuario existe -->
        <h2>Selecciona un atributo a modificar:</h2>
        <form method="POST">
            <input type="hidden" name="_method" value="PUT"> <!-- Spoofing PUT -->
            <input type="hidden" name="uid" value="<?php echo $uid; ?>">
            <input type="hidden" name="unorg" value="<?php echo $unorg; ?>">

            <label><input type="radio" name="atributo" value="cn" required> Nombre Completo (cn)</label><br>
            <label><input type="radio" name="atributo" value="postalAddress" required> Dirección (postalAddress)</label><br>
            <label><input type="radio" name="atributo" value="telephoneNumber" required> Teléfono (telephoneNumber)</label><br>
            <label><input type="radio" name="atributo" value="title" required> Título (title)</label><br>
            <label><input type="radio" name="atributo" value="description" required> Descripción (description)</label><br><br>

            <label for="nuevoValor">Nuevo Valor:</label><br>
            <input type="text" name="nuevoValor" required><br><br>

            <input type="submit" name="modificar" value="Modificar Atributo">
        </form>
        <a href="menu.php">Tornar al menú</a>
    <?php endif; ?>

</body>
</html>
