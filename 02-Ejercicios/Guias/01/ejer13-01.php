<?php
$vec1 = array("Perro" ,"Gato", "Raton", "Araña", "Mosca");
$vec2 = array();
$vec3 = array();

array_push($vec2, "1986", "1996", "2015", "78", "86");

array_push($vec3, "php" ,"mysql" ,"html5" ,"typescript" ,"ajax");

echo "<b>Muestro Animales con foreach: <br></b>";

foreach ($vec1 as $v) {
    echo "&emsp;", $v, "<br>";
}

echo "<br><b>Muestro Años con foreach: <br></b>";

foreach ($vec2 as $v) {
    echo "&emsp;", $v, "<br>";
}

$vec = array_merge($vec1, $vec2, $vec3);
echo "<br><b>Muestro MERGE con foreach: <br></b>";

foreach ($vec as $v) {
    echo "&emsp;", $v, "<br>";
}
?>