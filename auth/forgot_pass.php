<!-- Le fichier principal sera une page de connexion 
pour (L'Admin et les Bibliothécaires) 
Notons que si la session du bibliothécaire est lancée il ne peux plus avoir
à cette page de même pour l'administrateur
-->
<?php require "../includes/student_session.php" ?>
<?php require "../config/config.php" ?>

<?php 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';

    if(isset($_SESSION['stu_ine'])){
        header("location: ../");
        exit();
    }

   //Creons un mot de passe unique et aléatoire pour l'etudiant
    function generateUniquePass($conn){
        $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOOPQRSTUVWXYZ';
        $charLength = strlen($char);
        do{
            $randomString = '';
            for($i = 0; $i < 8; $i++){
                $randomString .= $char[rand(0,$charLength-1)];
            }

            //Verifions si le mot de passe existe déjà
            $stmt = $conn->prepare("SELECT student_pass FROM student");
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $exists = 0;
            foreach($students as $student){
                if(password_verify($randomString, $student['student_pass'])){
                    $exists = 1;
                }
            }
        } while ( $exists == 1 ); //Continuer à générer si on rencontre un mm mot de passe existant

        return $randomString;
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
                 // Création du mot de passe et hachage. Ce mot de passe est unique
                $aleatPassword = generateUniquePass($conn);
                $hashed_pass = password_hash($aleatPassword, PASSWORD_DEFAULT);
                $sql = "UPDATE student SET student_pass = :pass WHERE student_ine = :ine";
                $update = $conn->prepare($sql);         
                $update->bindParam(':pass', $hashed_pass);
                $update->bindParam(':ine', $ine);

                //Le mot de passe est mis à jour maintenant envoyons le nouveau mot de passe sur le mail
                $student_name = strtoupper($fetch['student_name']);
                $student_mail = $mail;
                $mailer = new PHPMailer(true);

                try{
                    $mailer->isSMTP();
                    $mailer->Host = 'smtp.gmail.com';
                    $mailer->SMTPAuth = true;
                    $mailer->Username = 'booktrack.team@gmail.com';
                    $mailer->Password = 'swuiaruroyezulpz';
                    $mailer->SMTPSecure = 'ssl';
                    $mailer->Port = 465;
                    $mailer->setFrom('booktrack.team@gmail.com', 'BookTrack');
                    $mailer->addAddress($student_mail, $student_name);
                    $mailer->isHTML(true);
                    $mailer->Subject = 'Nouveau mot de passe';
                    $mailer->Body = "Bonjour $student_name,<br><br>Vos nouvelles informations de connexion sur la plateforme sont:<br>INE: <strong>$ine</strong>,<br>Mot de passe: <strong>$aleatPassword</strong>. <br><br>Cordialement, l'équipe de BookTrack.";
                    $mailer->AltBody = "Bonjour <strong>$student_name</strong>,\n\nVos nouvelles informations de connexion sur la plateforme sont:\nINE: $ine,\nMot de passe: $aleatPassword. \n\nCordialement, l'équipe de BookTrack.";

                    $mailer->send();
                    header("location: login.php");
                    exit();
                } catch (Exception $e) {
                    $error_message = "Mot de passe changé mais Email non envoyé!";
                }

            } else {
                $error_message = "Données incorrectes.";
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
                    <span class="placeholder">EMAIL</span>
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
