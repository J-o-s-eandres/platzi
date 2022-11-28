<?php  

$claveBase = "SENATI"; 
$claveEncriptada1 = sha1($claveBase);
$claveEncriptada2 = password_hash($claveBase,PASSWORD_BCRYPT);

$claveAcceso = 'SENATI'; //Login

// Comprobando utilizando el algoritmo débil]
if(sha1($claveAcceso) == $claveEncriptada1){
    echo "<p>Bienvenido cifrado 1 </p>";
}


// comprobando utilizando el algoritmo fuerte 
if (password_verify($claveAcceso, $claveEncriptada2)){
    echo "<p>Bienvenido con el cifrado 2 </p>";
}


/*
echo "<pre>";
var_dump($claveEncriptada1);
echo "</pre>";

echo "<pre>";
var_dump($claveEncriptada2);
echo "</pre>";
*/
?>