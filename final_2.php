<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6fb1fc, #4364f7);
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            max-width: 750px;
            width: 100%;
            color: #333;
        }
        h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
            color: #4364f7;
            font-weight: bold;
        }
        label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
            font-size: 18px;
        }
        .radio-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .radio-group input[type="radio"] {
            display: none;
        }
        .radio-group label {
            padding: 12px 18px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.4s, border-color 0.4s;
            font-size: 16px;
        }
        .radio-group input[type="radio"]:checked + label {
            background: #4364f7;
            color: #fff;
            border-color: #4364f7;
        }
        button {
            display: block;
            width: 100%;
            padding: 14px;
            border: none;
            background: #4364f7;
            color: white;
            border-radius: 10px;
            font-size: 18px;
            margin-top: 20px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }
        button:hover {
            background: #2c50c4;
        }
        .alert {
            margin-top: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .sonuclar {
            margin-top: 30px;
        }
        .sonuclar h2 {
            font-size: 26px;
            margin-bottom: 15px;
            color: #333;
        }
        .sonuclar h3 {
            font-size: 20px;
            margin: 15px 0;
            color: #555;
        }
        .bar-wrapper {
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            height: 35px;
            margin-bottom: 15px;
            position: relative;
        }
        .bar {
            height: 100%;
            background: linear-gradient(135deg, #6fb1fc, #4364f7);
            transition: width 0.4s;
        }
        .bar-text {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            font-weight: bold;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Anket</h1>
        <form method="POST" action="">
            <?php
            $mysqli = new mysqli("localhost", "root", "", "anket2");
            if ($mysqli->connect_error) {
                die("Bağlantı hatası: " . $mysqli->connect_error);
            }

            $sorular_sorgu = $mysqli->query("SELECT * FROM anket2_tablo");
            if ($sorular_sorgu->num_rows > 0) {
                while ($soru = $sorular_sorgu->fetch_assoc()) {
                    $soru_id = $soru['id'];
                    $soru_metni = $soru['soru'];
                    $secenekler = json_decode($soru['secenekler'], true);
                    echo "<label>" . htmlspecialchars($soru_metni) . "</label>";
                    echo "<div class='radio-group'>";
                    foreach ($secenekler as $secenek) {
                        echo "<input type='radio' name='cevap_$soru_id' value='" . htmlspecialchars($secenek) . "' id='cevap_" . $soru_id . "_" . htmlspecialchars($secenek) . "' required>";
                        echo "<label for='cevap_" . $soru_id . "_" . htmlspecialchars($secenek) . "'>" . htmlspecialchars($secenek) . "</label>";
                    }
                    echo "</div>";
                }
            }
            ?>
            <button type="submit" name="oyla">Oy Ver</button>
        </form>

        <?php
        if (isset($_POST['oyla'])) {
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'cevap_') === 0) {
                    $soru_id = str_replace('cevap_', '', $key);
                    $oy_sorgu = $mysqli->prepare("UPDATE anket2_tablo SET oylar = JSON_SET(oylar, ?, COALESCE(JSON_EXTRACT(oylar, ?), 0) + 1) WHERE id = ?");
                    $json_key = '$."' . $value . '"';
                    $oy_sorgu->bind_param('ssi', $json_key, $json_key, $soru_id);
                    $oy_sorgu->execute();
                }
            }
            echo "<div class='alert alert-success mt-3'>Oylarınız kaydedildi!</div>";
        }
        ?>

        <div class="sonuclar">
            <h2>Sonuçlar</h2>
            <?php
            $sonuclar_sorgu = $mysqli->query("SELECT * FROM anket2_tablo");
            while ($soru = $sonuclar_sorgu->fetch_assoc()) {
                $soru_metni = $soru['soru'];
                $oylar = json_decode($soru['oylar'], true);
                $toplam_oy = array_sum($oylar);
                echo "<h3>" . htmlspecialchars($soru_metni) . "</h3>";
                foreach ($oylar as $secenek => $oy) {
                    $yuzde = $toplam_oy > 0 ? ($oy / $toplam_oy) * 100 : 0;
                    echo "<div class='bar-wrapper'>";
                    echo "<div class='bar' style='width: " . $yuzde . "%'></div>";
                    echo "<div class='bar-text'>%" . round($yuzde, 2) . " - " . htmlspecialchars($secenek) . "</div>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
