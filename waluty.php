<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waluty</title>
</head>
<body>
    <?php
        $baza = mysqli_connect("localhost", "root", "","waluty");
        function pobierzWaluty()
        {
            $api_link = "http://api.nbp.pl/api/exchangerates/tables/{table}/";
            $json = file_get_contents($api_link);
            $rezultat = json_decode($json);
            return $rezultat;
        }
        $wynik = pobierzWaluty();
        echo "<script>console.log('Debug Objects: " . $wynik . "' );</script>";
    ?>
    <form action="./" method="post">
        <p>Kwota: <input type="number" name="kwota"/></p>
        <p>
            Waluta źródłowa: <select name="walutaZrodlowa">
                <?php

                ?>
            </select>
            Waluta docelowa: <select name="walutaDocelowa">
                <?php

                ?>
            </select>
        </p>
        <p>
            <?php

            ?>
        </p>
    </form>
</body>
</html>