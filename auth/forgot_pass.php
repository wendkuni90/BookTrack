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
        if(empty($_POST['ine']) OR empty($_POST['mail'])){
            echo "<script>alert('Attention: Un des champs est vide.')</script>";
        } else {
            $ine = trim($_POST['ine']);
            $mail = strtolower($_POST['mail']);

            //Requete preparée
            //On va vérifier si l'ine correspond au mail puis ensuite on utilisera phpmailer via composer pour envoyer un mot de passee qu'on va créer via une fonction
            $sql = "SELECT * FROM student WHERE student_ine = :ine";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':ine',$ine);
            $stmt->execute();
            $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

            //Vlidation du mail
            if($fetch && $mail == strtolower($fetch['student_mail'])){
                
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="../assets/css/login.css?v=1.0">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Mot de passe oublié</h1>
            <form action="#" method="POST">
                <div class="textbox">
                    <input type="text" name="ine" maxlength="12" required>
                    <span class="placeholder">INE</span>
                </div>
                <div class="textbox">
                    <input type="email" name="mail" required>
                    <span class="placeholder">Mot de passe</span>
                </div>
                
                <?php if (!empty($error_message)): ?>
                    <p class="error"><?= htmlspecialchars($error_message) ?></p>
                <?php endif; ?>
                <p>Après avoir cliqué sur "Continuer", un mail contenant votre nouveau mot de passe vous sera envoyé sur votre adresse mail.</p>
                <button type="submit" name="submit">Continuer</button>
            </form>
        </div>
    </div>
</body>
</html>
