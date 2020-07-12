<?php

use PHPUnit\Framework\TestCase;

class FileTest extends TestCase {
    public function testFactoryMux() {
        $mux = \askuri\MuxConvert\FileTypes\File::factory("NadeoFile\x01abcdtest");
        $this->assertInstanceOf(\askuri\MuxConvert\FileTypes\Mux::class, $mux);
    }
    
    public function testFactoryOgg() {
        $ogg = \askuri\MuxConvert\FileTypes\File::factory("OggSNadeofile");
        $this->assertInstanceOf(\askuri\MuxConvert\FileTypes\Ogg::class, $ogg);
    }
    
    public function testFactoryException() {
        $this->expectException(\InvalidArgumentException::class);
        \askuri\MuxConvert\FileTypes\File::factory("somethingrandom");
    }
}