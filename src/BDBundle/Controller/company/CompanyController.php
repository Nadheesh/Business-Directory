<?php

namespace BDBundle\Controller\company;

use BDBundle\Controller\map\MapController;
use BDBundle\Document\company\Address;
use BDBundle\Document\company\Company;
use BDBundle\Form\company\Type\BranchType;
use BDBundle\Form\company\Type\CompanyType;
use BDBundle\Document\company\Branch;
use Geocoder\Exception\NoResult;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use BDBundle\Document\company\ProductType;


class CompanyController extends Controller
{


    /**
     * Render and process business registration form
     * This will render multistep form to register business
     *
     * @Route("/company/register", name="company_register")
     */
    public function registerFlowAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('login');
        }


        $user = $this->getUser();
        if ($user) {

            $u_dm = $this->get('doctrine_mongodb')->getManager();
            $userdb= $u_dm->getRepository('BDBundle:security\RegisteredUser')
                ->find($user->getUsername());

            if ($userdb){
                $companies = $userdb->getCompanies();

                if(sizeof($companies) >2){
                    return $this->redirectToRoute('profile',array('error'=>'You can\'t register more than 3 companies. Please remove one first.'));
                }

                //load relevant document objects
                $company = new Company();
                $company->setCreated();

                //load productTypes from database
                $productTypes = $this->get('doctrine_mongodb')
                    ->getRepository('BDBundle:company\ProductType')
                    ->findAll();

                //check product type loading was successful
                if (!$productTypes) {
                    throw $this->createNotFoundException('No products are registered in the system');
                } else {

                    $flow = $this->get('form.company.flow.register');//create an new register flow
                    $flow->setProducts($productTypes); //bind productTypes to options
                    $flow->bind($company);//bind company document to the flow


                    $form = $flow->createForm($company);

                    if ($flow->isValid($form)) {// if flow is valid then proceed to next step

                        $flow->saveCurrentStepData($form);//save current data in the flow

                        //check for unique email addresses
                        //when step is 3 user enter the email
                        //this will capture step 3 and check if email is registered before
                        //if not processed to step 4
                        if ($flow->getCurrentStep() == 3) {

                            $repository = $this->get('doctrine_mongodb')
                                ->getRepository('BDBundle:company\Company');

                            //check if the email exists
                            if (($repository->findOneByContactEmail($company->getContactEmail())) == null) {

                                if ($flow->nextStep()) {
                                    // form for the next step
                                    $form = $flow->createForm($company);
                                }
                            } else {
                                //add an error to email type field
                                $form->get('contactEmail')->addError(new FormError('The Email already exists'));
                            }

                        } else {//if not step==2

                            if ($flow->nextStep()) {
                                // form for the next step
                                $form = $flow->createForm($company);
                            } else {

                                if ($form->isValid() && $form->isSubmitted()) { //check for form submission

                                    $address = $company->getAddress();

                                    $coordinate = MapController::getCoordinates($address);
                                    $address->setLatitude($coordinate->getLatitude());
                                    $address->setLongitude($coordinate->getLongitude());



                                    if($company->getBusinessType() == 'Unregistered'){
                                        $company->setRegisteredCountry(null);
                                        $company->setStartDate(null);
                                    }

                                    //store registered company to the database
                                    $em = $this->get('doctrine_mongodb')->getManager();
                                    $em->persist($company);
                                    $em->flush();

                                    $flow->reset(); //reset the form session. then form expired after submission

                                    $companies[] = ($company->getId());
                                    $userdb->setCompanies($companies);
                                    $u_dm->flush();

                                    //return an response to indicate successful registration
                                    return $this->redirectToRoute('profile',array('success'=>'Hooray...You have successfully registered ' . $company->getCompanyName() ));


                                }


                            }
                        }
                    }

                    return $this->render('BDBundle:registration:companyRegistration.html.twig', array(
                        'form' => $form->createView(),
                        'flow' => $flow,
                        'formData' => $company,
                    ));

                }

            }
        }
    }



    /**
     *
     * @Route("/company/modify_branches", name="modify_branches")
     */
    public function modifyBranchesAction(Request $request)
    {
        $company_id = $request->query->get('id');

        //load company from database
        $dm = $this->get('doctrine_mongodb')
            ->getManager();

        $company = $dm->createQueryBuilder('BDBundle:company\Company')
            ->hydrate(false)
            ->field('_id')->equals($company_id)
            ->getQuery()
            ->getSingleResult();

        if (!$company) {
//            throw $this->createNotFoundException('No company is registered in the system');
            return new JsonResponse('company not found'.$company_id, 404);
        } else {


            //process the company data to work with javascript after json_encode
            $branches = $company['branches'];

            $company['address']['country'] = Address::getCountryName($company['address']['country']);
            for ($x = 0; $x < sizeof($branches); $x++) {
                $branches[$x]['address']['country_code'] = $branches[$x]['address']['country'];
                $branches[$x]['address']['country'] = Address::getCountryName($branches[$x]['address']['country']);
                $branches[$x]['_id'] = (string)$branches[$x]['_id'];
            }

            $branch = new Branch();
            $form = $this->createForm(BranchType::class, $branch, array('validation_groups' => 'modify_branch'));

            if ($request->getMethod() === 'POST') {
                $form->handleRequest($request);
                if ($form->isValid()) {

//                    foreach ($company->getBranches() as $branch) {
//
//                        $address = $branch->getAddress();
//
//                        $coordinate = MapController::getCoordinates($address);
//
//                        $address->setLatitude($coordinate->getLatitude());
//                        $address->setLongitude($coordinate->getLongitude());
//                    }

//                    $company->setCompanyPage($companyPage);
//                    $dm->flush();
                    return new JsonResponse('jnjTestFormSubmission' . $branch->getBranchName());
                }
                return new JsonResponse(array('error' => $this->getFormErrors($form)), 400);
            }
        }

        //render the searchForm
        return $this->render('BDBundle:profile/template:profileBranchTemplate.html.twig', array(
            'form' => $form->createView(),
            'branches' => $branches,
            'head_office' => $company['address'],
            'company_id' => (string)$company['_id']
        ));

    }


    /**
     *
     * @Route("/company/general", name="modify_generalinfo")
     */
    public function modifyGeneralInfoAction(Request $request)
    {
        $company_id = $request->query->get('id');

        //load productTypes from database
        $productTypes = $this->get('doctrine_mongodb')
            ->getRepository('BDBundle:company\ProductType')
            ->findAll();

        //check product type loading was successful
        if (!$productTypes) {
            return new JsonResponse('Error loading product types'.$company_id, 500);
        }


        $dm=$this->get('doctrine_mongodb')->getManager();
        $company = $dm->getRepository('BDBundle:company\Company')
            ->find($company_id);

        if (!$company) {
            return $this->redirectToRoute('error_404');
        } else {

            $company->setProductTypes($company->getProductTypes()->toArray());

            $form = $this->createForm(CompanyType::class, $company ,
                array(
                    'productTypes'=>$productTypes,
                    'validation_groups' => 'modify_branch',
                    'flow_step'=>1
                ));

            if ($request->getMethod() === 'POST') {
                $form->handleRequest($request);
                if ($form->isValid()) {

                    $dm->flush();
                    return new JsonResponse('JNJSubmitSuccessGeneral',200);
                }
                return new JsonResponse(array('error' => $this->getFormErrors($form)), 400);
            }
        }

        //render the searchForm
        return $this->render('BDBundle:profile/template:profileGeneralInfo.html.twig', array(
            'form' => $form->createView(),
            'company_id' => (string)($company->getId()),
            'company' =>$company
        ));

    }




    /**
     *
     * @Route("/company/remove_branch", name="remove_branch")
     */
    public function removeBranchAction(Request $request)
    {

        if ($request->getMethod() === 'POST') {

            $company_id = $request->request->get('id');
            $branch_id = $request->request->get('branch_id');

                //load company from database
                $dm = $this->get('doctrine_mongodb');
                $company= $dm->getRepository('BDBundle:company\Company')
                    ->find($company_id);

                $branchesArry = array();
                $branches= $company->getBranches();
                if ($branches != null){
                    foreach($branches as $b){
                        if ($b->getId() != $branch_id){
                            $branchesArry[]=$b;
                        }
                    }

                    $company->setBranches($branchesArry);
                    $dm->flush();
                }

            return new JsonResponse($branch_id . 'jnjTestRemoveBranchSubmission' . $company_id);
        }
        return new JsonResponse('Error', 400);
    }


    /**
     *
     * @Route("/company/remove_company", name="remove_company")
     */
    public function removeCompanyAction(Request $request)
    {

        $company_id = $request->query->get('id');

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('login');
        }
        $user = $this->getUser();
        if ($user) {

            $u_dm = $this->get('doctrine_mongodb')->getManager();
            $userdb = $u_dm->getRepository('BDBundle:security\RegisteredUser')
                ->find($user->getUsername());

              
            if ($userdb) {
                $companies = $userdb->getCompanies();
                foreach($companies as $key=>$c){

                    if ($c == trim($company_id)){
                        $dm = $this->get('doctrine_mongodb')->getManager();
                        $company= $dm->getRepository('BDBundle:company\Company')
                            ->find($company_id);

                        $dm->remove($company);
                        $dm->flush();

                        unset($companies[$key]);

                        $userdb->setCompanies($companies);

                        return $this->redirectToRoute('profile',array('success'=>'You have successfully removed the company'));
                    }
                }

            }
        }

       // return $this->redirectToRoute('error_404');


    }



