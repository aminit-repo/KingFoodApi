<?php
/*
  Authors : initappz (Rahul Jograna)
  Website : https://initappz.com/
  App Name : ionic 5 foodies app
  Created : 10-Sep-2020
  This App Template Source code is licensed as per the
  terms found in the Website https://initappz.com/license
  Copyright and Good Faith Purchasers © 2020-present initappz.
*/ defined('BASEPATH') OR exit('No direct script access allowed');
class Paykun extends CI_Controller
{
    function  __construct() {
        parent::__construct();
        $this->load->helper('url');

    }
     
    function index(){
        $data = array(
            'key' => $_GET['key'],
            'accessToken' => $_GET['accessToken'],
            'isLive' => $_GET['isLive'],
            'amount' => $_GET['amount'],
            'email' => $_GET['email'],
            'name'=>$_GET['name'],
            'mobile'=>$_GET['mobile'],
            'callback' => base_url().'paykun/success?id=',
            'onClose' =>base_url().'paykun/close',
        );
        $this->load->view('Paykun/pay',$data);
    }

    function success(){
        $this->load->view('Paykun/success');
    }
    function close(){
        $this->load->view('Paykun/close');
    }
}