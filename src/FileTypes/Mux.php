<?php

namespace askuri\MuxConvert\FileTypes;

/**
 * Description of Mux
 *
 * @author martin
 */
class Mux extends File {
    /**
     * @var string 1 byte version number
     */
    protected $version;
    
    /** 
     * @var string 4 byte key salt
     */
    protected $keySalt;
    
    /**
     * @var string payload / encoded ogg
     */
    protected $data;

    /**
     * @param string $fileContent content of a mux file
     */
    public function __construct(string $fileContent = null) {
        
        if ($fileContent != null) {
            $this->magic   = substr($fileContent, 0, 9);
            $this->version = substr($fileContent, 9, 1);
            $this->keySalt = substr($fileContent, 10, 4);
            $this->data    = substr($fileContent, 14);
        } else {
            $this->magic = "NadeoFile";
        }
    }
    
    
    public function isSupported(): bool {
        if (!isset($this->version)) {
            throw new Exception("The version field must be set before calling this method");
        }
        
        // we only support version 1
        return 1 === $this->getVersion();
    }
    
    public function getContent(): string {
        if (!isset($this->version) || !isset($this->keySalt) || !isset($this->data)) {
            throw new \Exception("All fields must be set before retrieving the content");
        }
        
        return    $this->magic
                . $this->version
                . $this->keySalt
                . $this->data
        ;
    }

    public function getVersion(): int {
        if (!isset($this->version)) {
            throw new \Exception("The version is not set!");
        }
        return ord($this->version);
    }
    
    public function setVersion(int $version): void {
        if ($version < 0 || $version > 255) {
            throw new InvalidArgumentException("Version must be a value between 0 and 255");
        }
        $this->version = chr($version);
    }
    
    public function getKeySalt(): string {
        if (!isset($this->keySalt)) {
            throw new \Exception("The key salt is not set!");
        }
        return $this->keySalt;
    }
    
    public function setKeySalt(string $keySalt): void {
        if (4 !== strlen($keySalt)) {
            throw new \InvalidArgumentException("Keysalt must be exactly 4 bytes long");
        }
        $this->keySalt = $keySalt;
    }
    
    /**
     * Get the payload of the mux, that means the encrypted ogg.
     * If data is not set, it will return null.
     * 
     * @return ?string encrypted ogg data
     */
    public function getData(): ?string {
        return $this->data;
    }
    
    /**
     * Set the data, that means the encrypted ogg data.
     * This does *not* encrypt the ogg to mux.
     * 
     * @param ?string $data encrypted ogg file, null to unset
     * @return void
     */
    public function setData(?string $data): void {
        $this->data = $data;
    }
}