//    ================================INDIRECT USE OF FUNCTIONS=====================================




    /**
     * development purposes only
     * method created to add productTypes
     * @Route("/company/insertPT", name="insert_PT")
     */
    public function insertProductTypes(Request $request){

        $pTemp =
            'Computer trade,Electrical appliances,Food,Real estate,Textile,Garment,Food,Agriculture,Health,Tourism,Communication,
            Education,Travel,Hotel,Petroleum,Power,Construction,Beverages,Motor vehicles,Steel and Iron,Glassware,
            Building Material,Furniture,Film Industry,Diamond,Gem and Mining,Software development,Computer Hardware,
            Network design,Web Design,Computer security,Computer Service Centre,Electric goods Manufacturers,Electric goods show rooms,
            Electric goods spare part,Repair service,Sellers,Agents,Brokers,Schools,Universities,Private Tutorials,Technical colleges,
            Hospitals and Clinics,Pathological Laboratories,Pharmacies and Drug manufacturing,Medical instruments,Medical staff Training institutes,
            Lands,Irrigation Systems and structures,Fertilizers manufacturing,Petroleum,Refineries,Systems and structure to Distribute Petrol,Electricity,
            System and Structure to distribute Electricity,Vehicle Manufacturers,Vehicle Distributors,Vehicle Spare parts,Vehicle Servicing,Financing,Poultry Farms,Other animal farms,Suppliers of animal food,
            Suppliers of farming accessories ,Agricultural farms,Tourism,Travel agents,Hotels,Iron Mining,Iron and steel Manufacturing,Steel sellers,Scrap recycling,
            Cracking,Dating,Security,Online Trading,Insurance,Gambling in general,Lottery,Online games,PC games,Mobile Games and Apps,Auctions,
            Online Shopping,Real Estate,Web based Chat,Telecommunication,Mail,Newspapers,Magazines,Storage Services,Employment,
            Sports Gear,Media,Music,Fortune-telling,Entertainment,Advertisements,Retail Store,Furniture,Electronics,Super Market,
            Food Items,Textile,Beverage';

        $tempArray = preg_split("/[,]+/", $pTemp);
        sort($tempArray);
        $em = $this->get('doctrine_mongodb')->getManager();


        foreach ($tempArray as $pt) {
            $p = new ProductType();
            $p->setProductType($pt);
            $em->persist($p);
        }
        $em->flush();

        return new Response('Added productTypes- ');
    }





//    ====================================GET ERROR FORM========================================
    /**
     * @param \Symfony\Component\Form\Form $form
     * @return array
     */
    public function getFormErrors(\Symfony\Component\Form\Form $form)
    {
        $errors = $form->getErrors(true, false);

        return $this->findError($errors);
    }

    /**
     * @param $errorIterator
     * @return array
     */
    public function findError($errorIterator)
    {
        $errors = array();

        foreach ($errorIterator as $error) {

            if ($error instanceof \Symfony\Component\Form\FormErrorIterator) {

                $temp = $this->findError($error);
                $errors = array_merge($errors, $temp);

            } elseif ($error instanceof \Symfony\Component\Form\FormError) {

                $temp = array();
                $temp['name'] = $error->getOrigin()->getName();
                $temp['error'] = $error->getMessage();
                $errors[] = $temp;

            }
        }
        return $errors;
    }

//    =======================================END GET ERROR FORM======================================
}

