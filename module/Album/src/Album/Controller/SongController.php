<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SongController extends AbstractActionController
{


    public function indexAction()
    {
        return array(
            'data'    => 'song here.....'
        );	
    }


    public function testAction()
    {
        return array(
            'data'    => 'song testing 123'
        );	
    }


}
