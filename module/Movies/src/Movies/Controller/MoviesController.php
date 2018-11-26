<?php

namespace Movies\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;

 class MoviesController extends AbstractActionController
 {
     protected $moviesTable;

     public function indexAction()
     {
        return new ViewModel(array(
            'movies' => $this->getMoviesTable()->fetchAll(),
        ));
     }

     public function addAction()
     {
        {
            //Instanciando
            $form = new MoviesForm();
            $form->get('submit')->setValue('Add');
            
            
            $request = $this->getRequest();
            if ($request->isPost()) {
                $movies = new Movies();
                $form->setInputFilter($movies->getInputFilter());
                $form->setData($request->getPost());
   
                if ($form->isValid()) {
                    $movies->exchangeArray($form->getData());
                    $this->getMoviesTable()->saveMovies($movies);
   
                    // Redirecioanando lista de movies
                    return $this->redirect()->toRoute('movies');
                }
            }
            return array('form' => $form);
        }    
     }

     public function editAction()
     {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('movies', array(
                'action' => 'add'
            ));
        }
        //Tratamento de exceções
        try {
            $movies = $this->getMoviesTable()->getMovies($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('movies', array(
                'action' => 'index'
            ));
        }

        $form  = new MoviesForm();
        $form->bind($movies);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($movies->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getAlbumTable()->saveMovies($movies);

                // Redirecionando lista de movies
                return $this->redirect()->toRoute('movies');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
     }

     public function deleteAction()
     {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('movies');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getMoviesTable()->deleteMovies($id);
            }

            // Redirecionando lista de movies
            return $this->redirect()->toRoute('movies');
        }

        return array(
            'id'    => $id,
            'movies' => $this->getAlbumTable()->getMovies($id)
        );
     }
     
     public function getMoviesTable()
     {
         if (!$this->moviesTable) {
             $sm = $this->getServiceLocator();
             $this->moviesTable = $sm->get('Movies\Model\MoviesTable');
         }
         return $this->moviesTable;
     }
 } 