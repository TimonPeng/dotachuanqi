<?php
@header("Content-type: text/html; charset=utf-8"); 
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->Env_model->init_env();
		$this->load->library('exjson');
	}
	
	public function index()
	{

			$response =  array('code'=>'404','msg'=>'action failed', 'data'=>'');
			$params=array();
			foreach($_POST as $k=>$v)
			{
				if($k!='service')
				{
					$params[$k] =$v;
				}
			}
		   $service = explode('.', $_POST['service']);
			if(count($service)==3)
			{
			if($service[0]=='app'){
			$model=$service[1].'_api_model';
			$this->load->model($model);
			$apiModel = $this->$model;
			
			if (method_exists($apiModel, $service[2])) $response = $apiModel->$service[2]($params);
			else $response['msg']='ServiceName ErrorMessage - Method Not Exists';
			} else $response['msg']='ServiceName ErrorMessage 0';
			} else $response['msg']='ServiceName ErrorMessage';
			return $this->response($response);
	}
	 public function response($response = array('code'=>'404','msg'=>'failed', 'result'=>''))
	 {
           echo json_encode($response);
           die();
     }
	
}