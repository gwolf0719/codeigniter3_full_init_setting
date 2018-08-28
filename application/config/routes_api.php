<?php
    $config['routes_api'] = array();

    $config['routes_table'] = array(
        "user"=> array(
            "table"=> 'user_main',
            "method"=> array('exist', 'insert', 'update', 'delete', 'get_list', 'get_once'),
            "detals"=> array(
                "exist"=> array(
                    'verify'=> array(
                        'user_uid'=> 'user_uid'
                    ),
                    'query'=> array(),
                    'likes'=> array(),
                    'record'=> array(),
                    'default'=> array(),
                    'method'=> 'get',
                    'require'=> array('user_uid')
                ),

                "insert"=> array(
                    'verify'=> array(),
                    'query'=> array(
                        'user_uid'=> 'user_uid', 
                        'user_displayName'=> 'user_displayName', 
                        'user_email'=> 'user_email', 
                        'user_photoURL'=> 'user_photoURL'
                    ),
                    'likes'=> array(),
                    'record'=> array(),
                    'default'=> array(
                        'updateAt'=> 'code_date',
                        'updateAtTime'=> 'code_time',
                        'tsUpdateAt'=> 'code_timestamp',
                        'lastLogin'=> '',
                        'lastLoginTime'=> '',
                        'tsLastLogin'=> '0'
                    ),
                    'method'=> 'post',
                    'require'=> array(
                        'user_uid',
                        'user_displayName',
                        'user_email',
                        'user_photoURL'
                    )
                ),

                "update"=> array(
                    'verify'=> array(
                        'user_uid'=> 'user_uid'
                    ),
                    'query'=> array(
                        'user_displayName'=> 'user_displayName', 
                        'user_email'=> 'user_email', 
                        'user_photoURL'=> 'user_photoURL'
                    ),
                    'likes'=> array(),
                    'record'=> array(),
                    'default'=> array(),
                    'method'=> 'post',
                    'require'=> array(
                        'user_uid',
                        'user_displayName',
                        'user_email',
                        'user_photoURL'
                    )
                ),

                "delete"=> array(
                    'verify'=> array(
                        'user_uid'=> 'user_uid'
                    ),
                    'query'=> array(),
                    'likes'=> array(),
                    'record'=> array(),
                    'default'=> array(),
                    'method'=> 'post',
                    'require'=> array('user_uid')
                ),

                "get_list"=> array(
                    'verify'=> array(),
                    'query'=> array(),
                    'likes'=> array(),
                    'record'=> array(
                        'limit'=> 'limit',
                        'page'=> 'page'
                    ),
                    'default'=> array(),
                    'method'=> 'get',
                    'require'=> array()
                ),

                "get_once"=> array(
                    'verify'=> array(
                        'user_uid'=> 'user_uid'
                    ),
                    'query'=> array(),
                    'likes'=> array(),
                    'record'=> array(),
                    'default'=> array(),
                    'method'=> 'get',
                    'require'=> array('user_uid')
                )
            )
        )
    );
?>