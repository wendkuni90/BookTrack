<?php require "includes/student_session.php" ?>
<?php require "config/config.php" ?>
<?php


    //Recherchons les bibliothèques et les livres de chaque bibliothèque
    $sql = "SELECT * FROM library";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $libraries = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Recherchons les livres de chaque bibliothèque


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>BookTrack</title> 
    <link rel="stylesheet" href="assets/css/style.css?v=1.0">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/about.css">
    <link rel="stylesheet" href="assets/css/book.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/team.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
</head>
<body>
    <nav>
        <div class="wrapper">
            <div class="logo"><img src="assets/img/logo_200.png" alt=""></div>
            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">
            <ul class="nav-links">
                <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#book">Books</a></li>
                <li><a href="#team">Team</a></li>
                <?php if(!isset($_SESSION['stu_ine'])): ?>
                    <li><a href="auth/login.php">Log in</a></li>
                <?php else: ?>
                    <li><a href="#borrow">Emprunts</a></li>
                    <div class="dropdown">
                        <li class="dropbtn"><?= htmlspecialchars(strtoupper($_SESSION['stu_name'])); ?></li>
                        <div class="dropdown-content">
                            <li><a href="#"><?= htmlspecialchars(strtoupper($_SESSION['stu_ine'])); ?></a></li>
                            <li><a href="scripts/setting.php">Paramètres</a></li>
                            <li><a href="auth/logout.php">logout</a></li>
                        </div>
                    </div>
                    <li>  </li>
                    
                <?php endif; ?>
            </ul>
            <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
        </div>
    </nav>

    <section class="presentation">
        <section class="home-section" id="home">
            <div class="container">
                <div class="welcome-text">Bienvenue sur BookTrack</div>
                <h1 class="main-title">
                    <span class="book">Gérez</span> votre 
                    <span class="track">Bibliothèque</span> 
                    <span class="highlight">en toute simplicité</span>
                </h1>
                <p class="description">
                    BookTrack révolutionne la gestion de votre bibliothèque universitaire. 
                    Simplifiez les emprunts, suivez vos livres en temps réel, et offrez 
                    une expérience fluide aux étudiants.
                </p>
            </div>
            <div class="image-grid">
                <div class="image-item"><img src="assets/img/images.jpeg" alt="Book 1"></div>
                <div class="image-item"><img src="assets/img/images (12).jpeg" alt="Library 1"></div>
                <div class="image-item"><img src="assets/img/images (1).jpeg" alt="Book 2"></div>
                <div class="image-item"><img src="assets/img/images (10).jpeg" alt="Library 2"></div>
                <div class="image-item"><img src="assets/img/images (3).jpeg" alt="Book 3"></div>
                <div class="image-item"><img src="assets/img/images (4).jpeg" alt="Book 3"></div>
            </div>
        </section>
    
        <section class="about-section" id="about">
            <div class="about-container">
                <div class="about-image">
                    <img src="assets/img/images (9).jpeg" alt="">
                </div>
                <div class="about-content">
                    <div class="about-header">À PROPOS DE NOUS</div>
                    <h2 class="about-title">BookTrack au service de tous les étudiants</h2>
                    <p class="about-description">
                    BookTrack est un espace de découverte. Depuis notre création, nous nous efforçons 
                    de fournir des ressources de qualité, un environnement propice à l'apprentissage et des 
                    services innovants pour soutenir la réussite académique des étudiants.
                    </p>
                    <ul class="about-features">
                    <li><i class="fas fa-book"></i> Large collection de ressources académiques</li>
                    <li><i class="fas fa-wifi"></i> Accès à distance aux ressources</li>
                    </ul>
                </div>
            </div>
        </section> 


        <section class="library-section" id="book">
            <h2>Bibliothèques et Livres</h2>
            <input type="text" id="search" placeholder="Rechercher un livre..." class="search-bar">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Toutes les Bibliothèques</button>
                <?php foreach($libraries as $library): ?>
                    <button class="filter-btn" data-filter="<?= $library['library_id']; ?>"> <?= htmlspecialchars(strtoupper($library['library_name'])); ?> </button>
                <?php endforeach; ?>
            </div>
            <div class="library-grid">

                <?php foreach($libraries as $library): ?>
                    <?php
                        $id = $library['library_id'];
                        $sql = "SELECT * FROM book WHERE library_id = ?";
                        $req = $conn->prepare($sql);
                        $req->execute([$id]);
                        $books = $req->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    
                    <?php foreach($books as $book): ?>
                        <div class="library-item <?= $library['library_id']; ?>">
                            <img src="assets/img/images (7).jpeg" alt="Livre 1">
                            <p style="text-align:left;font-weight:bold;font-size:15px;margin-bottom:0;"><?= htmlspecialchars(strtoupper($book['book_title'])); ?></p>
                            <p style="text-align:left;font-size:12px;margin-top:0;">Exemplaires disponibles: <?= $book['book_copies']; ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
        
            </div>
        </section>

    </section>

    <footer>
        <section class="team-section" id="team">
            <h2>Equipe</h2>
            <div class="team-grid">
                
                <div class="team-member">
                    <img src="assets/img/téléchargement.jpg" alt="Martin Hill" />
                    <h4>Latif NACANABO</h4>
                    <p>FrontEnd</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="team-member">
                    <img src="assets/img/téléchargement.jpg" alt="Adam Smith" />
                    <h4>Eliel NIKIEMA</h4>
                    <p>BackEnd</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </section>
        <p>&copy; 2024 BookTrack. Tous droits réservés.</p>
        <p style="font-size: 10px;">Latif NACANABO & Eliel NIKIEMA</p>
    </footer>   
    
    <script src="assets/js/home.js"></script>
    <script src="assets/js/about.js"></script>
    <script src="assets/js/book.js"></script>
    <script src="assets/js/search.js"></script>
    <script src="assets/js/team.js"></script>
</body>
</html>
