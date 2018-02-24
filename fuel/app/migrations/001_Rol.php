<?php 

namespace Fuel\Migrations;

class Rol
{
    function up()
    {
        \DBUtil::create_table('rol', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'tipe' => array('type' => 'varchar', 'constraint' => 100),
        ), 
        array('id'), false, 'InnoDB', 'utf8_unicode_ci');
    }

    function down()
    {
       \DBUtil::drop_table('rol');
    }
}
