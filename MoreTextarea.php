<?php
namespace MoreTextarea;

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;
use Thelia\Module\BaseModule;

class MoreTextarea extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'moretextarea';

    public function postActivation(ConnectionInterface $con = null){
        $database = new Database($con->getWrappedConnection());
        $database->insertSql(null, array(__DIR__ . '/Config/thelia.sql'));
    }
}