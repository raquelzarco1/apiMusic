<?php 

class Model_Privacidad extends Orm\Model
{
    protected static $_table_name = 'privacidad';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'perfil' => array(
            'data_type' => 'varchar'   
        ),
        'amigos' => array(
            'data_type' => 'varchar'   
        ),
        'lists' => array(
            'data_type' => 'varchar'   
        ),
        'notificaciones' => array(
            'data_type' => 'varchar'   
        ),
        'localizacion' => array(
            'data_type' => 'varchar'   
        ),
        'url' => array(
            'data_type' => 'varchar'   
        )
    );
}