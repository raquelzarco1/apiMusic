<?php 

class Model_Users extends Orm\Model
{
    protected static $_table_name = 'users';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK
        'username' => array(
            'data_type' => 'varchar'   
        ),
        'password' => array(
            'data_type' => 'varchar'   
        ),
        'email' => array(
            'data_type' => 'varchar'   
        ),
        'id_device' => array(
            'data_type' => 'varchar'   
        ),
        'foto_perfil' => array(
            'data_type' => 'varchar'   
        ),
        'descripcion' => array(
            'data_type' => 'varchar'   
        ),
        'cumple' => array(
            'data_type' => 'varchar'   
        ),
        'coordenada_x' => array(
            'data_type' => 'decimal'   
        ),
        'coordenada_y' => array(
            'data_type' => 'decimal'   
        ),
        'ciudad' => array(
            'data_type' => 'varchar'   
        ),
        'id_rol' => array(
            'data_type' => 'int'   
        )       
    );

    protected static $_belongs_to = array(
    'rol' => array(
        'key_from' => 'id_rol',
        'model_to' => 'Model_Rol',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    )
    );

    protected static $_has_many = array(
    'noticiasN' => array(
        'key_from' => 'id',
        'model_to' => 'Model_Noticias',
        'key_to' => 'id_users',
        'cascade_save' => true,
        'cascade_delete' => false,
        ),
    'listasN' => array(
        'key_from' => 'id',
        'model_to' => 'Model_Lists',
        'key_to' => 'id_users',
        'cascade_save' => true,
        'cascade_delete' => false,
    )
    );

    protected static $_many_many = array(
    'UsuarioSeguidor' => array(
        'key_from' => 'id',
        'key_through_from' => 'id_seguido', // column 1 from the table in between, should match a posts.id
        'table_through' => 'siguen', // both models plural without prefix in alphabetical order
        'key_through_to' => 'id_seguidor', // column 2 from the table in between, should match a users.id
        'model_to' => 'Model_Users',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
        ),
    'UsuarioSeguido' => array(
        'key_from' => 'id',
        'key_through_from' => 'id_seguidor', // column 1 from the table in between, should match a posts.id
        'table_through' => 'siguen', // both models plural without prefix in alphabetical order
        'key_through_to' => 'id_seguido', // column 2 from the table in between, should match a users.id
        'model_to' => 'Model_Users',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    )
    );
}