<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jouets Tétouan - Navbar</title>
    <link href="{{ asset('css/nav_bar_guest.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav>
        <a href="{{ route('acceuil') }}" class="logo ml-6">
            <img src="{{ asset('images/lo3baty.jpg') }}" alt="Logo Jouets Tétouan">
        </a>
        
        <ul class="nav-links">
            <li><a href="#hero">Accueil</a></li>
            <li><a href="#annonces">Annonces</a></li>
            <li><a href="#how-it-works">Comment ça marche</a></li>
            <li><a href="#team">Notre équipe</a></li>
            <li><a href="#testimonials">Avis</a></li>
            
           
        </ul>
        
        <div class="auth-buttons">
            <a href="{{ route('login') }}" class="login-btn">Connexion</a>
            <a href="{{ route('register') }}" class="register-btn">Inscription</a>
        </div>
        
        <div class="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
    </nav>

    <script>
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.nav-links').classList.toggle('active');
        });
    </script>
</body>
</html>