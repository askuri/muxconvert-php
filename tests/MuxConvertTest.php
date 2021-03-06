<?php 
use PHPUnit\Framework\TestCase;

class MuxConvertTest extends TestCase {
  
    /**
     * Test if mux files are properly converted to .ogg files
     */
    public function testDecodeSimple() {
        $src = file_get_contents('test_samples/whoosh-3.mux');
        
        $MuxConverter = new askuri\MuxConvert\MuxConvert($src);
        $decoded = $MuxConverter->mux2ogg();
        
        // file_put_contents('converted.ogg', $decoded);
        $this->assertEquals(md5($decoded), '4af235e0f627d967a8110d4162294384');
    }
    
    /**
     * Test that decoding doesn't impact the input string in any way.
     * 
     * Background: in earlier versions, decryption was done with data being
     * passed as pass by reference.
     */
    public function testDecodeNoSrcManipulation() {
        $src = file_get_contents('test_samples/whoosh-3.mux');
        $md5Original = md5($src);
        
        $MuxConverter = new askuri\MuxConvert\MuxConvert($src);
        $MuxConverter->mux2ogg();
        
        $this->assertEquals($md5Original, md5($src));
    }
    
    /**
     * Test encode with a predefined salt. Should always give exactly the same
     * result.
     */
    public function testEncodeFixedSalt() {
        $src = file_get_contents('test_samples/whoosh-3.ogg');
        
        $MuxConverter = new askuri\MuxConvert\MuxConvert($src);
        $encoded = $MuxConverter->ogg2mux("\x3e\xe7\xb9\xd8");
        
        //file_put_contents('converted.mux', $encoded);
        $this->assertEquals(md5($encoded), '59c6b583ac82545dc66a45606be6bcdd');
        
    }
    
    /**
     * Test encode with a salt that is to be generated by the function.
     * 
     * Because the salt is random, we cannot expect the same file to come out.
     * Thus, instead of checking if the result matches a hash, we need to
     * decode it again.
     */
    public function testEncodeRandomSalt() {
        $src = file_get_contents('test_samples/whoosh-3.ogg');
        
        $MuxConverterEncode = new askuri\MuxConvert\MuxConvert($src);
        $encoded = $MuxConverterEncode->ogg2mux();
        
        $MuxConverterDecode = new askuri\MuxConvert\MuxConvert($encoded);
        $decoded = $MuxConverterDecode->mux2ogg();
        
        $this->assertEquals(md5($src), md5($decoded));
    }
    
    /**
     * Test that encoding doesn't impact the input string in any way.
     * 
     * Background: in earlier versions, decryption was done with data being
     * passed as pass by reference.
     */
    public function testEncodeNoSrcManipulation() {
        $src = file_get_contents('test_samples/whoosh-3.ogg');
        $md5Original = md5($src);
        
        $MuxConverter = new askuri\MuxConvert\MuxConvert($src);
        $MuxConverter->ogg2mux();
        
        $this->assertEquals($md5Original, md5($src));
    }
}
