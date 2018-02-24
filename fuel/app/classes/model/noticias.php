<?php 

class Model_Noticias extends Orm\Model
{
    protected static $_table_name = 'noticias';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'title' => array(
            'data_type' => 'varchar'   
        ),
        'id_users' => array(
            'data_type' => 'int'   
        )
    );

    protected static $_belongs_to = array(
    'usersN' => array(
        'key_from' => 'id_users',
        'model_to' => 'Model_Users',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    )
    );
}