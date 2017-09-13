<?php

namespace Album;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements ConfigProviderInterface{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig(){

        return[
            'factories' =>[
                Model\AlbumTable::class => function($container){
                $tableGateway = $container->get(Model\AlbumTable::class);
                return new Model\AlbumTable($tableGateway);
                },
                Model\AlbumTable::class => function($container){
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype -> setArrayObjectPrototype(new Model\Album());
                    return new TableGateway('album', $dbAdapter,null,$resultSetPrototype);
                },
            ],
        ];
    }
}