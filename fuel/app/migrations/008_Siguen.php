<?php 

namespace Fuel\Migrations;

class Siguen
{

    function up()
    {
        \DBUtil::create_table('siguen', array(
            'id_seguidor' => array('type' => 'int', 'constraint' => 11),
            'id_seguido' => array('type' => 'int', 'constraint' => 11),

        ), 
        array('id_seguidor','id_seguido'), false, 'InnoDB', 'utf8_unicode_ci',
            array(
                array(
                    'constraint' => 'claveAjenSeguidoraSiguen',
                    'key' => 'id_seguidor',
                    'reference' => array(
                        'table' => 'users',
                        'column' => 'id',
                    ),
                    'on_update' => 'CASCADE',
                    'on_delete' => 'RESTRICT'
                ),
                array(
                    'constraint' => 'claveAjenSeguidoaSiguen',
                    'key' => 'id_seguido',
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
       \DBUtil::drop_table('siguen');
    }
}