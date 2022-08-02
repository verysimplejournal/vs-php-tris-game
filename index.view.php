<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tris</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3 p-5">
        <?php if (!isset($session['gameHasStarted']) || !$session['gameHasStarted']) { ?>
            <div class="row m-2 py-2">
                <div class="alert alert-info">
                    <span>Click on the button to start</span>
                </div>
            </div>
            <div class="row m-2 py-2">
                <form action="<?php echo $_ENV['APP_URL'] . '/'; ?>" method="post">
                    <div class="col-12">
                        <input type="hidden" name="startGame" value="1">
                        <button class="btn btn-primary">Start Game</button>
                    </div>
                </form>
            </div>
        <?php } else { ?>
            <div class="row m-2 py-2">
                <div class="alert alert-info">
                <?php
                    echo isset($message) ? $message . '<br>' : '';
                    $fine = Tris::hasPlayerWon(is_array($session['positions']) ? $session['positions'] : [], ($session['player'] == 'X' ? 'O' : 'X'));
                    if ($debug) {
                        var_dump($_POST);
                    }
                ?>
                    <?php if (!$fine) { ?>
                    <span>Player: <strong><?php echo $session['player']; ?></strong></span>
                    <?php } else { ?>
                        <span>Winner: <strong><?php echo ($session['player'] == 'X' ? 'O' : 'X'); ?></strong></span>
                    <?php } ?>
                </div>
            </div>
            <?php
                foreach (Tris::POSITIONS as $key => $vals) {
                    echo '<div class="row m-2 py-2">';
                    foreach ($vals as $val) {
                        echo '<div class="col-4">
                        <form action="' . $_ENV['APP_URL'] . '/" method="post">
                            <div class="d-grid">
    
                                <input type="hidden" name="player" value="'.$session['player'].'">
                                <input type="hidden" name="position" value="'.($key . $val).'">
                                <button type="submit" class="btn btn-primary btn-block" '. ($fine ? 'disabled' : '' ) .'>
                                    <strong class="display-6"> ' . ($session['positions'][$key][$val] ?? '?') . '</strong>
                                </button>
                            </div>
                        </form>
                    </div>';
                    }
                    echo '</div>';
                }
            ?>
            
            <div class="row m-2 py-2">
                <form action="<?php echo $_ENV['APP_URL'] . '/'; ?>" method="post">
                    <div class="col-12">
                        <input type="hidden" name="reset" value="1">
                        <button class="btn btn-primary">Restart Game</button>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</body>

</html>