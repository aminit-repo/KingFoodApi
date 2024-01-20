<?php
/*
  Authors : initappz (Rahul Jograna)
  Website : https://initappz.com/
  App Name : ionic 5 foodies app
  Created : 10-Sep-2020
  This App Template Source code is licensed as per the
  terms found in the Website https://initappz.com/license
  Copyright and Good Faith Purchasers © 2020-present initappz.
*/
require_once APPPATH.'/core/Main_model.php';
class Order_model extends Main_model
{
    public $table_name = "orders";
	public function __construct(){
		parent::__construct();
        $this->load->library('upload','encrypt');
        $this->load->helper('string');
        
    }

    public function getById($id){
        $this->db->select('order.uid as uid,order.address as address,order.notes as notes,order.did as did,order.applied_coupon as applied_coupon,order.coupon_id as coupon_id,order.restId as restId,str.name as str_name,order.id as orderId,order.delivery_charge as delivery_charge, order.discount as discount,order.grand_total as grand_total,order.orders as orders,order.paid as paid,order.pay_method as pay_method,order.serviceTax as serviceTax,order.status as status,order.time as time,order.total as total,order.uid as uid,str.address as str_address,str.cover as str_cover,usr.fcm_token as str_fcm_token,usr.mobile as str_mobile');
        $this->db->from("orders as order");
        $this->db->join('store as str','order.restId = str.uid');
        $this->db->join('users as usr','order.restId = usr.id');
        $this->db->order_by("order.id", "desc");
        $this->db->where('order.id',$id);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getByUid($id){
        $this->db->select('order.uid as uid,order.address as address,order.notes as notes,order.did as did,order.applied_coupon as applied_coupon,order.coupon_id as coupon_id,order.restId as restId,str.name as str_name,order.id as orderId,order.delivery_charge as delivery_charge, order.discount as discount,order.grand_total as grand_total,order.orders as orders,order.paid as paid,order.pay_method as pay_method,order.serviceTax as serviceTax,order.status as status,order.time as time,order.total as total,order.uid as uid,str.address as str_address,str.cover as str_cover');
        $this->db->from("orders as order");
        $this->db->join('store as str','order.restId = str.uid');
        $this->db->order_by("order.id", "desc");
        $this->db->where('order.uid',$id);
        $data = $this->db->get()->result();
        return $data;
    }
    

     public function getByStoreId($id){
        $this->db->select('order.uid as uid,order.address as address,order.did as did,order.notes as notes,order.applied_coupon as applied_coupon,order.coupon_id as coupon_id,order.restId as restId,order.id as orderId,order.delivery_charge as delivery_charge, order.discount as discount,order.grand_total as grand_total,order.orders as orders,order.paid as paid,order.pay_method as pay_method,order.serviceTax as serviceTax,order.status as status,order.time as time,order.total as total,order.uid as uid,usr.first_name as user_first_name,usr.last_name as user_last_name,usr.cover as user_cover,usr.fcm_token as user_fcm_token');
        $this->db->from("orders as order");
        $this->db->join('users as usr','order.uid = usr.id');
        $this->db->order_by("order.id", "desc");
        $this->db->where('order.restId',$id);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getByStoreWithNames($id){
        $this->db->select('order.uid as uid,order.address as address,order.assignee as assignee,order.notes as notes,order.coupon_code as coupon_code,order.date_time as date_time,order.delivery_charge as delivery_charge,order.discount as discount,order.driver_id as driver_id,order.grand_total as grand_total,order.id as id,order.notes as notes,order.order_to as order_to,order.orders as orders,order.paid_method as paid_method,order.pay_key as pay_key,order.status as status,order.store_id as store_id,order.tax as tax,order.total as total,user.cover as cover,user.first_name as first_name,user.last_name as last_name');
        $this->db->from("orders as order");
        $this->db->join('users as user','order.uid = user.id');
        $this->db->where("FIND_IN_SET(".$id.",store_id) >", 0);
        $this->db->order_by("id", "desc");
        // $this->db->limit(10);
        $data = $this->db->get()->result();
        return $data;
    }

    public function getByDriverId($id){
        $this->db->select('order.uid as uid,order.address as address,order.did as did,order.notes as notes,order.applied_coupon as applied_coupon,order.coupon_id as coupon_id,order.restId as restId,order.id as orderId,order.delivery_charge as delivery_charge, order.discount as discount,order.grand_total as grand_total,order.orders as orders,order.paid as paid,order.pay_method as pay_method,order.serviceTax as serviceTax,order.status as status,order.time as time,order.total as total,order.uid as uid,usr.first_name as user_first_name,usr.last_name as user_last_name,usr.cover as user_cover');
        $this->db->from("orders as order");
        $this->db->join('users as usr','order.uid = usr.id');
        $this->db->order_by("order.id", "desc");
        $this->db->where('order.did',$id);
        $data = $this->db->get()->result();
        return $data;
    }

    public function driverStats($data){
        $this->db->select('*')->from($this->table_name);
        $this->db->where('time >=', $data['start']);
        $this->db->where('time <=', $data['end']);
        $where = 'did = '.$data['did'];
        $this->db->where($where);
        $this->db->order_by("id", "desc");
        return $this->db->get()->result();
    }

    public function storeStats($data){
        $this->db->select('*')->from($this->table_name);
        $this->db->where('time >=', $data['start']);
        $this->db->where('time <=', $data['end']);
        $where = 'restId = '.$data['sid'];
        $this->db->where($where);
        $this->db->order_by("id", "desc");
        return $this->db->get()->result();
    }

    public function getAdminTop(){
        $this->db->select('order.id as id,order.address as address,order.notes as notes,order.applied_coupon,order.coupon_id as coupon_id,order.did as did,order.delivery_charge as delivery_charge,order.discount as discount,order.grand_total as grand_total,order.orders as orders,order.paid as paid,order.pay_method as pay_method,order.restId as restId,order.serviceTax as serviceTax,order.status as status,order.time as time,order.total as total,order.uid as uid,user.cover as cover,user.first_name as first_name,user.last_name as last_name,str.name as str_name');
        $this->db->from("orders as order");
        $this->db->join('users as user','order.uid = user.id');
        $this->db->join('store as str','order.restId = str.uid');
        $this->db->order_by("id", "desc");
        $this->db->limit(10);
        $data = $this->db->get()->result();
        return $data;
    }

    public function saveList($data){
        return $this->insert($this->table_name,$data);
    }

    public function editList($data,$id){
        $where = "id = ".$id;
        return $this->update($this->table_name,$data,$where);
    }


    public function deleteList($id){
        $where = "id =".$id;
        return $this->delete($this->table_name,$where);
    }

    public function getByIdValue($id){
        $where = 'id = '.$id;
        $data = $this->get($this->table_name,$where);
        return $data;
    }

    public function get_all(){
        $this->db->select('order.id as id,order.address as address,order.notes as notes,order.applied_coupon,order.coupon_id as coupon_id,order.did as did,order.delivery_charge as delivery_charge,order.discount as discount,order.grand_total as grand_total,order.orders as orders,order.paid as paid,order.pay_method as pay_method,order.restId as restId,order.serviceTax as serviceTax,order.status as status,order.time as time,order.total as total,order.uid as uid,user.cover as cover,user.first_name as first_name,user.last_name as last_name,str.name as str_name');
        $this->db->from("orders as order");
        $this->db->join('users as user','order.uid = user.id');
        $this->db->join('store as str','order.restId = str.uid');
        $this->db->order_by("id", "desc");
        $data = $this->db->get()->result();
        return $data;
    }

    public function adminAllOrders(){
        $this->db->select('*')->from($this->table_name);
        $this->db->order_by("id", "desc");
        return $this->db->get()->result();
        return $data;
    }

    public function saveUserLogs($data){
        $data = $this->saveLogs($data);
        return $data;
    }
}
