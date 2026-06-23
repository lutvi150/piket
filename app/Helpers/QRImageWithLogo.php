<?php

namespace App\Helpers;

use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\{QRGdImage, QRCodeOutputException};

class QRImageWithLogo extends QRGdImage
{
    /**
     * @param string|null $file
     * @param string|null $logo
     *
     * @return string
     * @throws QRCodeOutputException
     */
    public function dump(string $file = null, string $logo = null): string
    {
        $this->options->returnResource = true;

        if (!is_file($logo) || !is_readable($logo)) {
            throw new QRCodeOutputException('invalid logo');
        }

        parent::dump($file);

        $im = imagecreatefrompng($logo);

        $w = imagesx($im);
        $h = imagesy($im);

        $lw = ($this->options->logoSpaceWidth - 2) * $this->options->scale;
        $lh = ($this->options->logoSpaceHeight - 2) * $this->options->scale;

        $ql = $this->matrix->size() * $this->options->scale;

        imagecopyresampled($this->image, $im, ($ql - $lw) / 2, ($ql - $lh) / 2, 0, 0, $lw, $lh, $w, $h);

        $imageData = $this->dumpImage();

        if ($file !== null) {
            $this->saveToFile($imageData, $file);
        }

        if ($this->options->imageBase64) {
            $imageData = $this->toBase64DataURI($imageData, 'image/' . $this->options->outputType);
        }

        return $imageData;
    }

    public static function generateQRCodeWithLogo(string $data, string $logoPath, string $outputPath = null)
    {
        $options = new QROptions([
            'version'             => 8,
            'eccLevel'            => EccLevel::H,
            'imageBase64'         => false,
            'addLogoSpace'        => true,
            'logoSpaceWidth'      => 13,
            'logoSpaceHeight'     => 13,
            'scale'               => 6,
            'imageTransparent'    => false,
            'drawCircularModules' => false,
            'circleRadius'        => 0.45,
            'keepAsSquare'        => [QRMatrix::M_FINDER, QRMatrix::M_FINDER_DOT],
        ]);

        $qrcode = new QRCode($options);
        $qrcode->addByteSegment($data);

        $qrOutputInterface = new self($options, $qrcode->getMatrix());

        return $qrOutputInterface->dump($outputPath, $logoPath);
    }
}
