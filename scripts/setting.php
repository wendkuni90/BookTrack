<?php require "../includes/student_session.php" ?>
<?php require "../config/config.php" ?>
<?php

    if(!isset($_SESSION['stu_ine'])){
        header("location: ../");
        exit();
    }

    $sql = "SELECT l.library_name FROM library l JOIN student s ON s.library_id = l.library_id WHERE s.student_ine = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_SESSION['stu_ine']]);
    $library = $stmt->fetch(PDO::FETCH_ASSOC);
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title> 
    <link rel="stylesheet" href="../assets/css/style.css?v=1.0">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/about.css">
    <link rel="stylesheet" href="../assets/css/book.css">
    <link rel="stylesheet" href="../assets/css/profil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/team.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
</head>
<body>
    <nav>
        <div class="wrapper">
            <div class="logo"><img src="../assets/img/logo_200.png" alt=""></div>
            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">
            <ul class="nav-links">
                <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                <li><a href="../">Home</a></li>
            </ul>
            <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
        </div>
    </nav>

    <section class="presentation"> 
        <h2>Profil</h2>
        <table class="student-table">
            <tr>
                <th>INE</th>
                <td><?= htmlspecialchars(strtoupper($_SESSION['stu_ine'])); ?></td>
            </tr>
            <tr>
                <th>Nom</th>
                <td> <?= htmlspecialchars(strtoupper($_SESSION['stu_name'])); ?></td>
            </tr>
            <tr>
                <th>Bibliothèque</th>
                <td><?= htmlspecialchars(strtoupper($library['library_name'])); ?></td>
            </tr>
        </table>

    </section>

    <footer>
        <!-- <section class="team-section" id="team">
            <h2>Equipe</h2>
            <div class="team-grid">
                
                <div class="team-member">
                    <img src="../assets/img/téléchargement.jpg" alt="Martin Hill" />
                    <h4>Latif NACANABO</h4>
                    <p>FrontEnd</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="team-member">
                    <img src="../assets/img/téléchargement.jpg" alt="Adam Smith" />
                    <h4>Eliel NIKIEMA</h4>
                    <p>BackEnd</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </section> -->
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
