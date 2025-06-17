<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Magasin d'Électronique</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<header>
    <h1>Magasin d'Électronique</h1>
    <nav>
        <?php if(isset($_SESSION['username'])): ?>
            Bonjour, <?=htmlspecialchars($_SESSION['username'])?> | 
            <a href="logout.php">Déconnexion</a>
        <?php else: ?>
            <a href="login.php">Connexion</a> | 
            <a href="register.php">Créer un compte</a>
        <?php endif; ?>
        <div class="cart-icon">
            <i class="fas fa-shopping-cart"></i>
            <span id="cart-count">0</span>
        </div>
    </nav>
</header>

<section class="product-list">
    <?php
    $products = [
        ['name' => 'Switch Réseau', 'price' => 35, 'img' => 'https://cdn-icons-png.flaticon.com/512/833/833314.png'],
        ['name' => 'Routeur WiFi', 'price' => 60, 'img' => 'https://cdn-icons-png.flaticon.com/512/692/692798.png'],
        ['name' => 'Clavier', 'price' => 25, 'img' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png'],
        ['name' => 'Ordinateur Portable', 'price' => 700, 'img' => 'https://cdn-icons-png.flaticon.com/512/2834/2834703.png']
    ];

    foreach($products as $product):
    ?>
    <div class="product">
        <img src="<?=$product['img']?>" alt="<?=htmlspecialchars($product['name'])?>" />
        <h2><?=htmlspecialchars($product['name'])?></h2>
        <p>Prix: <?=$product['price']?>€</p>
        <button class="add-to-cart" data-name="<?=htmlspecialchars($product['name'])?>" data-price="<?=$product['price']?>">Ajouter au panier</button>
    </div>
    <?php endforeach; ?>
</section>

<section id="cart-section">
    <h2>Panier</h2>
    <ul id="cart-list"></ul>
    <h3>Total: <span id="cart-total">0</span>€</h3>
</section>

<script src="script.js"></script>
</body>
</html>
