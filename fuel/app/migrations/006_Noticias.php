<?php 

namespace Fuel\Migrations;

class Noticias
{

    function up()
    {
        \DBUtil::create_table('noticias', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
            'title' => array('type' => 'varchar', 'constraint' => 100),
            'id_users' => array('type' => 'int', 'constraint' => 11),
        ), array('id'), false, 'InnoDB', 'utf8_unicode_ci',
		    array(
		        array(
		            'constraint' => 'claveAjenaNoticiasAUsers',
		            'key' => 'id_users',
		            'reference' => array(
		                'table' => 'users',
		                'column' => 'id',
		            ),
		            'on_update' => 'CASCADE',
		            'on_delete' => 'RESTRICT'
		        )
		    )
    	);
    }

    function down()
    {
       \DBUtil::drop_table('noticias');
    }
}
