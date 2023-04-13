<?php
$documents = json_decode(file_get_contents('documents.json'));
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Google Tabulky</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22256%22 height=%22256%22 viewBox=%220 0 100 100%22><text x=%2250%%22 y=%2250%%22 dominant-baseline=%22central%22 text-anchor=%22middle%22 font-size=%2290%22>📜</text></svg>" />
    <style>
        body {
            background-color: #f7f7f7;
            color: #333;
            font-family: 'Segoe Ui', sans-serif;
            font-size: 18px;
            padding: 64px;
        }

        table {
            border-collapse: collapse;
        }

        td {
            border: 1px solid #333;
            text-align: center;
            padding: 8px;
        }

        button {
            background: none;
            border: none;
            color: #4222db;
            cursor: pointer;
            font: inherit;
            font-weight: 600;
            padding: 0;
        }

        a {
            text-decoration: none;
        }

        v-cloak {
            display: none;
        }
    </style>
    <script src="assets/petite-vue.js" defer init></script>
</head>

<body>
    <table>
        <tbody>
            <?php foreach ($documents as $doc) : ?>
                <?php if ($doc->active) : ?>
                    <tr>
                        <td>
                            <strong>
                                <?= $doc->title ?>
                            </strong>
                            <a href="https://docs.google.com/spreadsheets/d/<?= $doc->id ?>" target="_blank">
                                📝
                            </a>
                        </td>
                        <td>
                            [<?= $doc->shortcode ?>]
                        </td>
                        <td>
                            <button type="button" name="<?= $doc->id ?>">
                                Vygenerovat
                            </button>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div v-scope="{ show: false }">
        <button @click="show = !show" type="button" style="margin: 1.2em 0;">
            Starší
        </button>
        <table v-if="show" v-cloak>
            <tbody>
                <?php foreach ($documents as $doc) : ?>
                    <?php if (!$doc->active) : ?>
                        <tr>
                            <td>
                                <strong>
                                    <?= $doc->title ?>
                                </strong>
                                <a href="https://docs.google.com/spreadsheets/d/<?= $doc->id ?>" target="_blank">
                                    📝
                                </a>
                            </td>
                            <td>
                                [<?= $doc->shortcode ?>]
                            </td>
                            <td>
                                <button @click="generateData($el)" type="button" name="<?= $doc->id ?>">
                                    Vygenerovat
                                </button>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        window.generateData = (element) => {
            fetch('generate.php?id=' + element.getAttribute('name'))
                .then((response) => {
                    if (response.ok) {
                        return response.text();
                    }
                    throw new Error('Něco se pokazilo');
                })
                .then(() => {
                    alert('Vygenerováno!');
                })
                .catch((error) => {
                    alert(error)
                    console.error('There has been a problem with your fetch operation:', error);
                });
        }

        document.querySelectorAll('button[name]').forEach(button => {
            button.addEventListener('click', event => {
                generateData(event.target);
            })
        })
    </script>
</body>

</html>
