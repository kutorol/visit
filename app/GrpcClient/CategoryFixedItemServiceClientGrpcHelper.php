<?php

declare(strict_types=1);

namespace App\GrpcClient;

use HardGo\App\Some\V1\Request;
use HardGo\App\Some\V1\Response;
use HardGo\App\Some\V1\ReverseClient;

class CategoryFixedItemServiceClientGrpcHelper extends GrpcClientUtils
{

    private ReverseClient $fixedItemClient;

    public function __construct(ReverseClient $client)
    {
        $this->fixedItemClient = $client;
    }

    /**
     * Находит закрепленные товары у переданных id категорий.
     * @throws \Exception
     */
    public function do(): void
    {

        $req = (new Request())->setMessage("myMess");

        try {
            /** @var Response $r */
            $r = $this->parseResult(
                $this->fixedItemClient->Do($req)->wait()
            );
        }catch (\Throwable $e) {
            echo "<pre>";
            print_r([
                'fs',
                $e->getMessage()
            ]);
            echo "</pre>";
            exit;
        }


        echo "<pre>";
        print_r([
            '$r->getMessage()',
            $r->getMessage()
        ]);
        echo "</pre>";
        exit;
    }
}
