<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends CI_Controller
{


    public function index()
    {
        $this->load->view('landing/index');
    }

    public function login()
    {
        $this->load->view('landing/login');
    }

    public function proses_registrasi()
    {
        $this->load->model('mymodel');
        $data = array(
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password'))
        );
        $query = $this->mymodel->Insert('user', $data);

        if ($query) {
            echo "Proses registrasi sukses";
        } else {
            echo "Proses registrasi gagal'";
            //$this->index();
        }
    }

    public function proses_login()
    {
        $this->load->model('mymodel');
        $where = array(
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password'))
        );

        $cek = $this->mymodel->GetWhere('user', $where);

        $count_cek = count($cek);
        if ($count_cek > 0) {
            $data_session = array(
                'userid' => $cek[0]['userid'],
                'username' => $cek[0]['username'],
                'email' => $cek[0]['email']
            );
            $this->session->set_userdata($data_session);

            echo "<script>alert('Login sukses')</script>";
            echo "<script>window.location.href = '" . base_url("dasbor") . "';</script>";
        } else {
            echo "<script>alert('Login gagal')</script>";
            echo "<script>window.location.href = '" . base_url() . "';</script>";
        }
    }

    public function email_ada()
    {
        $this->load->model('mymodel');
        $email = $this->input->post('email');
        if ($this->mymodel->email_ada_gak($email) > 0) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function redirect($pendek)
    {
        $this->load->model('mymodel');
        $panjang = $this->mymodel->jadi_panjang($pendek);
        $this->mymodel->addClick($pendek);
        redirect($panjang);
    }

}
