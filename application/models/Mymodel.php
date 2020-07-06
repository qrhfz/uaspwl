<?php

    defined('BASEPATH') OR exit ('No direct script access allowed');

    class Mymodel extends CI_Model{
        public function Get($table){
            $res = $this->db->get($table);
            return $res->result_array();
        }
        public function GetWhere($table, $data){
            $res = $this->db->get_where($table, $data);
            return $res->result_array();
        }

        public function Insert($table, $data){
            $res = $this->db->insert($table, $data);
            return $res;
        }

        public function Update($table, $data, $where){
            $res = $this->db->update($table, $data, $where);
            return $res;
        }
        public function Delete($table, $where){
            $res = $this->db->delete($table, $where);
            return $res;
        }
        /*
        public function GetAcaraRelawan($id_relawan){
            $res = $this->db->query("SELECT a.nama, ra.id_acara,ra.status,ra.id_relawan_acara 
            FROM relawan_acara ra JOIN acara a ON ra.id_acara = a.id_acara 
            WHERE ra.id_relawan='$id_relawan'");
            return $res->result_array();
        }
        */
        public function email_ada_gak($email){
            $sql = "SELECT count(email) as c FROM user WHERE email = '$email'";
            $query = $this->db->query($sql);
            $res = $query->result_array();
            return $res[0]['c'];
        }

        
        public function CountLink($userid){
            $res = $this->db->query("SELECT COUNT(*) as c FROM `link` WHERE userid=$userid");
            return $res->result_array();
        }

        public function sumClick($userid){
            
            $query = $this->db->query("SELECT SUM(click) as s FROM `link` WHERE userid=$userid");
            $res = $query->result_array();
            return (int)$res[0]['s'];
        }

        public function jadi_panjang($pendek){
            $sql = "SELECT panjang FROM link WHERE pendek = '$pendek'";
            $query = $this->db->query($sql);
            $res = $query->result_array();
            return $res[0]['panjang'];
        }

        public function addClick($pendek){
            $sql = "UPDATE link SET click = click + 1 WHERE pendek='$pendek'";
            $this->db->query($sql);

        }
    }
?>