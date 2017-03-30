<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Article;

class ArticleController extends FOSRestController
{
    public function getArticlesAction()
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:Article')->findAll();

        if ($result === null) {
            return new View("No Articles Found", Response::HTTP_NOT_FOUND);
        }

        return $result;
    }

    public function getArticleAction($id)
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:Article')->find($id);

        if ($result === null) {
            return new View("Article Not Found", Response::HTTP_NOT_FOUND);
        }

        return $result;
    }

    public function postArticleAction(Request $request)
    {
        $article  = new Article;
        $title    = $request->get('title');
        $url      = $request->get('url');
        $content  = $request->get('content');
        $authorId = $request->get('author_id');

        if (empty($title)) {
            return new View("Title Cannot Be Empty", Response::HTTP_NOT_ACCEPTABLE); 
        } 

        if (empty($url)) {
            return new View("Url Cannot Be Empty", Response::HTTP_NOT_ACCEPTABLE); 
        } 

        if (empty($content)) {
            return new View("Content Cannot Be Empty", Response::HTTP_NOT_ACCEPTABLE); 
        } 

        if (empty($authorId)) {
            return new View("Author Cannot Be Empty", Response::HTTP_NOT_ACCEPTABLE); 
        } 

        $author = $this->getDoctrine()->getRepository('AppBundle:Author')->find($authorId);

        if (empty($author)) {
            return new View("Author Not Found", Response::HTTP_NOT_ACCEPTABLE); 
        } 

        $article->setTitle($title);
        $article->setUrl($url);
        $article->setContent($content);
        $article->setAuthor($author);

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return new View("Article Added", Response::HTTP_OK);
    }

    public function patchArticleAction($id, Request $request)
    { 
        $title    = $request->get('title');
        $url      = $request->get('url');
        $content  = $request->get('content');
        $authorId = $request->get('author_id');

        if (empty($title)) {
            return new View("Title Cannot Be Empty", Response::HTTP_NOT_ACCEPTABLE); 
        } 

        if (empty($url)) {
            return new View("Url Cannot Be Empty", Response::HTTP_NOT_ACCEPTABLE); 
        } 

        if (empty($content)) {
            return new View("Content Cannot Be Empty", Response::HTTP_NOT_ACCEPTABLE); 
        } 

        if (empty($authorId)) {
            return new View("Author Cannot Be Empty", Response::HTTP_NOT_ACCEPTABLE); 
        } 
        
        $em      = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);
        $author  = $em->getRepository('AppBundle:Author')->find($authorId);
        
        if (empty($article)) {
            return new View("Article Not Found", Response::HTTP_NOT_FOUND);
        } elseif (empty($author)) {
            return new View("Author Not Found", Response::HTTP_NOT_FOUND); 
        } else {
            $article->setTitle($title);
            $article->setUrl($url);
            $article->setContent($content);
            $article->setAuthor($author);
            $em->flush();

            return new View("Article Updated", Response::HTTP_OK);
        }
    }

    public function deleteArticleAction($id)
    {
        $em      = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        if (empty($article)) {
            return new View("Article Not Found", Response::HTTP_NOT_FOUND);
        } else {
            $em->remove($article);
            $em->flush();
        }

        return new View("Article Deleted", Response::HTTP_OK);
    }
}
