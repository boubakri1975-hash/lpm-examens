<?php
// Démarrage de session
session_start();

// Vérification si l'admin est connecté
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header("Location: ../auth/login_admin.php");
    exit;
}

// Nom de l'admin
$admin_user = $_SESSION['admin_user'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrateur – LPM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>

    <!-- =========================
         HEADER
    ========================== -->
    <header>
        <h1>Dashboard Administrateur</h1>
        <p>Bienvenue, <?= htmlspecialchars($admin_user) ?></p>
    </header>

    <!-- =========================
         NAVIGATION ADMIN
    ========================== -->
    <nav>
        <ul>
            <li><a href="../eleves.php">Gestion des élèves</a></li>
            <li><a href="../salles.php">Gestion des salles</a></li>
            <li><a href="../examens.php">Gestion des examens</a></li>
            <li><a href="../repartition.php">Répartition des élèves</a></li>
            <li><a href="../plans_salle.php">Plans de salle</a></li>
            <li><a href="../../auth/logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <!-- =========================
         CONTENU PRINCIPAL
    ========================== -->
    <main>
        <section class="dashboard">
            <div class="card">
                <h3>Élèves</h3>
                <p>Ajouter, modifier ou supprimer des élèves et générer leurs matricules.</p>
                <a href="../eleves.php" class="btn">Gérer les élèves</a>
            </div>

            <div class="card">
                <h3>Salles</h3>
                <p>Ajouter ou modifier les salles et définir la capacité des tables.</p>
                <a href="../salles.php" class="btn">Gérer les salles</a>
            </div>

            <div class="card">
                <h3>Examens</h3>
                <p>Créer des examens avec matière, date, horaire et niveau.</p>
                <a href="../examens.php" class="btn">Gérer les examens</a>
            </div>

            <div class="card">
                <h3>Répartition</h3>
                <p>Attribuer automatiquement les places aux élèves selon les contraintes.</p>
                <a href="../repartition.php" class="btn">Gérer la répartition</a>
            </div>

            <div class="card">
                <h3>Plans de salle</h3>
                <p>Visualiser et imprimer les plans de salle pour chaque examen.</p>
                <a href="../plans_salle.php" class="btn">Voir les plans</a>
            </div>
        </section>
    </main>

    <!-- =========================
         FOOTER
    ========================== -->
    <footer>
        <p>&copy; 2026 – Lycée Pilote de Manouba – Espace Administration</p>
    </footer>

</body>
</html>
