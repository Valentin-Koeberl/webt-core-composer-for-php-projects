<?php

namespace Laurensvidan\WebtCoreComposerForPhpProjects;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeGenerator {
    /**
     * Generates a QR code for the given phone number.
     *
     * @param string $number The phone number.
     * @return string The relative path to the generated QR code image.
     */
    public function generate(string $number): string {

        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $number,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            labelText: 'This is the label',
            labelFont: new OpenSans(20),
            labelAlignment: LabelAlignment::Center,
            logoPath: __DIR__.'/assets/symfony.png',
            logoResizeToWidth: 50,
            logoPunchoutBackground: true
        );

        $result = $builder->build();

        // Save the file into the public folder so that it is web-accessible.
        $filePath = __DIR__ . '/../public/qrcode.png';
        $result->saveToFile($filePath);

        // Return a relative path that can be used in the HTML.
        return 'qrcode.png';
    }
}
