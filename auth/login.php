<!-- Le fichier principal sera une page de connexion 
pour (L'Admin et les Bibliothécaires) 
Notons que si la session du bibliothécaire est lancée il ne peux plus avoir
à cette page de même pour l'administrateur
-->
<?php require "../includes/student_session.php" ?>
<?php require "../config/config.php" ?>

<?php 

    if(isset($_SESSION['stu_ine'])){
        header("location: ../");
        exit();
    }

    if(isset($_POST['submit'])){
        if(empty($_POST['ine']) OR empty($_POST['pass'])){
            echo "<script>alert('Attention: Un des champs est vide.')</script>";
        } else {
            $ine = trim($_POST['ine']);
            $pass = $_POST['pass'];

            //Requête préparée por éviter les injections sql
            $stmt = $conn->prepare("SELECT * FROM student WHERE student_ine = :ine");
            $stmt->bindParam(':ine', $ine);
            $stmt->execute();
            $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

            //Validation du mot de passe
            if($fetch && password_verify($pass,$fetch['student_pass'])){
                $_SESSION['stu_ine'] = $fetch['student_ine'];
                $_SESSION['stu_name'] = $fetch['student_name'];
                header("location: ../");
                exit();
            } else {
                $error_message = "Accès refusé: Données incorrectes.";
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../assets/css/login.css?v=1.0">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Connexion</h1>
            <form action="#" method="POST">
                <div class="textbox">
                    <input type="text" name="ine" maxlength="12" required>
                    <span class="placeholder">INE</span>
                </div>
                <div class="textbox">
                    <input type="password" name="pass" maxlength="8" required>
                    <span class="placeholder">Mot de passe</span>
                </div>

                <?php if (!empty($error_message)): ?>
                    <p class="error"><?= htmlspecialchars($error_message) ?></p>
                <?php endif; ?>

                <a href="forgot_pass.php" class="forgot-password">Mot de passe oublié ?</a><br>
                <button type="submit" name="submit">Se Connecter</button>
            </form>
        </div>
    </div>
</body>
</html>
