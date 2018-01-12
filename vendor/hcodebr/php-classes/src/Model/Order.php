<?php
namespace Hcode\Model;
use \Hcode\DB\Sql;
use \Hcode\Model;
class Order extends Model{
	public function save(){
        $sql = new Sql();
        $result = $sql->select("CALL sp_orders_save(:idorder, :idcart, :iduser, :idstatus, :idaddress, :vltotal)", array(
            ":idorder"=>$this->gtidorder(),
            ":idcart"=>$this->gtidcart(),
            ":iduser"=>$this->gtiduser(),
            ":idaddress"=>$this->gtidaddress(),
            ":idstatus"=>$this->gtidstatus(),
            ":vltotal"=>$this->gtvltotal()
        ));
        if(count($result) > 0){
            $this->setData($result[0]);
        }
    }
    public function get($idorder){
        $sql = new Sql();
        $result = $sql->select("
            SELECT * FROM tb_orders a 
            INNER JOIN tb_ordersstatus b USING(idstatus) 
            INNER JOIN tb_carts c USING(idcart) 
            INNER JOIN tb_users d ON d.iduser = a.iduser 
            INNER JOIN tb_addresses e USING(idaddress) 
            INNER JOIN tb_persons f ON f.idperson = d.idperson 
            WHERE a.idorder = :idorder", array(
            ":idorder"=>$idorder
        ));
        if(count($result) > 0){
            $this->setData($result[0]);
        }
    }
}
?>