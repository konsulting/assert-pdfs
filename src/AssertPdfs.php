<?php


namespace Konsulting\Testing;


use Imagick;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;

trait AssertPdfs
{
    public function assertPdfSame($assertedPdf, $testPdf, $saveDiffToFile = null, $metric = null)
    {
        // Adapted from: https://gordonlesti.com/phpunit-compare-generated-pdf-files-with-imagick/

        $assertedImagick = new Imagick();
        $assertedImagick->readImageBlob($assertedPdf);
        $assertedImagick->resetIterator();
        $assertedImagick = $assertedImagick->appendImages(true);

        $testImagick = new Imagick();
        $testImagick->readImageBlob($testPdf);
        $testImagick->resetIterator();
        $testImagick = $testImagick->appendImages(true);

        $metric = $metric ?: Imagick::METRIC_ABSOLUTEERRORMETRIC;
        list($diffImage, $diffMeasure) = $assertedImagick->compareImages($testImagick, $metric);

        try {
            Assert::assertSame(0.0, $diffMeasure);
        } catch (ExpectationFailedException $e) {
            if ($saveDiffToFile && file_exists($saveDiffToFile)) {
                unlink($saveDiffToFile);
            }
            if ($saveDiffToFile) {
                $diffImage->writeImages($saveDiffToFile, $adjoin = false);
            }

            throw $e;
        }
    }
}
