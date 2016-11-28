<?php
/**
 * Created by PhpStorm.
 * User: fhm
 * Date: 27/11/16
 * Time: 22:51
 */

namespace AppBundle\Controller\Api;
use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use AppBundle\Utils\InternalErrorCodes;
use FOS\RestBundle\Controller\Annotations as REST;
use FOS\UserBundle\Event as FOSUBEvent;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use OAuth2\OAuth2ServerException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\Api\AbstractApiController;
use Hateoas\Representation\Factory\PagerfantaFactory;
use JMS\Serializer\SerializationContext;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class ApiController extends AbstractApiController{


    /**
     * Récupère la liste des articles
     *
     * @Route ("/api/articles/{id}", name="api_show_article")
     * @Method("GET")

     */
    public function ShowAction($id){

        $article = $this->getDoctrine()->getRepository('AppBundle:Article')->findOneBy(array('id' => $id));
        if($article instanceof Article) {
            return $this->sendResponseSuccess($article);
        }else {
            return $this->sendResponseError("Il existe pas un article avec slug", Response::HTTP_OK);
        }

    }

    /**
     * Récupère la liste des articles
     *
     * @Route ("/api/articles/{slug}", name="api_list_articles")
     * @Method("GET")

     */
    public function listAction(){

        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')->findAll();
        $articleTable = [];
        foreach($articles as $article) {
            $articleTable[] = $article;
        }

        if(!$articleTable) {
            return $this->sendResponseSuccess($articleTable);
        }else {
            return $this->sendResponseError("pas liste");
        }

    }



    /**
     * Creation article
     *
     * @Route("/api/articles", name="api_create_articles")
     * @Method("POST")
     */


    public function createAction(Request $request){

        $article = new Article();
        $form = $this->createForm(new ArticleType(), $article);
        $form->setData($article);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            if ($this->flushData($article)) {
                return $this->sendResponseSuccess($article);
            }else {
                return $this->sendResponseError($errors[0]='Verifier', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        }

    }


    /**
     * delete article
     *
     * @Route ("/api/articles/{id}", name="api_delete_article")
     * @Method("GET")

     */
    public function deleteAction($id){

        $article = $this->getDoctrine()->getRepository('AppBundle:Article')->findOneBy(array('id' => $id));
        if(!$article instanceof Article)
        {
            return $this->sendResponseError("Article not found", InternalErrorCodes::ARTICLE_DOESNT_EXISTS);
        }
        if ($this->deleteData($article)) {
            return $this->sendResponseSuccess('article supprimer');
        }else{
            return $this->sendResponseError('erreur');
        }
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public function flushData($data)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return true;
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public function deleteData($data)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($data);
        $em->flush();
        return true;
    }
} 