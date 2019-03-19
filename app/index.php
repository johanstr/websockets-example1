<?php

try {
    $db_connection = new PDO("mysql:host=localhost;dbname=websockets", 'root', 'root',[]);

    $db_query = $db_connection->prepare('SELECT * FROM workshops');

    $db_query->execute();

    $rows = $db_query->fetchAll();
} catch(PDOException $e) {
    die('AAAERROR: ' . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="nl">

    <head>
        <meta charset="UTF-8" />

        <title>Websocket voorbeeld</title>

        <link rel="stylesheet" href="css/style.css" />
    </head>

    <body>
        <div class="form">
            <h1>Websocket Voorbeeld - Client</h1>
            <h2>Plaatsen reserveren voor workshops</h2>

            <div class="form-body">
                <div class="form-element">
                    <label for="workshop-select">Selecteer een workshop:</label>

                    <select id="workshop-select" name="workshop">
                        <?php foreach($rows as $row): ?>
                            <option value="<?= $row['id']; ?>"><?= $row['titel']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-element">
                    <input id="submit-btn" type="button" value="Reserveer" />
                </div>
            </div>

            <div class="workshop-list">
                <h3>Workshops:</h3>
                <ul>
                    <?php foreach($rows as $row): ?>
                        <li id="workshop-<?= $row['id']; ?>">
                            <span class="workshop-title"><?= $row['titel']; ?></span>
                            <span class="workshop-places"><?= $row['plaatsen']; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>

        <script type="text/javascript" src="js/socket-client.js"></script>
    </body>

</html>
