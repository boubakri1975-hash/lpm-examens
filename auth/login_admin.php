<?php
// Démarrage de la session
session_start();

// Message d'erreur (optionnel)
$error = "";

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

    /*
     * ⚠️ VERSION INITIALE (SANS BASE DE DONNÉES)
     * À remplacer plus tard par une vérification en base MySQL
     */
    $admin_user = "admin";
    $admin_pass = "admin123"; // à chiffrer plus tard

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION["admin_logged"] = true;
        $_SESSION["admin_user"] = $username;

        header("Location: ../admin/dashboard.php");
        exit;
    } else {
        $error = "Identifiant ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Administration – LPM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS principal -->
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

    <!-- =========================
         HEADER
    ========================== -->
    <header>
        <h1>Lycée Pilote de Manouba</h1>
        <p>Accès réservé à l’administration</p>
    </header>

    <!-- =========================
         FORMULAIRE DE CONNEXION
    ========================== -->
    <main>
        <section style="max-width: 400px; margin: auto;">

            <h2 style="text-align:center;">Connexion Administrateur</h2>

            <?php if ($error): ?>
                <p style="color:red; text-align:center;">
                    <?= htmlspecialchars($error) ?>
                </p>
            <?php endif; ?>

            <form method="post" action="">
                <label for="username">Identifiant</label>
                <input type="text" name="username" id="username" required>

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>

                <button type="submit" class="btn" style="width:100%;">
                    Se connecter
                </button>
            </form>

            <p style="text-align:center; margin-top:15px;">
                <a href="../index.html">← Retour à l'accueil</a>
            </p>

        </section>
    </main>

    <!-- =========================
         FOOTER
    ========================== -->
    <footer>
        <p>&copy; 2026 – Lycée Pilote de Manouba</p>
    </footer>

</body>
</html>
