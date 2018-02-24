<?php 

class Model_Lists extends Orm\Model
{
    protected static $_table_name = 'lists';
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

    protected static $_many_many = array(
    'contienenCanciones' => array(
        'key_from' => 'id',
        'key_through_from' => 'id_song', // column 1 from the table in between, should match a posts.id
        'table_through' => 'contienen', // both models plural without prefix in alphabetical order
        'key_through_to' => 'id_list', // column 2 from the table in between, should match a users.id
        'model_to' => 'Model_Songs',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    )
    );
}