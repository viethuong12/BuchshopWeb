<?php

$json = file_get_contents('bestellungBuch.php');
$cart = json_decode($json,true);
echo "Huy";
/* echo(json_encode($cart));
echo ($cart[0]['amount']); */
//print_r(array_values($lineItems));
$lineItems = array();
for($i=0;$i<count($cart);$i++){
    $tempArr = array(
        'name' => $cart[$i]['name'],
        'amount' => $cart[$i]['amount'],
        'currency' =>$cart[$i]['currency'],
        'quantity' =>$cart[$i]['quantity']

    );
    $lineItems[]= $tempArr;
}
print_r(array_values($lineItems));
echo "chu y".count($lineItems);
// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
 require('stripe-php-master/init.php');


 //$test = [['name' => 'testbuch', 'amount'=> '1299', 'currency' => 'eur', 'quantity' => '1'],['name' => 'testbuch', 'amount'=> '1299', 'currency' => 'eur', 'quantity' => '1']];

$public_key_for_js ="1" ; // Definition einer Variable für den public key - Verwendung ganz unten in JS

// #################################################################  
// Definition der Stripe-Account-Keys
if($_GET['live'] ) {
    //if(false) {
    // Secret Key des Grosshändlers - bitte so lassen !!!
    \Stripe\Stripe::setApiKey('sk_test_cFnCai0Ye9NM8Tn9CMo6k0fn00P0R9pt9u');

	$public_key_for_js="pk_test_aLcPqdtG2FDzxPWu5N9OBNOs00Yt0nKnhS";  //  PK Großhändler - So lassen !!!!
} else {
      // Der Key Ihres eigenen Stripe-Accounts - bitte hier einsetzen->  der nachfolgende Code ist nicht mehr gültig !!!
    \Stripe\Stripe::setApiKey('sk_test_51KKgFbF5EnG8YxbJcJ112b3nZS2dyjBcq7ulUN939ljPuJLBfWLkak7zx3aji0Lh66zkO7d0E40MNiDaxzQgjyr00042wcG5sv');
	
	$public_key_for_js="pk_test_51KKgFbF5EnG8YxbJPbPpIRskkU6zXophfpqlbGWB9x429vCPRYCgoQGNoS9sUzwd5ADnwg1vWPwu8WOZjXfs8wZP00I2cwbqMt";  // PK  G00 
}
// #################################################################  

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [$lineItems],
        //'line_items' => [$test],
       'success_url' => 'https://iws107.informatik.htw-dresden.de/ewa/G05/admin/beleg/STRIPE/' . 'success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url'  => 'https://iws107.informatik.htw-dresden.de/ewa/G05/admin/beleg/STRIPE/' . 'cancel.php?session_id={CHECKOUT_SESSION_ID}',
    ]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo "Error in Session::create()" . $e;
} 
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>

<h1>Bookstore</h1>

Sie werden zum Stripe-Checkout weitergeleitet....
<?php // echo "mit PK=" . $public_key_for_js?>
<script>
    var stripe = Stripe('<?php echo $public_key_for_js ?>'); // Nichts ändern ! Public key oben definiert !!!
	// Hier stand vorher der public key des Test-Accounts G00
    stripe.redirectToCheckout({
        sessionId: '<?php echo $session['id']; ?>'
    }).then(function (result) {
    });
</script>

</body>
</html>