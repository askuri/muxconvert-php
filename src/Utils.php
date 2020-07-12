<?php

namespace askuri\MuxConvert;

use InvalidArgumentException;

/**
 * Description of Utils
 *
 * @author martin
 */
final class Utils {
    
    /**
     * Generate the key, which is used as a base for the key stream,
     * based on a salt
     * 
     * @param string $keySalt 4 byte long
     * @return string key which is 16 byte long
     */
    public static function generateKey(string $keySalt): string {
        if (4 !== strlen($keySalt)) {
            throw new InvalidArgumentException("The key must be 4 bytes long");
        }
        return md5($keySalt . "Hello,hack3r!", true);
    }
    
    /**
     * Left rotate the bits of a 1 byte integer
     * 
     * @param int $input integer to rotate
     * @param int $amount how many steps to rotate, must be in [0, 8]
     * @return int the rotated integer
     */
    public static function rol(int $input, int $amount): int {
        return self::byteify(($input << $amount) | ($input >> (8 - $amount)));
    }
    
    /**
     * Get the byte of the key in the key stream ("very long key").
     * 
     * @param int $pos Byte position in the data
     * @return string Corresponding byte from key stream
     */
    public static function getKeyStreamByte(string $key, int $pos): string {
        // chr(...): convert integer back to char/byte
        // alternatively, one could use pack('C', ...) but it' slower
        // rol(...): why is this necessary? legacy code by arc_
        return chr(self::rol(
                        // wrap around on the key, which is only 16 bytes long -> do modulo
                        // Get the corresponding byte from the key and transform it into an integer.
                        ord($key[$pos % 16]),
                        // this would also work, but it's slower:
                        //      unpack('C', $key[$pos % 16])[1],
                        // why is this necessary? legacy code by arc_
                        ($pos / 17) % 8
        ));
    }
    
    /**
     * De- or encrypt the payload -> do XOR with the key.
     * 
     * @param string $key 16 byte key as returned by md5()
     * @param string $data Input data, overwritten with output
     * @return string
     */
    public static function keyXORdata(string $key, string $data): string {
        $return = "";
        
        $length = strlen($data);
        for ($i = 0; $i < $length; $i++) {
            // XOR every byte of the input with the corresponding byte of the key
            $return[$i] = $data[$i] ^ self::getKeyStreamByte($key, $i);
        }
        
        return $return;
    }

    /**
     * Make any integer fit into 1 byte by chopping off the bits above bit 7.
     * This is a workaround because we don't have a "byte" type in PHP where
     * every bit exceeding 7 bit would be dropped automatically during left shift.
     * 
     * @param int $nobyte Int that we want to be cut down to 8 bit
     * @return int
     */
    public static function byteify(int $nobyte) {
        return 0x000000FF & $nobyte;
    }
}
