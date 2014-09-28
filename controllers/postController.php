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

class PostController extends Controller
{
    private $_post;
    private $_titulo;
    private $_cuerpo;
    //public $prueba;
    
    public function __construct()
    {
        parent::__construct();
        $this->_post = $this->loadModel('post');
    }
    public function index($pagina = FALSE)
    {
        //$this->getLibrary('paginador');
        //$paginador = new Paginador();
        //$post = $this->loadModel('post');
        
        //$this->_view->posts = $post->getPosts();
        $this->_view->posts = $this->_post->getPosts();
        //$this->_view->posts = $paginador->paginar($this->_post->getPosts(), $pagina);
        $this->_view->titulo = "Todos los Posts";
        $this->_view->renderizar('index','post');
    }
    public function nuevo()
    {
        Session::accesoEstricto(array('especial',false));
        
        $this->_view->titulo = "Nuevo Post";
        
        $this->_view->setJs(array('nuevo'));
        //$this->_view->valorGuardar = $this->getInt('guardar');
        //$this->_view->sacaTitulo = $this->getTexto('titulo');
        if($this->getInt('guardar') == 1)
        {
            $this->_view->datos = $_POST;
            
            if(!$this->getTexto('titulo')){
                $this->_view->_error = "Debe Introducir el título del post";
                $this->_view->renderizar('nuevo','post');
                exit;
            }
            
            if(!$this->getTexto('cuerpo')){
                $this->_view->_error = "Debe Introducir el cuerpo del post";
                $this->_view->renderizar('nuevo','post');
                exit;
            }

            $this->_post->insertarPost(
                        $this->getPostParam('titulo'),
                        $this->getPostParam('cuerpo')        
                    );
                    $this->redireccionar('post');
        }
        $this->_view->renderizar('nuevo','post');
    }
    
    public function ver($id)
    {   
        if(isset($id)):
        $this->_view->datos = $this->_post->getPost($this->sacaId($id));
        $this->_view->titulo = $this->_view->datos['titulo'];
        $this->_view->datos = $this->_post->getPost($this->sacaId($id));
        $this->_view->renderizar("ver","post");
        else:
        
        $this->_view->errorId = $id . "Error con el id";
        $this->_view->renderizar("ver","post");
        endif;
        
    }
    
    // Método editar
    public function editar($id)
    {
        Session::acceso('admin');
        if(!$this->sacaId($id)){
            $this->redireccionar('post');
        }
        // verificar que existe el registro
        if(!$this->_post->getPost($this->sacaId($id))){
            $this->redireccionar('post');
        } 
        // existe
        $this->_view->titulo = "Editar Post ".  $this->sacaId($id);
        $this->_view->setJs(array('nuevo'));
        
        if($this->getInt('guardar') == 1)
        {
            $this->actualizaPost($id,  $this->getPostParam('titulo'),  $this->getPostParam('cuerpo'));
        }
        $this->_view->datos = $this->_post->getPost($this->sacaId($id));
        $this->_view->renderizar('editar','post');
    }
    
    public function actualizaPost($id, $titulo, $cuerpo)
    {
        //$this->_view->datos = $_POST;

        if(!$this->getTexto('titulo')){
            $this->_view->_error = "Debe Introducir el título del post";
            $this->_view->renderizar('editar','post');
            exit;
        }

        if(!$this->getTexto('cuerpo')){
            $this->_view->_error = "Debe Introducir el cuerpo del post";
            $this->_view->renderizar('editar','post');
            exit;
        }

        $this->_post->editarPost($this->sacaId($id),
                                    $this->getPostParam('titulo'),
                                    $this->getPostParam('cuerpo') );

        $this->redireccionar('post');        
    }
    
    public function eliminar($id)
    {
        Session::acceso('admin');
        if(!$this->sacaId($id)){
            $this->redireccionar('post');
        }
        if(!$this->_post->getPost($this->sacaId($id))){
            $this->redireccionar('post');
        }
        $this->_post->eliminarPost($this->sacaId($id));
        $this->redireccionar('post');
        
    }

}
