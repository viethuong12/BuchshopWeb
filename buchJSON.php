<?php

$conn = new mysqli("localhost","G05","ma11mile", "g05") or die(mysql_error());
// SQL Query-String definieren
$query_String = "SELECT * FROM  buecher1";
// Abfrage ausfuehren
$result = $conn->query ($query_String);

$buecher_erg = array();
if ($result->num_rows > 0) {
while ($zeile = $result->fetch_assoc())   
{
  $buecher_erg[] = $zeile;
}
}
$buecher =  json_encode($buecher_erg);
echo $buecher;
mysqli_free_result( $result );
exit; 
?>

