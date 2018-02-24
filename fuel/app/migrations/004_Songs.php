<?php 

namespace Fuel\Migrations;

class Songs
{
    function up()
    {
        \DBUtil::create_table('songs', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'title' => array('type' => 'varchar', 'constraint' => 100),
            'artist' => array('type' => 'varchar', 'constraint' => 100),
            'reproducciones' => array('type' => 'int', 'constraint' => 100),
            'url' => array('type' => 'varchar', 'constraint' => 100),
        ), array('id'), false, 'InnoDB', 'utf8_unicode_ci');
    }

    function down()
    {
       \DBUtil::drop_table('songs');
    }
}
