<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Konsulting\Testing\AssertPdfs;
use PHPUnit\Framework\ExpectationFailedException;

class AssertPdfsTest extends TestCase
{
    use AssertPdfs;

    /** @test */
    public function it_will_pass_identical_files()
    {
        $this->assertPdfSame(
            file_get_contents(__DIR__.'/pdfs/watermarked_page.pdf'),
            file_get_contents(__DIR__.'/pdfs/watermarked_page.pdf')
        );
    }

    /** @test */
    public function it_will_fail_different_files()
    {
        $this->expectException(ExpectationFailedException::class);

        $this->assertPdfSame(
            file_get_contents(__DIR__.'/pdfs/page.pdf'),
            file_get_contents(__DIR__.'/pdfs/watermarked_page.pdf')
        );
    }

    /** @test */
    public function it_will_produce_a_diff_image_with_different_files()
    {
        $diffFile = __DIR__.'/diffs/diff.png';
        @unlink($diffFile);

        $this->assertFileNotExists($diffFile);

        try {
            $this->assertPdfSame(
                file_get_contents(__DIR__.'/pdfs/page.pdf'),
                file_get_contents(__DIR__.'/pdfs/watermarked_page.pdf'),
                $diffFile
            );
            $this->fail("The PDF files are the same.");
        } catch (ExpectationFailedException $e) {
            $this->assertFileExists($diffFile);
        }
    }
}