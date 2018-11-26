<?php

namespace Application\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
/** @ODM\Document */
class Movies
{
   
    private $id;

    private $title;

    private $year;

    /**
     * @return the $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return the $title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return the $year
     */
    public function getYear() {
        return $this->year;
    }

    /**
     * @param field_type $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @param field_type $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @param field_type $year
     */
    public function setYear($year) {
        $this->year = $year;
    }

}