<?php 

namespace Fuel\Migrations;

class Contienen
{

    function up()
    {
        \DBUtil::create_table('contienen', array(
            'id_list' => array('type' => 'int', 'constraint' => 11),
            'id_song' => array('type' => 'int', 'constraint' => 11),

        ), 
        array('id_list','id_song'), false, 'InnoDB', 'utf8_unicode_ci',
            array(
                array(
                    'constraint' => 'claveAjenaListaContienen',
                    'key' => 'id_list',
                    'reference' => array(
                        'table' => 'lists',
                        'column' => 'id',
                    ),
                    'on_update' => 'CASCADE',
                    'on_delete' => 'RESTRICT'
                ),
                array(
                    'constraint' => 'claveAjenaSongaContienen',
                    'key' => 'id_song',
                    'reference' => array(
                        'table' => 'songs',
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
       \DBUtil::drop_table('contienen');
    }
}
