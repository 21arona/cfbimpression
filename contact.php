<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configuration de l'adresse e-mail et du sujet
    $to = "aronadiop067@gmail.com";
    $subject = "Nouveau message dans cfb Impression";

    // Validation et récupération des données du formulaire
    $name = htmlspecialchars($_POST['contactName']);
    $email = htmlspecialchars($_POST['contactEmail']);
    $subject_message = htmlspecialchars($_POST['contactSubject']);
    $message = htmlspecialchars($_POST['contactMessage']);

    // Préparer le message
    $email_message = "Nom: $name\n";
    $email_message .= "Email: $email\n";
    $email_message .= "Sujet: $subject_message\n";
    $email_message .= "Message:\n$message\n";

    // Traitement du fichier téléchargé
    $file_path = "";
    if (isset($_FILES['contactFile']) && $_FILES['contactFile']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['contactFile']['tmp_name'];
        $file_name = $_FILES['contactFile']['name'];
        $file_size = $_FILES['contactFile']['size'];
        $file_type = $_FILES['contactFile']['type'];

        // Chemin pour enregistrer le fichier temporairement
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_path = $upload_dir . basename($file_name);
        move_uploaded_file($file_tmp_name, $file_path);

        // Ajouter l'information du fichier à l'e-mail
        $email_message .= "\nFichier joint: $file_name\n";
    }

    // En-têtes pour l'e-mail
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Envoyer l'e-mail
    $success = mail($to, $subject, $email_message, $headers);

    // Réponse en fonction du résultat de l'envoi
    if ($success) {
        echo "<h3>Message bien envoyé !</h3>";
    } else {
        echo "<h3>Une erreur est survenue. Veuillez réessayer.</h3>";
    }
} else {
    echo "<h3>Formulaire non soumis correctement.</h3>";
}
