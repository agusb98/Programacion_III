<?php
$pos = 5;
$acum = 0;
$vector;

echo "Numeros: ";
for ($i=0; $i < $pos ; $i++) { 
    $array[$i] = rand(1, 10);
    echo $array[$i], " ";
}

for ($i = 0; $i < $pos; $i++) { 
    $acum += $array[$i];
}

echo "<br>" . "Promedio: " . ($acum / $pos) . "<br>";

if($acum / $pos >= 6){
    echo "Mayor o Igual que 6";
}
else{
    echo "Menor a 6";
}
?>