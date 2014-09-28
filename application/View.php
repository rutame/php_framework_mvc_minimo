<?php

/*
 * Copyright (C) 2014 almansor
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

class View {

    private $_controlador;
    private $_js;
    
    public function __construct(Request $peticion) {
        $this->_controlador = $peticion->getControlador();
        $this->_js = array();
    }
    
    public function renderizar($vista, $item = FALSE)
    {
        $menu = array(
            array(
                'id' => 'inicio',
                'titulo' => 'Ir a Inicio',
                'enlace' => BASE_URL),
            array(
                'id' => 'post',
                'titulo' => 'Ver los Posts',
                'enlace' => BASE_URL . 'post')  
            );
        
        if(Session::get('autentificado')){
            
            array_push( $menu, array(
                                    'id' => 'login',
                                    'titulo' => 'Cerrar Sesión',
                                    'enlace' => BASE_URL . 'login/cerrar'
                                    )
                      );
        }
        else{
            array_push( $menu, array(
                                    'id' => 'login',
                                    'titulo' => 'Iniciar Sesión',
                                    'enlace' => BASE_URL . 'login'
                                    ),
                                array(
                                    'id' => 'registro',
                                    'titulo' => 'Registro de Usuarios',
                                    'enlace' => BASE_URL . 'registro'
                                    )
                        );
        }
        
        $js = array();
        
        if(count($this->_js)): $js = $this->_js;  endif;
        
        $_layoutParams = array(
            'ruta_css' => BASE_URL . 'views/layouts/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layouts/' . DEFAULT_LAYOUT . '/img/',
            'ruta_js' => BASE_URL . 'views/layouts/' . DEFAULT_LAYOUT . '/js/',
            'menu' => $menu,
            'js' => $js
        );
        
        $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.phtml';
        
        if(is_readable($rutaView)){
            include_once ROOT . 'views' . DS . 'layouts' . DS . DEFAULT_LAYOUT . DS . 'header.php';
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layouts' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
        }
        else{
            throw new Exception('Error de vista');
        }
    }
    
    // Método para cargar los js de cada vista
    public function setJs(array $js)
    {
        if(is_array($js) && count($js)){
            for($i=0; $i < count($js); $i++){
                $this->_js[] = BASE_URL . 'views/' . $this->_controlador . '/js/' . $js[$i] . '.js';
            }
        }
        else{
            throw new Exception('Error de js');
        }
    }
}
