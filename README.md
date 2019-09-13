# assert-pdfs

A simple assertion package to work with PDFs and PHPUnit.

Please ensure that you have Imagick install/available and it has permission to write to PDF. (See:
[this on stack overflow](https://stackoverflow.com/a/38222027). You may need to run something like:

``` sudo sed -i -e 's/rights="none" pattern="PDF"/rights="read|write" pattern="PDF"/' /etc/ImageMagick-6/policy.xml```

This is effectively a package up of 
[this starting point from Gordon Lesti](https://gordonlesti.com/phpunit-compare-generated-pdf-files-with-imagick).

## Installation
``` composer require --dev konsulting/assert-pdfs ```

## Usage

Include the trait on your test class. Available methods:

` assertPdfSame($assertedPdf, $testPdf, $saveDiffToFile = null)` - You can optionally save the diff of the pdf on
 failure to a file by providing a path to save to.
 
 Hopefully we can add some more methods when we need them (or you do).
 
 ## Contribution
 
 Please feel free to contribute.
