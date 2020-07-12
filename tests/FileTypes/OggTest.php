<?php

use PHPUnit\Framework\TestCase;

class OggTest extends TestCase {
    protected $goodFile;
    protected $emptyFile;
    
    public function setUp(): void {
        $this->goodFile = new \askuri\MuxConvert\FileTypes\Ogg("OggSasdkfjaslkd");
        $this->emptyFile = new \askuri\MuxConvert\FileTypes\Ogg();
    }
    
    public function testConstructWithContent() {
        $content = "OggS\x01\something";
        $file = new \askuri\MuxConvert\FileTypes\Ogg($content);
        $this->assertSame($content, $file->getContent());
    }
}