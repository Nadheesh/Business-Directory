<?php

namespace BDBundle\Controller;


use BDBundle\Document\company\Company;
use BDBundle\Document\company\SearchTag;
use BDBundle\Form\company\Type\CompanyType;
use Documents\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BDBundle\Form\search\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;



class DefaultController extends Controller
{

    /**
     * This will perform the searching and filtering of companies
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //load relevant document objects
        $filterTags = new SearchTag();

        //load product types from database
        $productTypes = $this->get('doctrine_mongodb')
            ->getRepository('BDBundle:company\ProductType')
            ->findAll();


        if(!$productTypes){
            throw $this->createNotFoundException('No products are registered in the system');
        }else {

            //create search form
            $form = $this->createForm(SearchType::class, $filterTags,

                array('productTypes' => $productTypes));//pass product types to search form as a option


            //handle search form requests
            $form->handleRequest($request);


            if ($form->isValid() && $form->isSubmitted()) {//check if valid form is submitted

                //starting to build and query builder
                //this can be customized to define new search tags
                $qb = $this->get('doctrine_mongodb')
                    ->getManager()
                    ->createQueryBuilder('BDBundle:company\Company');

                //search tags are still under developments
                if(!is_null($filterTags->getStartDate())) {

                    $qb->field('startDate')->gte($filterTags->getStartDate());
//                    ->selectMeta('score', 'textScore')
//                    ->text($filterTags->getSearchKey())
                }
                if (!is_null($filterTags->getSearchKey())) {
                    $qb->field('companyName')->equals($filterTags->getSearchKey());
                }
                if (!is_null($filterTags->getCountry())) {
                    $qb->field('registeredCountry')->equals($filterTags->getCountry());

                }
                if( sizeof($filterTags->getProductTypes()) > 0){
                    $temp = array();
                    foreach ($filterTags->getProductTypes() as $productType){
                        $temp[]=$productType->getProductType();
                    }

                    $qb->field('productTypes.productType')->in($temp);

                }

                //execute the search query
                $companies = $qb->getQuery()->execute();


                //display the search results
                return $this->render('BDBundle:search:searchResultsView.html.twig', array(
                    'companies' => $companies ,
                    'keyWord' => $filterTags->getSearchKey()
                ));
            }
        }

        //render the searchForm
        return $this->render('BDBundle::index.html.twig',array(
            'form' => $form->createView(),
        ));

    }




    /**
     * This will perform the searching and filtering of companies
     * @Route("/error/404", name="error_404")
     */
    public function searchResultViewAction(Request $request){

        //display the search results
        return $this->render('BDBundle:system:error.html.twig');

    }

}
