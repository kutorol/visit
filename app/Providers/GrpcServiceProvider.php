<?php

declare(strict_types=1);

namespace App\Providers;

use App\GrpcClient\CategoryFixedItemServiceClientGrpcHelper;
use Grpc\ChannelCredentials;
use HardGo\App\Some\V1\ReverseClient;
use Illuminate\Log\Logger;
use Illuminate\Support\ServiceProvider;

class GrpcServiceProvider extends ServiceProvider
{
    private Logger $logger;

    /**
     * Bootstrap services.
     * @param Logger $logger
     * @return void
     */
    public function boot(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $categoryServiceHost = (string)config('app_services.category_service_grpc_host', '');
        $categoryServiceHost = "host.docker.internal:12032";
        $categoryServiceCredentials = $this->createCredentials($categoryServiceHost);


        $this->app->bind(
            CategoryFixedItemServiceClientGrpcHelper::class,
            fn () => new CategoryFixedItemServiceClientGrpcHelper(
                new ReverseClient(
                    $categoryServiceHost,
                    ['credentials' => $categoryServiceCredentials]
                ),
            )
        );


    }

    private function createCredentials(string $host): ?ChannelCredentials
    {
        if (strpos($host, ':443')) {
            return ChannelCredentials::createSsl('/etc/ssl/certs/ca-certificates.crt');
        }

        return ChannelCredentials::createInsecure();
    }
}
