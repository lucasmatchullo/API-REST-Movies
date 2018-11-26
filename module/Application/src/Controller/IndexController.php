<?php


namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\ActionController;
use Application\Document\Movies;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $dm = $this->getLocator()->get('mongo_dm');

        $movies = new Movies();
        $movies->setTitle('Lucy');
        $movies->setYear('2016');
        
        $dm->persist($movies);
        $dm->flush();
        return new ViewModel();
    }
}
