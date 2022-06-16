<?php

// champs du formulaire rempli vide 
$prenom = $nom = $telephone = $email = $sujet = $message = "";
$prenomErreur = $nomErreur = $emailErreur = $sujetErreur = $messageErreur = "";

//adresse mail de reception du formaulaire
$emailTo = "kevin.marechal.via@gmail.com";

//boolean faux tant que le formulaire pas valider
$isSuccess = false;

//champs du formulaire pré-rempli par les informations déja données
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = verifyInuput($_POST["prenom"]);
    $nom = verifyInuput($_POST["nom"]);
    $telephone = verifyInuput($_POST["telephone"]);
    $email = verifyInuput($_POST["email"]);
    $sujet = verifyInuput($_POST["sujet"]);
    $message = verifyInuput($_POST["message"]);
    $emailText = "";

    if (empty($prenom)) {
        $prenomErreur = " Ton prénom !! ";
        $isSuccess = false;
    } else
        $emailText .= "prenom : $prenom\n";

    if (empty($nom)) {
        $nomErreur = " Ton nom !! ";
        $isSuccess = false;
    } else
        $emailText .= "nom : $nom\n";

    if (!isEmail($email)) {
        $emailErreur = " Ton email !! ";
        $isSuccess = false;
    } else
        $emailText .= "email : $email\n";

    if (empty($sujet)) {
        $sujetErreur = " Ton sujet !! ";
        $isSuccess = false;
    } else
        $emailText .= "sujet : $sujet\n";

    if (empty($message)) {
        $messageErreur = " Ton message !! ";
        $isSuccess = false;
    } else
        $emailText .= "message : $message\n";

    if ($isSuccess) {
        $headers = "De: $prenom $nom <$email>\r\nReply-To : $email";
        mail($emailTo, "un nouveau message", $emailText, $headers);
        $prenom = $nom = $email = $sujet = $message = "";
    }
}
//verification des champs saisis ( pas d'antislash, ni caracteres speciaux)
function verifyInuput($var)
{
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);

    return $var;
}
//verification que l'adresse est valide
function isEmail($var)
{
    return filter_var($var, FILTER_VALIDATE_EMAIL);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Exercice d'autonomie</title>
</head>

<body>
    <div class="container">
        <div class="divider"></div>
        <div class="header">
            <h2>Contactez-moi </h2>
        </div>
        <div class="row" id="bloc">
            <div class="col-lg-10 col-lg-offset-1">

                <form id="formulaire_contact" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" role="form">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nom">Nom<span class="blue">*</span> :</label>
                            <input type="text" name="nom" class="formulaire" placeholder="Votre nom" value="<?php echo $nom; ?>">
                            <p class="erreur"><?php echo $nomErreur ?> </p>
                        </div>

                        <div class="col-md-12">
                            <label for="prenom">Prénom<span class="blue">*</span> :</label>
                            <input type="text" name="prenom" class="formulaire" placeholder="Votre prénom" value="<?php echo $prenom; ?>">
                            <p class="erreur"><?php echo $prenomErreur; ?></p>
                        </div>

                        <div class="col-md-12">
                            <label for="email">Email<span class="blue">*</span> :</label>
                            <input type="email" name="email" class="formulaire" placeholder="Votre email" value="<?php echo $email; ?>">
                            <p class="erreur"><?php echo $emailErreur; ?></p>
                        </div>

                        <div class="col-md-12">
                            <label for="telephone">Télephone :</label>
                            <input type="text" name="telephone" class="formulaire" placeholder="Votre N° telephone" value="<?php echo $telephone; ?>">
                        </div>

                        <div class="col-md-12">
                            <label for="sujet">Sujet<span class="blue">*</span> :</label>
                            <select type="text" name="sujet" class="formulaire" placeholder="Sujet" value="<?php echo $sujet; ?>">
                                <option value="php">Php</option>
                                <option value="javascript">Javascript</option>
                                <option value="html_css">Html/css</option>
                                <option value="autre">Autre sujet</option>
                            </select>
                            <p class="erreur"><?php echo $sujetErreur; ?></p>
                        </div>

                        <div class="col-md-12">
                            <label for="message">Votre message<span class="blue">*</span> :</label>
                            <textarea id="message" name="message" placeholder="Votre message" value="<?php echo $message; ?>"></textarea>
                            <p class="erreur"><?php echo $messageErreur; ?></p>
                        </div>

                        <div class="col-md-12">
                            <p class="blue"><strong> * Ces informations sont requises</strong></p>
                        </div>

                        <!--CAPTCHA-->
                        <div class="col-md-12">
                        <form action="validate.php" method="post">
                            <table>
                                <tr>
                                    <td>
                                        <label>Entrer le texte dans l'image</label>
                          a &&²              <input name="captcha" type="text">
                                        <img src="captcha.php" style="vertical-align: middle;" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                        </div>
                        <!--FIN CAPTCHA-->
                        <div class="col-md-12">
                            <input type="submit" id="buttonValide" value="Envoyer">
                        </div>
                    </div>

                    <p class="message_envoye" style="display:<?php if ($isSuccess) echo 'block'; else echo 'none'; ?>">Votre message à bien etait envoyé merci !!</p>
            </div>

            </form>
        </div>
    </div>

    </div>
</body>

</html>