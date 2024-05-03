<?php
include("functions/functions.php");
include("includes/db.php");

// Fetch items from the cart
$ip = getip();
$cart_query = "SELECT * FROM cart WHERE ip_add='$ip'";
$run_cart_query = mysqli_query($con, $cart_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Complete Checkout</title>
    <link rel="stylesheet" type="css" href="completecheckout.css">
</head>
<body>

<h1>Complete Checkout</h1>

<?php
// Display product names
if(mysqli_num_rows($run_cart_query) > 0) {
    echo "<h2>Items in Cart:</h2>";
    echo "<ul>";
    while($cart_row = mysqli_fetch_assoc($run_cart_query)) {
        $product_id = $cart_row['p_id'];
        $product_query = "SELECT * FROM products WHERE prd_id='$product_id'";
        $run_product_query = mysqli_query($con, $product_query);
        if($product_data = mysqli_fetch_assoc($run_product_query)) {
            $product_title = $product_data['prd_title'];
            echo "<li>$product_title</li>";
        }
    }
    echo "</ul>";
    
    // Form pembayaran
    echo "<h2>Choose Payment Method:</h2>";
    echo "<form action='index.php' method='post'>";
    echo "<input type='radio' name='payment_method' value='OVO'> OVO<br>";
    echo "<input type='radio' name='payment_method' value='BCA'> BCA<br>";
    echo "<input type='submit' name='payment_complete' value='Payment Complete'>";
    echo "</form>";
    
    // Handle pembayaran
    if(isset($_POST['payment_complete'])) {
        // Cek jika metode pembayaran dipilih
        if(isset($_POST['payment_method'])) {
            $payment_method = $_POST['payment_method'];
            // Lakukan tindakan yang diperlukan untuk menyelesaikan pembayaran berdasarkan metode yang dipilih
            
            // Redirect kembali ke halaman utama
            header("Location: index.php");
            exit; // Pastikan untuk menghentikan eksekusi skrip setelah melakukan redirect
        } else {
            echo "<p>Please select a payment method.</p>";
        }
    }
} else {
    echo "<p>No items in the cart.</p>";
}
?>

</body>
</html>
