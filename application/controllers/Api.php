<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mymodel');
    }
    function index()
    {
        header('Content-Type: application/json');
        $userid = $this->input->get('userid');
        if ($userid == '') {
            $link = $this->mymodel->Get('link');
        } else {
            $link = $this->mymodel->GetWhere(
                'link',
                array('userid' => $userid)
            );
        }
        echo json_encode($link);
    }

    function random_strings($length_of_string)
    {

        // String of all alphanumeric character 
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shufle the $str_result and returns substring 
        // of specified length 
        return substr(
            str_shuffle($str_result),
            0,
            $length_of_string
        );
    }

    public function tambah_link()
    {
        header('Content-Type: application/json');
        $this->load->model('mymodel');

        if($this->input->post('pendek')==''|$this->input->post('pendek')==null){
            $data = array(
                'userid' => $this->input->post('userid'),
                'panjang' => $this->input->post('panjang'),
                'pendek' => $this->random_strings(8)
            );
        }else{
            $data = array(
                'userid' => $this->input->post('userid'),
                'panjang' => $this->input->post('panjang'),
                'pendek' => $this->input->post('pendek')
            );
        }
        
        $query = $this->mymodel->Insert('link', $data);

        if ($query) {
            $hasil = array('status' => 'Berhasil tambah link');
        } else {
            $hasil = array('status' => 'Gagal tambah link');
        }
        echo json_encode($hasil);
    }

    function update_link()
    {
        header('Content-Type: application/json');
        $where = array(
            'linkid' => $this->input->post('linkid')
        );

        if($this->input->post('pendek')==''|$this->input->post('pendek')==null){
            $data = array(
                'pendek' => $this->random_strings(8)
            );
        }else{
            $data = array(
                'pendek' => $this->input->post('pendek')
            );
        }

        $query = $this->mymodel->Update('link', $data, $where);

        if ($query) {
            $hasil = array('status' => 'Berhasil edit link');
        } else {
            $hasil = array('status' => 'Gagal edit link');
        }
        echo json_encode($hasil);
    }

    function hapus_link($linkid)
    {
        header('Content-Type: application/json');
        $where = array('linkid' => $linkid);
        $query = $this->mymodel->Delete('link', $where);
        if ($query) {
            $hasil = array('status' => 'Berhasil menghapus link');
        } else {
            $hasil = array('status' => 'Gagal menghapus link');
        }
        echo json_encode($hasil);
    }
}
