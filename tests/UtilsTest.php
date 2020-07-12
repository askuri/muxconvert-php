<?php 
use PHPUnit\Framework\TestCase;
use askuri\MuxConvert\Utils;

class UtilsTest extends TestCase {
    public function testGenerateKeyGood() {
        $this->assertEquals("9dd70dc7f3fe59f778eea8d1ce72cd5f", bin2hex(Utils::generateKey("\x12\xf4\x3a\x77")));
    }
    
    public function testGenerateKeyTooShort() {
        $this->expectException(\InvalidArgumentException::class);
        Utils::generateKey("\x12\xf4\x3a");
    }
    
    public function testRolZeroSteps() {
        $this->assertEquals(0b01101110, Utils::rol(0b01101110, 0));
    }
    
    public function testRol2Steps() {
        $this->assertEquals(0b10111001, Utils::rol(0b01101110, 2));
    }
    
    public function testRol8Steps() {
        // should be the same result as 2 steps test
        $this->assertEquals(0b01101110, Utils::rol(0b01101110, 8));
    }
    
    public function testGetKeyStreamByteZero() {
        $this->assertEquals("\x9d", Utils::getKeyStreamByte(hex2bin("9dd70dc7f3fe59f778eea8d1ce72cd5f"), 0));
    }
    
    public function testGetKeyStreamByteNonZero() {
        $this->assertEquals("\xee", Utils::getKeyStreamByte(hex2bin("9dd70dc7f3fe59f778eea8d1ce72cd5f"), 4352345));
    }
    
    public function testKeyXORdata() {
        $this->assertEquals(
                hex2bin("f9b679a6979f3d91198acdd1a31dbf3af9ce6eee839cd68e99ae3c"),
                Utils::keyXORdata(hex2bin("9dd70dc7f3fe59f778eea8d1ce72cd5f"), "datadadfade\x00moredatadadaism")
        );
    }
    
    public function testByteifyOverflow() {
        $this->assertEquals(0b11000011, Utils::byteify(0b1111000011));
    }
    
    public function testByteifyUnderflow() {
        $this->assertEquals(0b1, Utils::byteify(0b1));
    }
}
