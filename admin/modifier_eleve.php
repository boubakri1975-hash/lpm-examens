<?php
session_start();

// Vérification si admin connecté
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header("Location: ../auth/login_admin.php");
    exit;
}

require_once "../config/database.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";

// Récupérer les infos de l'élève
$stmt = $conn->prepare("SELECT * FROM eleves WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$eleve = $result->fetch_assoc();
$stmt->close();

if (!$eleve) {
    die("Élève introuvable !");
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
    $niveau = isset($_POST['niveau']) ? trim($_POST['niveau']) : '';

    if ($nom && $prenom && $niveau) {
        $stmt = $conn->prepare("UPDATE eleves SET nom = ?, prenom = ?, niveau = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nom, $prenom, $niveau, $id);

        if ($stmt->execute()) {
            $message = "Élève mis à jour avec succès.";
            // Actualiser les données
            $eleve['nom'] = $nom;
            $eleve['prenom'] = $prenom;
            $eleve['niveau'] = $niveau;
        } else {
            $message = "Erreur lors de la mise à jour.";
        }
        $stmt->close();
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier élève – LPM</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<header>
    <h1>Modifier élève</h1>
    <p><a href="eleves.php" class="btn">← Retour à la liste des élèves</a></p>
</header>

<main>
    <section style="max-width: 500px; margin:auto;">

        <?php if ($message): ?>
            <p class="<?= strpos($message, 'Erreur') !== false ? 'alert-danger' : 'alert-success' ?>">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <form method="post" action="">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($eleve['nom']) ?>" required>

            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($eleve['prenom']) ?>" required>

            <label for="niveau">Niveau</label>
            <input type="text" name="niveau" id="niveau" value="<?= htmlspecialchars($eleve['niveau']) ?>" required>

            <button type="submit" class="btn">Mettre à jour</button>
        </form>

    </section>
</main>

<footer>
    <p>&copy; 2026 – Lycée Pilote de Manouba</p>
</footer>
</body>
</html>
