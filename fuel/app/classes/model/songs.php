<?php 

class Model_Songs extends Orm\Model
{
    protected static $_table_name = 'songs';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'title' => array(
            'data_type' => 'varchar'   
        ),
        'artist' => array(
            'data_type' => 'varchar'   
        ),
        'reproducciones' => array(
            'data_type' => 'int'   
        ),
        'url' => array(
            'data_type' => 'varchar'   
        )
    );

    protected static $_many_many = array(
    'contienenListas' => array(
        'key_from' => 'id',
        'key_through_from' => 'id_list', // column 1 from the table in between, should match a posts.id
        'table_through' => 'contienen', // both models plural without prefix in alphabetical order
        'key_through_to' => 'id_song', // column 2 from the table in between, should match a users.id
        'model_to' => 'Model_Lists',
        'key_to' => 'id',
        'cascade_save' => false,
        'cascade_delete' => false,
    )
    );
}