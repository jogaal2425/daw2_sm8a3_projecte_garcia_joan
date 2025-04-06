<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTENTICANT AMB LDAP DE L'USUARI admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #007bff;
        }
        label {
            display: block;
            font-weight: bold;
            margin: 8px 0;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #007bff;
            border-radius: 5px;
        }
        input[type="submit"],
        input[type="reset"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="reset"] {
            background-color: #dc3545;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        input[type="reset"]:hover {
            background-color: #c82333;
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
    <div class="container">
        <form action="auth.php" method="POST">
            <label for="adm">Usuari amb permisos d'administració LDAP:</label>
            <input type="text" id="adm" name="adm" required>
            
            <label for="cts">Contrasenya de l'usuari:</label>
            <input type="password" id="cts" name="cts" required>
            
            <input type="submit" value="Envia">
            <input type="reset" value="Neteja">
        </form>
        <a href="index.php">Tornar al menú</a>
    </div>
</body>
</html>
