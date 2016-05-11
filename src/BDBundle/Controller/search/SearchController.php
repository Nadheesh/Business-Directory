<?php

namespace BDBundle\Controller\search;


use BDBundle\Document\company\Address;
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



class SearchController extends Controller
{


    /**
     * This will perform the searching and filtering of companies
     *
     * @Route("/company/search", name="company_search")
     */
    public function searchCompanyAction(Request $request)
    {
        $page = null;
        $view = null;
        $view = $request->query->get('view');
        $page = $request->query->get('page');

        if ($page == null || $page < 1 ){
            $page = 1;
        }


        $limit = 10 * $page;
        $skip = $limit - 10;

        //load relevant document objects
        $filterTags = new SearchTag();

        //load product types from database
        $productTypes = $this->get('doctrine_mongodb')
            ->getRepository('BDBundle:company\ProductType')
            ->findAll();


        if (!$productTypes) {
            throw $this->createNotFoundException('No products are registered in the system');
        } else {

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
                    ->createQueryBuilder('BDBundle:company\Company')->limit($limit)->skip($skip);

                if ($view != null && $view == 'map') {
                    $qb->hydrate(false);
                }

                $search_tag = $filterTags->getSearchKey();


                if ($search_tag != null && $search_tag != "") {

                    $qb->selectMeta('score', 'textScore');
                    $qb->text($search_tag);

                } elseif ((is_null($filterTags->getCountry()) || !sizeof($filterTags->getCountry()) > 0) &&
                    (is_null($filterTags->getProductTypes()) || !sizeof($filterTags->getProductTypes()) > 0)
                ) {

                    $qb->selectMeta('score', 'textScore');
                    $qb->text($search_tag);

                }

                //search tags are still under developments
                if (!is_null($filterTags->getStartDate())) {
                    $qb->field('startDate')->gte($filterTags->getStartDate());
                }
                if (!is_null($filterTags->getCountry()) && sizeof($filterTags->getCountry()) > 0) {
                    foreach ($filterTags->getCountry() as $country) {
                        $temp[] = $country;
                    }
                    $qb->field('registeredCountry')->in($temp);
//                    $qb->field()->equals();
                }

                if (!is_null($filterTags->getProductTypes()) && sizeof($filterTags->getProductTypes()) > 0) {
                    $temp = array();
                    foreach ($filterTags->getProductTypes() as $productType) {
                        $temp[] = $productType->getProductType();
                    }
                    $qb->field('productTypes.productType')->in($temp);
                }


                //execute the search query
                $companies = $qb->getQuery()->execute();

                $count = sizeof($companies);

                $template = null;
                if ($companies != null) {
                    if ($view != null && $view == 'map') {

                        $companies = $companies->toArray();

                        $branches = array();
                        foreach ($companies as $c) {

                            $c['address']['country'] = Address::getCountryName($c['address']['country']);

                            $branch = array();
                            $branch['address'] = $c['address'];
                            $branch['email'] = $c['contactEmail'];
                            $branch['address'] = $c['address'];
                            $branch['contactNumbers'] = $c['contactNumbers'];
                            $branch['_id'] = (string)$c['_id'];
                            $branch['c_id'] = (string)$c['_id'];

                            if ($c['branches'] != null && $c['branches'] > 0) {
                                $branch['branchName'] = $c['companyName'] . ' HQ';
                            } else {
                                $branch['branchName'] = $c['companyName'];
                            }

                            $c['branches'][] = $branch;

                            for ($y = 0; $y < sizeof($c['branches']); $y++) {
                                $c['branches'][$y]['address']['country_code'] = $c['branches'][$y]['address']['country'];
                                $c['branches'][$y]['address']['country'] = Address::getCountryName($c['branches'][$y]['address']['country']);
                                $c['branches'][$y]['_id'] = (string)$c['branches'][$y]['_id'];
                                $c['branches'][$y]['c_id'] = (string)$c['_id'];

                                $branches[] = $c['branches'][$y];
                            }

                        }


                        $request = new Request();
                        $request->query->set('branches', $branches);
                        $request->query->set('filterTags', $filterTags->getSearchKey());
                        $request->query->set('count', $count);

                        $template = $this->forward('BDBundle:search/Search:searchResultViewMap', array(
                            'request' => $request
                        ))->getContent();


                    } else {

                        $request = new Request();
                        $request->query->set('companies', $companies);
                        $request->query->set('filterTags', $filterTags->getSearchKey());
                        $request->query->set('count', $count);

                        $template = $this->forward('BDBundle:search/Search:searchResultView', array(
                            'request' => $request
                        ))->getContent();
                    }

                    if ($template != null) {
                        $json = json_encode($template);
                        $response = new Response($json, 200);
                        $response->headers->set('Content-Type', 'application/json');
                        return $response;
                    }
                }

                return $this->redirectToRoute('error_404');

            }

        }

        //render the searchForm
        return $this->render('BDBundle:search:companySearch.html.twig', array(
            'form' => $form->createView(),
            'view'=> 'default',

        ));

    }



    public function searchResultViewMapAction(Request $request)
    {

        $branches = $request->query->get('branches');
        $filterTags = $request->query->get('filterTags');
        $count = $request->query->get('count');

        if ($branches == null) {
            $branches = array();
        }

        //display the search results
        return $this->render('BDBundle:search:searchResultsMapView.html.twig', array(
            'branches' => $branches,
            'keyWord' => $filterTags,
            'count'=>$count,
            'view' =>'map'
        ));
    }


    public function searchResultViewAction(Request $request){

        $companies = $request->query->get('companies');
        $filterTags = $request->query->get('filterTags');
        $count = $request->query->get('count');

        if ($companies==null){
            return $this->redirectToRoute('error_404');

        }

        //display the search results
        return $this->render('BDBundle:search:searchResultsView.html.twig', array(
            'companies' => $companies ,
            'keyWord' => $filterTags,
            'count'=>$count,
            'view' =>'default'
        ));

    }




//    ======================deprecated===============================================
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
        return $this->render('BDBundle:search:companySearch.html.twig',array(
            'form' => $form->createView(),
        ));

    }


}
