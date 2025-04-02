<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);
session_set_cookie_params(0);
if ($_POST['cts'] && $_POST['adm']){
    $opcions = [
        'host' => 'zend-jogaal.clotfje.net',
        'username' => "cn=admin,dc=clotfje,dc=net",
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'clotfje.net',
        'baseDn' => 'dc=clotfje,dc=net',
    ];
    $ldap = new Ldap($opcions);
    $dn='cn='.$_POST['adm'].',dc=clotfje,dc=net';
    $ctsnya=$_POST['cts'];
    try{
        $ldap->bind($dn,$ctsnya);
        session_start();
        $_SESSION['adm']=$_POST['adm'];
        header("location: menu.php");
    } catch (Exception $e){
        echo "<b>Contrasenya incorrecta</b><br><br>";
    }
}
?>
<html>
	<head>
		<title>
			AUTENTICACIÓ AMB LDAP 
		</title>
	</head>
	<body>
		<a href="index.php">Torna a la pàgina inicial</a>
	</body>
</html>