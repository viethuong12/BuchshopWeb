<?php
// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
require('stripe-php-master/init.php');
require('./stripe-php-master/init.php');

include 'books.php';

$bookId = $_GET['bookId'];

$public_key_for_js ="1" ; // Definition einer Variable für den public key - Verwendung ganz unten in JS

// #################################################################  
// Definition der Stripe-Account-Keys
if($_GET['live']) {
    // Secret Key des Grosshändlers - bitte so lassen !!!
    \Stripe\Stripe::setApiKey('sk_test_cFnCai0Ye9NM8Tn9CMo6k0fn00P0R9pt9u');

	$public_key_for_js="pk_test_aLcPqdtG2FDzxPWu5N9OBNOs00Yt0nKnhS";  //  PK Großhändler - So lassen !!!!
} else {
      // Der Key Ihres eigenen Stripe-Accounts 
    \Stripe\Stripe::setApiKey('sk_test_51I6B0JB5oU29RTwLme72A499xozxpiu963P6zqK2JTLXXh5F7noDh6rOYO5HjRqKzEmTJPxHFxs57Y5iS6mfi34j00JY9mPoqb');
	
	$public_key_for_js="pk_test_51I6B0JB5oU29RTwL4S0HvQVOVVOQAA8OquJ9JVtK2XyU12KDIQe4Ei9kwgeohIBGoBW1gnnHT77buFIEiVebfazs00iVmkuxMm";  // PK  G01 
}
// #################################################################  

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [$books[$bookId]],
        'success_url' => 'http://ivm108.informatik.htw-dresden.de/ewa/Demos/bookstore-stripe-checkout/' . 'success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'http://ivm108.informatik.htw-dresden.de//ewa/Demos/bookstore-stripe-checkout/' . 'cancel.php',
    ]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo "Error in Session::create()";
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
<?php // echo "mit PK=" . $public_key_for_js
?>
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