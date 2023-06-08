<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waluty</title>
</head>
<style>
tr, td, table, th
{
    border:1px solid black;
    border-collapse: collapse;
}
body
{
    font-size:1.2vw;
}
#wynik
{
    text-decoration: underline;
}
</style>
<body>
    <?php
        $bazaDanych = mysqli_connect("sql205.infinityfree.com", "if0_34375307", "yaQTOcfnvENMfu","if0_34375307_waluty");
    //Funkcja pobiera dane z API, dekoduje je z formatu json na tablicę PHP, usuwa poprzednie dane z tabeli i zastępuje je nowymi 
        function pobierzWaluty($baza)
        {
            $api_link = "http://api.nbp.pl/api/exchangerates/tables/a/?format=json";
            $dane = file_get_contents($api_link);
            $json = json_decode($dane);
            $rates = $json[0]->rates;
            $baza->query("TRUNCATE TABLE kursy_walut");
            foreach($rates as $rate)
            {
                $baza->query("INSERT INTO kursy_walut (currency, code, mid) VALUES ('".$rate->currency."', '".$rate->code."', '".$rate->mid."');");
            }
            $baza->query("INSERT INTO kursy_walut (currency, code, mid) VALUES ('polski złoty', 'PLN', '1');");
        }
        //Funkcja zapisuje obecne przewalutowanie do bazy danych, pod warunkiem, że nie jest ono identyczne jak poprzednie
        function zapiszWynik($baza, $kwota, $walutaZrodlowa, $walutaDocelowa, $wynik)
        {
            $wiersz = $baza->query("SELECT podana_kwota,waluta_zrodlowa, waluta_docelowa, wynik from przewalutowania order by id desc")->fetch_array();
            if($wiersz['podana_kwota'] == $kwota && $wiersz['waluta_zrodlowa'] == $walutaZrodlowa && $wiersz['waluta_docelowa'] == $walutaDocelowa &&  $wiersz['wynik']==$wynik){
            return;
            }
            $baza->query("INSERT INTO przewalutowania (podana_kwota, waluta_zrodlowa,waluta_docelowa, wynik) VALUES ('".$kwota."','".$walutaZrodlowa."','".$walutaDocelowa."'
            ,'".$wynik."');");
        }
    //Funkcja pobiera informacje z formularza, zamienia wartość waluty na złotówki a następnie na żądaną walutę
    //i wypisuje wynik, lub prosi o podanie kwoty jeśli ta zostala pozostawiona pusta
        function przeliczWalute($baza,$kursy, $kody, $nazwy)
        {
            if(!empty($_POST["kwota"]))
            {
                $wartoscZrodlowa = $kursy[$_POST["walutaZrodlowa"]];
                $wartoscDocelowa = $kursy[$_POST["walutaDocelowa"]];
                $kwota = (float)$_POST["kwota"];
                $wartoscPln = $kwota * $wartoscZrodlowa;
                $wynik = $wartoscPln / $wartoscDocelowa;
                echo $kwota." ".$kody[$_POST["walutaZrodlowa"]]." jest warte ".round($wynik,2)." ".$kody[$_POST["walutaDocelowa"]];
                zapiszWynik($baza, $kwota, $nazwy[$_POST["walutaZrodlowa"]], $nazwy[$_POST["walutaDocelowa"]], $wynik);
                return;
            }
                echo "Podaj kwotę, którą chcesz przeliczyć";
                return;     
        }
    //Funkcja generuje tabelę wszystkich kursów na podstawie informacji z bazy danych
        function generujTabeleKursow($nazwy, $kody, $kursy)
        {
            echo 
            "
            <tr>
            <th>Nazwa waluty</th>
            <th>Kod waluty</th>
            <th>Kurs waluty</th>
            ";
            for($i = 0; $i < count($nazwy); $i++)
            {
                echo 
                "<tr>
                 <td>".$nazwy[$i]."</td>
                 <td>".$kody[$i]."</td>
                 <td>".$kursy[$i]."</td>
                </tr>";

            }
        }
    //Funkcja generuje tabelę zawierającą historię poprzednich przewalutowań przechowywanych w bazie danych
        function generujTabelePrzewalutowan($kwoty, $zrodlowe, $docelowe, $wyniki)
        {
            echo 
            "
            <tr>
            <th>Podana kwota</th>
            <th>Waluta źródłowa</th>
            <th>Waluta docelowa</th>
            <th>Wynik</th>
            ";
            for($i = 0; $i < count($wyniki); $i++)
            {
                echo 
                "<tr>
                 <td>".$kwoty[$i]."</td>
                 <td>".$zrodlowe[$i]."</td>
                 <td>".$docelowe[$i]."</td>
                 <td>".$wyniki[$i]."</td>
                </tr>";

            }
        }
    //Skrypt tworzy na podstawie bazy danych 3 tablice zawierające nazwy walut, ich kody i ich wartość
        pobierzWaluty($bazaDanych);
        $queryDoKursow = $bazaDanych->query("SELECT * from kursy_walut");
        $nazwy = array();
        $kody = array();
        $kursy = array();
        while($row = $queryDoKursow->fetch_array())
        {
            $nazwy[] = $row['currency'];
            $kody[] = $row['code'];
            $kursy[] = $row['mid'];
        } 
    ?>
    <form action="index.php" method="post">
        <p>
        <!-- Skrypt ustawia kwotę na tą wpisaną wcześniej przez użytkownika, która jest zapisana w zmiennej globalnej $_POST, aby użytkownik nie musiał za każdym razem 
        wpisywać wartości od nowa -->
            Kwota: <input type="number" step="0.01" min=0 name="kwota" value=<?php if(isset($_POST['kwota'])){echo "'".$_POST['kwota']."'";}?>/>
            <input type="submit" name="submit-button" value="Przelicz">
        </p>
        <p>
            Waluta źródłowa: <select name="walutaZrodlowa">
                <?php
            //Skrypt tworzy wszystkie opcje do rozwijanej listy walut, ustawiając jako wybraną tą, która została poprzednio wybrana przez użytkownika
            //aby użytkownik nie musiał za każdym razem zaznaczać opcji od nowa
                for($i = 0; $i < count($nazwy); $i++)
                {
                    $nazwaWaluty = $nazwy[$i];
                    $index = $i;
                    if(isset($_POST['walutaZrodlowa']) && $_POST['walutaZrodlowa'] == $index)
                    {
                        echo "<option value='".$index."' selected = 'selected'>".$nazwaWaluty."</option>";
                    }
                    else
                    {
                        echo "<option value='".$index."'>".$nazwaWaluty."</option>";
                    }
                }  
                ?>
            </select>
            Waluta docelowa: <select name="walutaDocelowa">
                <?php
                //Skrypt tworzy wszystkie opcje do rozwijanej listy walut, ustawiając jako wybraną tą, która została poprzednio wybrana przez użytkownika
                //aby użytkownik nie musiał za każdym razem zaznaczać opcji od nowa
                for($i = 0; $i < count($kody); $i++)
                {
                    $nazwaWaluty = $nazwy[$i];
                    $index = $i;
                    if(isset($_POST['walutaDocelowa']) && $_POST['walutaDocelowa'] == $index)
                    {
                        echo "<option value='".$index."' selected = 'selected'>".$nazwaWaluty."</option>";
                    }
                    else
                    {
                        echo "<option value='".$index."'>".$nazwaWaluty."</option>";
                    }
                } 
                ?>
            </select>
        </p>
        <p id="wynik">
            <?php
            //Skrypt pobiera z bazy danych 15 ostatnich rekordów z tabeli przewalutowania i tworzy na ich podstawie tablice 
                przeliczWalute($bazaDanych, $kursy, $kody, $nazwy);
                $queryDoZapisanych = $bazaDanych->query("SELECT * from przewalutowania order by Id desc limit 15");
                $podaneKwoty = array();
                $zrodloweWaluty = array();
                $doceloweWaluty = array();
                $wyniki = array();
                while($row = $queryDoZapisanych->fetch_array())
                    {
                        $podaneKwoty[] = $row['podana_kwota'];
                        $zrodloweWaluty[] = $row['waluta_zrodlowa'];
                        $doceloweWaluty[] = $row['waluta_docelowa'];
                        $wyniki[] = $row['wynik'];
                    }
            ?>
        </p>
    </form>
    <table style="float:left;">
        <?php
            generujTabeleKursow($nazwy, $kody, $kursy);
        ?>
    </table>
    <label style="margin-left:5vw;">Ostatnie 15 przeliczeń</label><br>
    <table style="float:left;margin-left:5vw;">
        <?php
            if(!empty($podaneKwoty)){
            generujTabelePrzewalutowan($podaneKwoty, $zrodloweWaluty, $doceloweWaluty, $wyniki);
            }
            $bazaDanych->close();
        ?>
    </table>
</body>
</html>
