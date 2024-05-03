<?php
// Vérifie si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn1'])) {
    // Inclure le fichier de connexion à la base de données
    include "connixen.php";

    // Préparer et lier les paramètres
    $id_commande = 'MO' . rand(100000, 999999);
    $full_name = $_POST['name'];
    $tele = $_POST['tele'];
    $city = $_POST['city'];
    $price = $_POST['prix'];
    $address = $_POST['adresse'];

    // Insérer des données dans la base de données
    $stmt = $con->prepare('INSERT INTO ramassage (Id_commande, Full_name, Tele, Addrese, City, Prix) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param("ssssss", $id_commande, $full_name, $tele, $address, $city, $price); // Utilisation de $id_commande

    if ($stmt->execute()) {
        header("location: ramassage.php");
        exit; 
    } else {
        // Gérer l'erreur
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}
?>
