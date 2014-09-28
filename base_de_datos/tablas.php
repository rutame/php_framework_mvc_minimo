<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


CREATE DATABASE aprendomvcdb2 CHARACTER SET utf8 collate utf8_general_ci;

// Proporcionar privilegios al usuario
GRANT ALL ON aprendomvcdb2.* TO $username .@.$host IDENTIFIED BY $password;

// tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios( 
        nombre varchar(255), 
        usuario varchar(255), 
        pass varchar(255), 
        email varchar(255), 
        role varchar(255), 
        estado tinyint(1), 
        codigo varchar(255), 
        id int(11) not null auto_increment, 
        PRIMARY KEY (id) )
        ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE utf8_general_ci;

