<?php 

class Model_Rol extends Orm\Model
{
    protected static $_table_name = 'rol';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'tipe' => array(
            'data_type' => 'varchar'   
        )
    );

    protected static $_has_many = array(
    'users' => array(
        'key_from' => 'id',
        'model_to' => 'Model_Users',
        'key_to' => 'id_rol',
        'cascade_save' => true,
        'cascade_delete' => false,
    )
	);
	
}