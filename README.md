# MuxConvert
This library can be used to convert .mux to .ogg files and the other way around.

.mux files are encrypted .ogg files used by some games made by French studio
Nadeo. More details about the .mux format can be found
[here](https://wiki.xaseco.org/wiki/MUX).

## Install

Via Composer

``` bash
$ composer require askuri/muxconvert
```

## Usage
Simple initialize the library with the contents of either file type and
call the corresponding conversion function.

``` php
$muxconvert = new \askuri\MuxConvert\MuxConvert($muxFileContents);
$ogg = $muxconvert->mux2ogg();

$muxconvert = new \askuri\MuxConvert\MuxConvert($oggFileContents);
$mux = $muxconvert->ogg2mux();
```

## Change log
No release yet.

## Testing

``` bash
$ vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.