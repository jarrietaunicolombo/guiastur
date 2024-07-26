<?php
require_once __DIR__."/activerecord/ActiveRecord.php";
ActiveRecord\Config::initialize(function($cfg)
{
   $cfg->set_model_directory($_SERVER["DOCUMENT_ROOT"]."/guiastur/Domain/Entities");
   $cfg->set_connections(
     array(
       'development' => 'mysql://root:@localhost/Gestion_turnos_guias_bd'
    //    ,
    //    'test' => 'mysql://username:password@localhost/test_database_name',
    //    'production' => 'mysql://username:password@localhost/production_database_name'
     )
   );
});

