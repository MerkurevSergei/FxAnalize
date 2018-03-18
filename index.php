<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <link rel="stylesheet" type="text/css" href="style.css">
    <title>FxAnalize</title>
</head>
<body class="grid-main">
<header class="grid-main__header">

</header>
<main role="main">
    <pre>
    <?php
    ini_set('max_execution_time', 1000000);
    ini_set('memory_limit', '2048M');
    define('ROOT', realpath(__DIR__));
    require_once __DIR__ . '/vendor/autoload.php';
    foreach ($_POST as $key => $value) {
        require_once(ROOT . '/app/' . $key . '.php');
    }
    ?>
    </pre>

    <form action="index.php" method="post">
        <fieldset>
            <input type="checkbox" name="runMapperIBP" id="MapperIBP">
            <label for="MapperIBP">Запустить MapperIBP</label>
            <br>
            <input type="checkbox" name="runMapperLEP" id="MapperLEP">
            <label for="MapperLEP">Запустить MapperLEP</label>
        </fieldset>
        <fieldset>
            <input type="checkbox" name="runAppraiserBuyForMapIBP" id="AppraiserBuy">
            <label for="AppraiserBuy">Запустить оценщик на покупку для MapIBP</label>
            <br>
            <input type="checkbox" name="runAppraiserBuyForMapIBPFP" id="AppraiserBuy2">
            <label for="AppraiserBuy2">Запустить оценщик на покупку для MapIBP,ПЕРВЫЙ ПИК</label>
            <br>
            <input type="checkbox" name="runAppraiserLEP" id="AppraiserLEP">
            <label for="AppraiserLEP">Запустить оценщик LEP</label>
        </fieldset>
        <fieldset>
            <input type="checkbox" name="runPredictorIBP" id="PredictorIBP">
            <label for="PredictorIBP">Запустить PredictorIBP</label>
            <br>
            <input type="checkbox" name="runPredictorUBP" id="PredictorUBP">
            <label for="PredictorUBP">Запустить PredictorUBP</label>
        </fieldset>
        <fieldset>
            <input type="checkbox" name="runTest" id="Test">
            <label for="Test">Запустить тесты</label>
        </fieldset>
        <input type="submit" value="Запуск">
    </form>
</main>
<footer>

</footer>
</body>
</html>