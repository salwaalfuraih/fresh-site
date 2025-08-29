<?php
require_once __DIR__ . '/../src/layout/header.php';

$joke = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = "https://official-joke-api.appspot.com/random_joke";
    $resp = @file_get_contents($url);

    if ($resp === false) {
        $error = "Could not fetch a joke. Please try again!";
    } else {
        $data = json_decode($resp, true);
        if ($data && isset($data['setup']) && isset($data['punchline'])) {
            $joke = $data;
        } else {
            $error = "Invalid joke received.";
        }
    }
}
?>
<link rel="stylesheet" href="/public/assets/styles.css">
<main class="container" style="text-align:center;">
    <h2>Random Joke Generator</h2>
    <form method="post">
        <button type="submit" class="cta-btn">Get a Joke</button>
    </form>
    <?php if ($joke): ?>
        <div class="card" style="margin:2em auto; max-width:480px;">
            <div class="card-title"><?= htmlspecialchars($joke['setup']) ?></div>
            <div style="margin-top:1em; font-weight:500;"><?= htmlspecialchars($joke['punchline']) ?></div>
        </div>
    <?php elseif ($error): ?>
        <div class="flash-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
</main>
<?php require_once __DIR__ . '/../src/layout/footer.php'; ?>