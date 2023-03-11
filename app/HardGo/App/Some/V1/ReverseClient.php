<?php
// GENERATED CODE -- DO NOT EDIT!

namespace HardGo\App\Some\V1;

/**
 */
class ReverseClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \HardGo\App\Some\V1\Request $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Do(\HardGo\App\Some\V1\Request $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/some.v1.Reverse/Do',
        $argument,
        ['\HardGo\App\Some\V1\Response', 'decode'],
        $metadata, $options);
    }

}
