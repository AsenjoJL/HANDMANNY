<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Handmade Collective</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <nav class="navbar">
            <div class="nav-left">
                <a href="index.php">Home</a>
                <a href="#about">About</a>
                <a href="#contact">Contact</a>
            </div>
            <div class="nav-right">
                <a href="login.php" class="login-btn">Login</a>
            </div>
        </nav>
    </header>

    <main class="hero">
        <h1>Welcome to Handmade Collective</h1>
        <p>Explore beautifully crafted traditional products made with love and culture.</p>
    </main>

    <section id="about">
        <h2>About Us</h2>
        <p>
            Handmade Collective is a community of artisans dedicated to preserving traditional crafts. 
            Our mission is to promote cultural heritage through handmade products.
        </p>
    </section>

    <section id="contact">
        <h2>Contact Us</h2>
        <p>Email: support@handmadecollective.com</p>
        <p>Phone: 0912-345-6789</p>
    </section>

    <footer>
        &copy; <?php echo date("Y"); ?> Handmade Collective. All rights reserved.
    </footer>

</body>
</html>
