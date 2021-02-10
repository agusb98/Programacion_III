<?php

require "./Clases/token.php";

$token = Token::GetToken();
$payload = Token::GetPayload($token);

print_r($token);
echo "<br>";
print_r($payload);

?>