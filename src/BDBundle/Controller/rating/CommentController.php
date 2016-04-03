<?php

namespace BDBundle\Controller\rating;

use BDBundle\Document\company\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; // routing


class CommentController extends Controller
{

    /**
     * This will perform the searching and filtering of companies
     *
     * @Route("/company/get/rating", name="get_rate")
     */
    public function searchCompanyAction(Request $request)
    {

        $page = null;
        $page = $request->query->get('page');
        $id = $request->query->get('id');

//        $id = '57578e1035b9a9640b00002c';

        //set the default page value
        if ($page == null || $page < 1 ){
            $page = 1;
        }

        $limit = 10 * $page;
        $skip = $limit - 10;


        //get the company from db
        $company = $this->get('doctrine_mongodb')->getManager()
            ->getRepository('BDBundle:company\Company')
            ->find($id);


        if (!$company){
            return $this->redirectToRoute('error_404');//if company/comments not fount return to not found
        }

        $comments= $company->getComments()->toArray();
        $comment_set = array_slice($comments, $skip, $limit);

        $comments = array();
        for ($y = 0; $y < sizeof($comment_set); $y++) {
            $comment[]= array();
            $comment['rate']=$comment_set[$y]->getRate();
            $comment['timestamp']= $comment_set[$y]->getTimestamp()->setTimezone(new \DateTimeZone('Asia/Colombo'))->format("F j, Y, g:i A");
            $comment['username']=$comment_set[$y]->getUsername();
            $comment['text']=$comment_set[$y]->getReview();

           $comments[] = $comment;
        }

        return new JsonResponse($comments,200);


    }


    /**
     *
     * @Route("/company/rate", name="rate_company")
     */
    public function rateCompanyAction(Request $request)
    {

        // check if user is logged in
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('login'); //else redirect him to the login
        }

        if ($user = $this->getUser()) {
//            $userName =$this->generateRandomString(7);
            $userName = $user->getUsername();
        } else {
            return $this->redirectToRoute('login'); //else redirect him to the login
        }

        //get the parameters from the request
        $company_id = $request->query->get('id');
        $rate = $request->query->get('rate');
        $text = $request->query->get('text');
//        $text =$this->generateRandomString(50);

        //get the company from db
        $dm = $this->get('doctrine_mongodb')->getManager();

        $company = $dm->getRepository('BDBundle:company\Company')
            ->find($company_id);

        if (!$company) {
            return $this->redirectToRoute('error_404');//if company not fount return to not found
        } else {

            $match = false;
            $total = null;
            $comment_count = $company->getCommentCount();
            $comments = $company->getComments();

            for ($y = 0; $y < sizeof($comments); $y++) {
                if ($comments[$y]->getUsername() == $userName){

                    $temp = $comments[$y];

                    $temp_score =$this->calculateTotalRating($company->getRatingScore(), $comment_count,$temp->getRate() ,false);
                    $comment_count--;

                    $temp->setRate($rate);
                    $temp->setReview($text);
                    $temp->setTimestamp(new \DateTime());

                    $comments[$y] = $temp;

                    $total = $this->calculateTotalRating($temp_score, $comment_count, $rate ,true);
                    $comment_count++;

                    $match = true;
                    break;
                }
            }

            if (!$match) {

                $comment = new Comment();
                $comment->setCreated(); //initiate with a time stamp

                //calculate current total
                $total = $this->calculateTotalRating($company->getRatingScore(), $comment_count, $rate ,true);
                $comment_count++;

                //set the received parameters
                $comment->setRate($rate);
                $comment->setReview($text);
                $comment->setUsername($userName);

                $comments->add($comment);

            }

            //set company parameters
            $company->setCommentCount($comment_count);
            $company->setRatingScore($total);
            $company->setComments($comments);

            //flush the changes to the db
            $dm->flush();




//            return new JsonResponse($company_id.$text.$rate,200);
            return new JsonResponse(array('username' => $userName, 'rate' => $rate,  'text'=> $text, 'total_score' =>$total, 'count'=>$comment_count), 200);
//            return new JsonResponse('success',200);
        }


    }


    private function calculateTotalRating($current,$current_count,$rate,$is_increase){

        if ($is_increase){
            return ($current*$current_count+$rate)/($current_count+1);
        }else{
            if ($current_count< 2){
                return 0 ;
            }
            return ($current*$current_count-$rate)/($current_count-1);
        }


    }


    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}
