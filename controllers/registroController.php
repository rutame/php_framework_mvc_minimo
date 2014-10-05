<?php

/*
 * Copyright (C) 2014 Pedro Gabriel Manrique Gutiérrez <pedrogmanrique at gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class registroController extends Controller
{
    private $_registro;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_registro = $this->loadModel('registro');
    }
    
    public function index()
    {
        if(Session::get('autentificado')){
            $this->redireccionar();
        }
        
        $this->_view->titulo = "Registro de Usuarios";
        
        if($this->getInt('enviar') == 1){
            $this->_view->datos = $_POST;
            
            if(!$this->getSql('nombre')){
                $this->_view->_error = "Debe introducir el nombre";
                $this->_view->renderizar('index', 'registro'); 
                exit();
            }
            
            if(!$this->getAlphaNum('usuario')){
                $this->_view->_error = "Debe introducir el nombre de usuario";
                $this->_view->renderizar('index', 'registro'); 
                exit;  
            }
            /**
             * 
             */
            if($this->_registro->verificarUsuario($this->getAlphaNum('usuario'))){
                $this->_view->_error = "¡Ya existe el usuario " . $this->getAlphaNum('usuario') ."!";
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            
            if($this->_registro->verificarEmail('email')){
                $this->_view->_error = "Esa dirección de email ya existe";
                $this->_view->renderizar('index', 'registro');
                exit();
            }
            
            if(!$this->validarEmail($this->getPostParam('email'))){
                $this->_view->_error = "¡Dirección de email incorrecta!";
                $this->_view->renderizar('index', 'registro');
                exit();
            }
            
            if(!$this->getAlphaNum('pass')){
                $this->_view->_error = "Debe introducir la contraseña";
                $this->_view->renderizar('index', 'registro');  
                exit();
            }
            
            if($this->getPostParam('pass') != $this->getPostParam('confirmar') ){
                $this->_view->_error = "Las contraseñas no coinciden";
                $this->_view->renderizar('index', 'registro'); 
                exit();
            }
            
            $this->getLibrary('class.phpmailer');
                $mail = new PHPMailer();
                    
            $this->_registro->registrarUsuario(
                    $this->getSql('nombre'), 
                    $this->getAlphaNum('usuario'),
                    $this->getPostParam('pass'),
                    $this->getSql('email')
                    );
            $usuario = $this->_registro->verificarUsuario($this->getAlphaNum('usuario'));
            $correo = $this->getSql('email');
            if(!$usuario){
                $this->_view->_error = "Error al registrar el usuario";
                $this->_view->renderizar('index', 'registro');
                exit();
            }
            $mail->isSMTP();
            $mail->SMTPDebug = 2;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            // Usuario y contraseña;
            $mail->Username = "pedrogmanrique@gmail.com";
            $mail->Password = "*****";
            $mail->addAddress($correo);
            $mail->From = "pedrog.grafycomp.com";
            $mail->FromName = "Aprendiendo PHP POO MVC";
            $mail->Subject = "Activacion de cuenta de usuario";
            $mail->Body = 'Hola <strong>' . $this->getSql('nombre') . '</strong>'.
                    '<p>Se ha registrado en ' . BASE_URL . 
                    'para activar tu cuenta haz click sobre el siguiente '.
                    'enlace <a href=" ' . BASE_URL . 
                    'registro/activar/' .$usuario['id'] .'/'. $usuario['codigo'].
                    '"> activar </a>';
            
            $mail->AltBody = "Su servidor no soporta HTML";
            $mail->addAddress($this->getPostParam('email'));
            $mail->send();
            
            $this->_view->datos = false;        
            $this->_view->_mensaje = "Registro completado, revise su email para activar su cuenta";
            
        }
        $this->_view->renderizar('index', 'registro');
    }
    
    /**
     * 
     * @param type $id
     * @param type $codigo
     */
    public function activar($activacion)
    {
        $this->_view->titulo = "Activación";
        if(is_array($activacion)){
            $id = $this->filtrarInt($activacion[0]);
            $codigo = $this->filtrarInt($activacion[1]);
            
            //echo "Id: ".  $this->filtrarInt($id) . " codigo: ".  $this->filtrarInt($codigo);exit();
     
        }
        else{
            echo "Faltan parámetros!";
            exit();
        }
        if($id || !$codigo){
            $this->_view->error = "Esta cuenta no existe";
            $this->_view->renderizar('activar', 'registro');
            exit();
        }
        
        $row = $this->_registro->getUsuario($id, $codigo);
        
        if(!$row){
            $this->_view->error = "Esta cuenta no existe";
            $this->_view->renderizar('activar', 'registro');
            exit();
        }
        
        if($row['estado'] == 1){
            $this->_view->error = "Esta cuenta ya ha sido activada";
            $this->_view->renderizar('activar', 'registro');
            exit();
        }
        
        $this->_registro->activarUsuario($id, $codigo);
        
        if($row['estado'] == 0){
            $this->_view->error = "Error al activar la cuenta, por favor intentelo más tarde.";
            $this->_view->renderizar('activar', 'registro');
            exit();
        }
        
        $this->_view->_mensaje = "Su cuenta ha sido activada";
        $this->_view->renderizar('activar', 'registro');
                
    }

}

