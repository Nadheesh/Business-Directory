<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 5/28/2016
 * Time: 4:38 PM
 */

namespace BDBundle\Controller\oneUploader;

use Oneup\UploaderBundle\Uploader\Response\EmptyResponse;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Oneup\UploaderBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; // routing
use Symfony\Component\HttpFoundation\Request;



class CustomController extends  AbstractController
{

    public function upload()
    {
        // get some basic stuff together
        $request = $this->getRequest();
        $response = new CustomResponse();
        $files = $this->getFiles($request->files);


        $file = $files[0];

        try {
            $this->handleUpload($file,$response,$request);
        } catch(UploadException $e) {
            // return nothing
            return new JsonResponse(array());
        }


        // return assembled response
        return new JsonResponse($response->assemble());
    }

}