<?php
include_once "./Clases/token.php";

$key = "333";
$token = Token::GenerarToken($key);

print_r(Token::ObtenerToken($token, $key));
?>