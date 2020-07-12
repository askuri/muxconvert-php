<?php

namespace askuri\MuxConvert\FileTypes;

/**
 * Description of Ogg
 *
 * @author martin
 */
class Ogg extends File {
    /**
     * @var string entire content of the ogg file
     */
    protected $data;
    
    /**
     * @param string $fileContent content of an ogg file
     */
    public function __construct($fileContent = null) {
        if ($fileContent != null) {
            $this->magic = substr($fileContent, 0, 4);
            $this->data = substr($fileContent, 4);
        } else {
            $this->magic = "OggS";
        }
    }
    
    public function isSupported(): bool {
        // we don't need to read the content of Ogg files, so we can consider
        // any ogg to be compatible.
        return true;
    }

    public function getContent(): string {
        return $this->magic . $this->data;
    }

}
