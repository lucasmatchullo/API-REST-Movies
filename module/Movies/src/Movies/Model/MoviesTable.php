<?php

namespace Movies\Model;

 use Zend\Db\TableGateway\TableGateway;

 class MoviesTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }
     //Recupera todos
     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }
     //Buscando uma ocorrência
     public function getMovies($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Não existe ocorrência com esse id: $id");
         }
         return $row;
     }
     //Salvando
     public function saveMovies(Movies $movies)
     {
         $data = array(
             'title'  => $movies->title,
             'year' => $movies->year,
         );

         $id = (int) $movies->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getMovies($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Esse filme não existe!');
             }
         }
     }
     //Deletando
     public function deleteMovies($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }