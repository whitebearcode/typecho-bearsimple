<?php
namespace Obs\Internal\Common;

use Psr\Http\Message\StreamInterface;
use GuzzleHttp\Psr7\StreamDecoratorTrait;
use Obs\ObsException;

class CheckoutStream implements StreamInterface {
    use StreamDecoratorTrait;
    
    private $expectedLength;
    private $readedCount = 0;

    public function __construct(StreamInterface $stream, $expectedLength) {
        $this->stream = $stream;
        $this->expectedLength = $expectedLength;
    }

    public function getContents() {
        $contents = $this->stream->getContents();
        $length = strlen($contents);
        if ($this->expectedLength !== null && floatval($length) !== $this->expectedLength) {
            $this -> throwObsException($this->expectedLength, $length);
        }
        return $contents;
    }

    public function read($length) {
        $string = $this->stream->read($length);
        if ($this->expectedLength !== null) {
            $this->readedCount += strlen($string);
            if ($this->stream->eof()) {
                if (floatval($this->readedCount) !== $this->expectedLength) {
                    $this -> throwObsException($this->expectedLength, $this->readedCount);
                }
            }
        }    
        return $string;
    }

    public function throwObsException($expectedLength, $reaLength) {
        $obsException = new ObsException('premature end of Content-Length delimiter message body (expected:' . $expectedLength . '; received:' . $reaLength . ')');
        $obsException->setExceptionType('server');
        throw $obsException;
    }
}

