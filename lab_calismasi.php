<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "veritabani";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

if (isset($_POST['kayit'])) {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $email = $_POST['email'];

    $sql = "INSERT INTO kisiler (ad, soyad, email) VALUES ('$ad', '$soyad', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo "Kayıt başarıyla eklendi!";
    } else {
        echo "Hata: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['arama'])) {
    $aranan = $_POST['aranan'];
    $sql = "SELECT * FROM kisiler WHERE ad LIKE '%$aranan%' OR soyad LIKE '%$aranan%' OR email LIKE '%$aranan%'";
    $sonuc = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Kayıt ve Arama</title>
</head>
<body>
    <h1>Kullanıcı Kayıt</h1>
    <form method="post" action="">
        <label>Ad:</label>
        <input type="text" name="ad" required><br><br>
        <label>Soyad:</label>
        <input type="text" name="soyad" required><br><br>
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        <button type="submit" name="kayit">Kaydet</button>
    </form>

    <h1>Kullanıcı Arama</h1>
    <form method="post" action="">
        <label>Aranan:</label>
        <input type="text" name="aranan" required><br><br>
        <button type="submit" name="arama">Ara</button>
    </form>

    <?php
    if (isset($sonuc) && $sonuc->num_rows > 0) {
        echo "<h2>Arama Sonuçları:</h2>";
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Ad</th>
                    <th>Soyad</th>
                    <th>Email</th>
                </tr>";
        while ($row = $sonuc->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['ad'] . "</td>
                    <td>" . $row['soyad'] . "</td>
                    <td>" . $row['email'] . "</td>
                </tr>";
        }
        echo "</table>";
    } elseif (isset($sonuc)) {
        echo "Sonuç bulunamadı.";
    }
    ?>

</body>
</html>
