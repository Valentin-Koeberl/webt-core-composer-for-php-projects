<?php

require_once '../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

// Default phone number for demo
$phoneNumber = "+43 1 22 33 444";

// Check if user submitted a phone number
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["phone_number"])) {
    $phoneNumber = $_POST["phone_number"];
}

$builder = new Builder(
    writer: new PngWriter(),
    writerOptions: [],
    validateResult: false,
    data: $phoneNumber,
    encoding: new Encoding('UTF-8'),
    errorCorrectionLevel: ErrorCorrectionLevel::High,
    size: 300,
    margin: 10,
    roundBlockSizeMode: RoundBlockSizeMode::Margin
);

$result = $builder->build();
$dataUri = $result->getDataUri();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        form {
            margin: 20px;
        }

        input, button {
            padding: 10px;
            margin: 10px;
        }

        img {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<h1>QR Code Generator</h1>
<p>Enter your phone number to generate a QR Code:</p>
<form method="POST">
    <input type="text" name="phone_number" placeholder="Gib numma puppe" required>
    <button type="submit">Generate QR Code</button>
</form>
<h2>QR Code:</h2>
<img src="<?= $dataUri ?>" alt="QR Code">
</body>
</html>
