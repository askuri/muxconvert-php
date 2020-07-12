<?php

use PHPUnit\Framework\TestCase;

class MuxTest extends TestCase {
    protected $goodFile;
    protected $emptyFile;
    
    public function setUp(): void {
        $this->goodFile = new \askuri\MuxConvert\FileTypes\Mux("NadeoFile\x01saltcontent");
        $this->emptyFile = new \askuri\MuxConvert\FileTypes\Mux();
    }
    
    public function testConstructWithoutContent() {
        $file = new \askuri\MuxConvert\FileTypes\Mux();
        $file->setVersion(1);
        $file->setKeySalt("some");
        $file->setData("thing");
        $this->assertSame("NadeoFile", substr($file->getContent(), 0, 9));
    }
    
    public function testConstructWithContent() {
        $content = "NadeoFile\x01\something";
        $file = new \askuri\MuxConvert\FileTypes\Mux($content);
        $this->assertSame($content, $file->getContent());
    }
    
    
    public function testGetVersionGood() {
        $this->assertSame(1, $this->goodFile->getVersion());
    }
    
    public function testGetVersionEmpty() {
        $this->expectException(\Exception::class);
        $this->emptyFile->getVersion();
    }
    
    public function testSetVersionGood() {
        $this->goodFile->setVersion(42);
        $this->assertSame(42, $this->goodFile->getVersion());
    }
    
    public function testSetVersionEmpty() {
        $this->emptyFile->setVersion(42);
        $this->assertSame(42, $this->emptyFile->getVersion());
    }
    
    
    public function testGetKeySaltGood() {
        $this->assertSame("salt", $this->goodFile->getKeySalt());
    }
    
    public function testGetKeySaltEmpty() {
        $this->expectException(\Exception::class);
        $this->emptyFile->getKeySalt();
    }
    
    public function testSetKeySaltGood() {
        $this->goodFile->setKeySalt("lkad");
        $this->assertSame("lkad", $this->goodFile->getKeySalt());
    }
    
    public function testSetKeySaltEmpty() {
        $this->emptyFile->setKeySalt("lkad");
        $this->assertSame("lkad", $this->emptyFile->getKeySalt());
    }
    
    
    public function testGetDataGood() {
        $this->assertSame("content", $this->goodFile->getData());
    }
    
    public function testGetDataEmpty() {
        $this->assertSame(null, $this->emptyFile->getData());
    }
    
    public function testSetDataGood() {
        $this->goodFile->setData("newcontent");
        $this->assertEquals("newcontent", $this->goodFile->getData());
    }
    
    public function testSetDataEmpty() {
        $this->emptyFile->setData("newcontent");
        $this->assertEquals("newcontent", $this->emptyFile->getData());
    }
}