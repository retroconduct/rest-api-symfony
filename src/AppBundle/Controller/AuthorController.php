<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Author;

class AuthorController extends FOSRestController
{

    public function getAuthorsAction()
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:Author')->findAll();

        if ($result === null) {
            return new View("No Authors Found", Response::HTTP_NOT_FOUND);
        }

        return $result;
    }

    public function getAuthorAction($id)
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:Author')->find($id);

        if ($result === null) {
            return new View("Author Not Found", Response::HTTP_NOT_FOUND);
        }

        return $result;
    }

    public function postAuthorAction(Request $request)
    {
        $author = new Author;
        $name   = $request->get('name');

        if (empty($name)) {
            return new View("Name Cannot Be Empty", Response::HTTP_NOT_ACCEPTABLE); 
        } 

        $author->setName($name);

        $em = $this->getDoctrine()->getManager();
        $em->persist($author);
        $em->flush();

        return new View("Author Added", Response::HTTP_OK);
    }

    public function patchAuthorsAction($id, Request $request)
    { 
        $name = $request->get('name');

        if (empty($name)) {
            return new View("Name Cannot Be Empty", Response::HTTP_NOT_ACCEPTABLE); 
        } 

        $em     = $this->getDoctrine()->getManager();
        $author = $em->getRepository('AppBundle:Author')->find($id);
        
        $author->setName($name);
        $em->flush();

        return new View("Author Updated", Response::HTTP_OK);
    }

    public function deleteAuthorAction($id)
    {
        $author = new Author;
        $author = $this->getDoctrine()->getRepository('AppBundle:Author')->find($id);

        if (empty($author)) {
            return new View("Author Not Found", Response::HTTP_NOT_FOUND);
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($author);
            $em->flush();
        }

        return new View("Author Deleted", Response::HTTP_OK);
    }
}
