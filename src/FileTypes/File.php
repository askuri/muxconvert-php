<?php

namespace askuri\MuxConvert\FileTypes;

/**
 * Determines file type and creates an instance of either Mux or Ogg.
 * Also provides common function for these two classes.
 * 
 * @author Martin Weber
 */
abstract class File {
    /**
     * @var string magic number of the file; length dependent on the type
     */
    protected $magic;
    
    /**
     * Get an instance of either Ogg or Mux file type. 
     * Automatically determines the type based on the Magic Number.
     * 
     * @param string $fileContent
     * @return object File
     */
    public static function factory(string $fileContent): object {
        if ("NadeoFile" === substr($fileContent, 0, 9)) {
            return new Mux($fileContent);
        } else if ("OggS" === substr($fileContent, 0, 4)) {
            return new Ogg($fileContent);
        } else {
            throw new \InvalidArgumentException("The file can neither be identified as .mux or .ogg.");
        }
    }
    
    /**
     * Get the full content of the file including magic number
     * 
     * @return string
     */
    abstract function getContent(): string;
    
    /**
     * Return whether this file can be understood by this library
     * 
     * @return bool
     */
    abstract function isSupported(): bool;
}
