<?php

declare(strict_types=1);

namespace App\GrpcClient;

use Exception;
use Monolog\Logger;

//use Illuminate\Log\Logger;

class GrpcClientUtils
{
//    private Logger $logger;

//    public function __construct(Logger $logger)
//    {
//    }

    /**
     * @throws Exception
     */
    public function parseResult($result)
    {
        if (!empty($result[0])) {
            return $result[0];
        }
        $details = $result[1]->details ?? '';
        $code = $result[1]->code ?? 0;

        if ($details || $code) {
//            Logger::error('request finished with error', ['details' => $details, 'code' => $code]);
//            $this->logger->error('request finished with error', ['details' => $details, 'code' => $code]);
            throw new Exception($details, $code);
        }

        return $result[0];
    }
}
