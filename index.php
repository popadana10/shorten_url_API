<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="style.css">

<head>
    <meta charset="UTF-8">
    <title>URL Shortener</title>
</head>

<body>
  <header>
    <h1>Shorten long URL</h1>
  </header>
  <section class="form">
    <form method="post" class="form">
    <label for="longUrl" value="https://example.com"></label>
        <input type="text" id="long_url" name="longUrl" required>
        <button type="submit">SHORTEN</button>
    </form>
    </section>
    <section class="urls">
    <?php

function shortenURL($longUrl, $accessToken) {
    $url = 'https://unelma.io/api/v1/link';
    $data = [
        "type" => "direct",
        "password" => null,
        "active" => true,
        "expires_at" => "2025-05-06",
        "activates_at" => "2024-05-07",
        "utm" => "utm_source=google&utm_medium=banner",
        "domain_id" => null,
        "long_url" => $longUrl
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken,
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return 'Error:' . curl_error($ch);
    } else {
        $responseDecoded = json_decode($response, true);
        if (isset($responseDecoded['link']['short_url'])) {
            return $responseDecoded['link']['short_url'];
        } else {
            return 'Shortened URL not found in the response.';
        }
    }

    curl_close($ch);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accessToken = '30|OYnyvHedodfupueD0lvl1gZ0bf3tlvnig6nuU1T9f6a62e03'; 

    $longUrl = $_POST['longUrl'];
    $shortUrl = shortenURL($longUrl, $accessToken);

    echo 'Short URL: <a href="' . $shortUrl . '">' . $shortUrl . '</a>';
}

?>
    </section>
</body>

</html>

