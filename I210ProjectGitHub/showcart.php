<?php


// Initial Page Requirements
$pageTitle = "Shopping Cart";
require('includes/header.php');


// If cart is empty in any session then run code
if (!isset($_SESSION['cart']) || !$_SESSION['cart']) {
    echo "Your shopping cart is empty.<br><br>";
    include('includes/footer.php');
    exit();
}

// Update cart array
$cart = $_SESSION['cart'];

// Connect to Database
connect();

// Query items that are in found inside the cart
/** @var $tableGames */
findItems("SELECT id, title, price FROM $tableGames WHERE 0");

// Place query into an array
$rows = fetchData();


?>

    <!-- Display Shopping Cart Items -->
    <section>
        <h2>Shopping Cart</h2>
        <div>
            <table>
                <tr>
                    <td>Title</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
                </tr>
                <?php // Loop to display each item found in the cart
                $total = 0;
                foreach ($rows as $row) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $qty = $cart[$id];
                    $subtotal = $qty * $price;
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><a href="gamedetails.php?id=<?= $id ?>"><?= $title ?></a></td>
                        <td><?= $price ?></td>
                        <td><?= $qty ?></td>
                        <td><?php printf("%.2f", $subtotal); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </section>

    <div>
        <input type="button" value="Checkout" onclick="window.location.href = 'checkout.php'"/>
        <h2>Your Total is <?= $total ?></h2>
    </div>

<?php
disconnect();
include('includes/footer.php');