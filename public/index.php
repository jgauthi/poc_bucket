<?php
require_once __DIR__.'/init.inc.php';

$bucket = init_bucket_client();

// Si un fichier précis est demandé
$file = $_GET['file'] ?? null;

if ($file) {
    $object = $bucket->object($file);
    if (!$object->exists()) {
        die('Image non trouvée');
    }

    // Générer une URL signée valide 15 minutes
    $url = $object->signedUrl(new DateTime('+15 minutes'));
    header('Location: ' . $url);
    exit;
}

// Sinon, liste simple des images du dossier
$objects = $bucket->objects(['prefix' => BUCKET_FOLDER]);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Images dans GCS</title>
    <style>
        img { max-width: 300px; margin: 10px; border: 1px solid #ccc; }
    </style>
</head>
<body>
<h1>Bucket</h1>
<h2>Images uploadées</h2>
<p><a href="upload.php">← Retour upload</a></p>

<?php if (!empty($_GET['deleted'])): ?>
<p style="color: green;">
    Fichier supprimé: <?= htmlspecialchars($_GET['deleted']) ?>
</p>
<?php endif; ?>

<?php if (!iterator_count($objects)): ?>
    <p>Aucune image trouvée dans le dossier <?=BUCKET_FOLDER?>.</p>

<?php else: foreach ($objects as $object): ?>
    <?php
    if (!str_starts_with($object->name(), BUCKET_FOLDER)) continue;

    // URL signée courte (5 min suffisent pour affichage)
    $url = $object->signedUrl(new DateTime('+5 minutes'));
    $originaleFilename = $object->info()['metadata']['originalFilename'] ?? basename($object->name());
    ?>
    <div style="display:inline-block; text-align:center;">
        <a href="index.php?file=<?= urlencode($object->name()) ?>" target="_blank" title="<?=$originaleFilename?>">
            <img src="<?= $url ?>" alt="<?= basename($object->name()) ?>">
        </a>
        <br>
        <small><?= htmlspecialchars(basename($object->name())) ?></small>
        <br>

        <a href="download.php?file=<?= urlencode($object->name()) ?>">Télécharger</a>
        |
        <a href="delete.php?file=<?= urlencode($object->name()) ?>"
           onclick="return confirm('Supprimer ce fichier ?');">Supprimer</a>
    </div>

<?php endforeach; endif; ?>

</body>
</html>