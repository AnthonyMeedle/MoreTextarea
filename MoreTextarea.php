<?php
namespace MoreTextarea;

use Propel\Runtime\Connection\ConnectionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Thelia\Install\Database;
use Thelia\Module\BaseModule;

class MoreTextarea extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'moretextarea';

    public function postActivation(ConnectionInterface $con = null): void{
        $database = new Database($con->getWrappedConnection());
        $database->insertSql(null, array(__DIR__ . '/Config/TheliaMain.sql'));
    }
	
    public static function configureServices(ServicesConfigurator $servicesConfigurator): void
    {
        $servicesConfigurator->load(self::getModuleCode().'\\', __DIR__)
            ->exclude([THELIA_MODULE_DIR.ucfirst(self::getModuleCode()).'/I18n/*'])
            ->autowire(true)
            ->autoconfigure(true);
    }
}