<?php
require_once __DIR__.'/init.inc.php';

$bucket = init_bucket_client();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $objectName = BUCKET_FOLDER. uniqid() . '_' . $file['name']; // on met dans un dossier "uploads/"

        $stream = fopen($file['tmp_name'], 'r');
        $options = [
            'name' => $objectName,
            'metadata' => [
                'metadata' => [
                    'contentType' => $file['type'],
                    'description' => 'Hello World',
                    'originalFilename' => $file['name'],
                ]
            ]
        ];

        $bucket->upload($stream, $options);
        // fclose($stream);

        $message = "Image uploadée avec succès ! → <a href='index.php?file=" . urlencode($objectName) . "' target='_blank'>Voir l'image</a>";
    } else {
        $message = "Erreur d'upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PoC GCS - Upload</title>
</head>
<body>
<h1>Upload d'image vers Google Cloud Storage</h1>

<?php if ($message): ?>
    <p style="color:green;"><?= $message ?></p>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="image" accept="image/*" required>
    <button type="submit">Uploader</button>
</form>

<hr>
<p><a href="index.php">Voir toutes les images uploadées (dossier <?=BUCKET_FOLDER?>)</a></p>
</body>
</html>