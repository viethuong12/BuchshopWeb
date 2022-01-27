
<?php

  $content = file_get_contents("php://input");
  $decoded = json_decode($content, true);
  $data= json_encode($decoded);
  $file ="Stripe/bestellungBuch.php";//httpshttps://iws107.informatik.htw-dresden.de/ewa/G05/admin/beleg/Stripe//bestellungBuch.php

  file_put_contents($file,json_encode($decoded));
?>