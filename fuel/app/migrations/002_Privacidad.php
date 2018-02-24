<?php 

namespace Fuel\Migrations;

class Privacidad
{
    function up()
    {
        \DBUtil::create_table('privacidad', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'perfil' => array('type' => 'varchar', 'constraint' => 100),
            'amigos' => array('type' => 'varchar', 'constraint' => 100),
            'lists' => array('type' => 'varchar', 'constraint' => 100),
            'notificaciones' => array('type' => 'varchar', 'constraint' => 100),
            'localizacion' => array('type' => 'varchar', 'constraint' => 100),
            'url' => array('type' => 'varchar', 'constraint' => 100),
        ), array('id'), false, 'InnoDB', 'utf8_unicode_ci');
    }

    function down()
    {
       \DBUtil::drop_table('privacidad');
    }
}
