<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 5/28/2016
 * Time: 4:46 PM
 */

namespace BDBundle\Controller\oneUploader;


use Oneup\UploaderBundle\Uploader\Response\AbstractResponse;

class CustomResponse extends AbstractResponse
{
    protected $success;
    protected $error;

    public function __construct()
    {
        $this->success = true;
        $this->error = null;

        parent::__construct();
    }

    public function assemble()
    {
        // explicitly overwrite success and error key
        // as these keys are used internaly by the
        // frontend uploader
        $data = $this->data;

        $data['success'] = $this->success;

        if($this->success)
            unset($data['error']);

        if(!$this->success)
            $data['error'] = $this->error;

        return $data;
    }




}