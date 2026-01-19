<?php
session_start();

// Vérification si admin connecté
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header("Location: ../auth/login_admin.php");
    exit;
}

require_once "../config/database.php";

// ----------------------------
// Traitement formulaire ajout
// ----------------------------
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
    $niveau = isset($_POST['niveau']) ? trim($_POST['niveau']) : '';

    if ($nom && $prenom && $niveau) {

        // Génération matricule automatique
        $last_id_result = $conn->query("SELECT MAX(id) AS max_id FROM eleves");
        $last_id_row = $last_id_result->fetch_assoc();
        $last_id = isset($last_id_row['max_id']) ? $last_id_row['max_id'] : 0;
        $last_id++;

        $matricule = "LPM-" . str_pad($last_id, 5, "0", STR_PAD_LEFT);

        // Préparation requête sécurisée
        $stmt = $conn->prepare("INSERT INTO eleves (nom, prenom, niveau, matricule) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nom, $prenom, $niveau, $matricule);

        if ($stmt->execute()) {
            $message = "Élève ajouté avec succès : $matricule";
        } else {
            $message = "Erreur lors de l'ajout de l'élève.";
        }
        $stmt->close();
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}

// ----------------------------
// Récupération des élèves
// ----------------------------
$eleves_result = $conn->query("SELECT * FROM eleves ORDER BY id ASC");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des élèves – LPM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

<header>
    <h1>Gestion des élèves</h1>
    <p><a href="dashboard.php" class="btn">← Retour Dashboard</a></p>
</header>

<main>
    <section style="max-width: 500px; margin:auto;">

        <?php if ($message): ?>
            <p class="<?= strpos($message, 'Erreur') !== false ? 'alert-danger' : 'alert-success' ?>">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <!-- FORMULAIRE AJOUT ÉLÈVE -->
        <h2>Ajouter un élève</h2>
        <form method="post" action="">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="niveau">Niveau</label>
            <input type="text" id="niveau" name="niveau" placeholder="Ex: 2ème secondaire" required>

            <button type="submit" class="btn">Ajouter</button>
        </form>
    </section>

    <!-- TABLEAU ÉLÈVES -->
    <section style="max-width: 900px; margin:40px auto;">
        <h2>Liste des élèves</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Niveau</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($eleves_result->num_rows > 0): ?>
                    <?php while ($eleve = $eleves_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $eleve['id'] ?></td>
                            <td><?= htmlspecialchars($eleve['matricule']) ?></td>
                            <td><?= htmlspecialchars($eleve['nom']) ?></td>
                            <td><?= htmlspecialchars($eleve['prenom']) ?></td>
                            <td><?= htmlspecialchars($eleve['niveau']) ?></td>
                            <td>
                                <a href="modifier_eleve.php?id=<?= $eleve['id'] ?>" class="btn">Modifier</a>
                                <a href="supprimer_eleve.php?id=<?= $eleve['id'] ?>" class="btn" style="background-color:#c62828;">Supprimer</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">Aucun élève enregistré.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<footer>
    <p>&copy; 2026 – Lycée Pilote de Manouba</p>
</footer>

</body>
</html>
