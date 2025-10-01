<?php

declare(strict_types=1);

namespace OCA\Sample\AppInfo;

use OCP\Server;
use OCP\INavigationManager;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

class Application extends App implements IBootstrap
{
    public const APP_ID = 'sample';

    public function __construct(array $urlParams = [])
    {
        parent::__construct(self::APP_ID, $urlParams);
    }

    public function register(IRegistrationContext $context): void
    {
        return;
    }

    public function boot(IBootContext $context): void
    {
        $server = $context->getServerContainer();

        Server::get(INavigationManager::class)->add(function () use ($server) {
            return [
    		    'id' => 'sample_index',
    		    'order' => 10,
    		    'href' => $server->getURLGenerator()->linkToRoute('sample.page.index'),
    		    'icon' => $server->getURLGenerator()->imagePath('sample', 'sample.svg'),
    		    'name' => 'Sample',
            ];
        });
    }
}
