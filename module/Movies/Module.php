<?php

namespace Movies;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;
 use Movies\Model\Movies;
 use Movies\Model\MoviesTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 
 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
     //Retorna um array compatível com o AutoloaderFactory
     public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }

     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Movies\Model\MoviesTable' =>  function($sm) {
                     $tableGateway = $sm->get('MoviesTableGateway');
                     $table = new MoviesTable($tableGateway);
                     return $table;
                 },
                 'MoviesTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new movies());
                     return new TableGateway('movies', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
 }