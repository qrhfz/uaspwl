<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dasbor extends CI_Controller
{


    public function index()
    {
        $this->load->model('mymodel');
        $where = array("userid" => $this->session->userdata('userid'));
        $links = $this->mymodel->GetWhere("link", $where);
        $linkcount = $this->mymodel->CountLink($this->session->userdata('userid'));
        $clicksum = $this->mymodel->sumClick($this->session->userdata('userid'));
        $data = array(
            'links' => $links,
            'linkcnt' => $linkcount,
            'clicksum' => $clicksum
        );
        $this->load->view('dasbor/index', $data);
    }

    public function user_settings()
    {
        $this->load->model('mymodel');
        $where = array("userid" => $this->session->userdata('userid'));
        $user = $this->mymodel->GetWhere("user", $where);
        $data = array(
            'user' => $user[0]
        );
        $this->load->view('dasbor/user_settings', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function update_user()
    {
        $this->load->model('mymodel');
        $where = array("userid" => $this->session->userdata('userid'));
        if ($this->input->post('password')) {
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password')),
            );
        } else {
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
            );
        }
        $query = $this->mymodel->Update('user', $data, $where);

        if ($query) {
            echo "<script>alert('Update sukses')</script>";
            
        } else {
            echo "<script>alert('Update gagal')</script>";
        }
        echo "<script>window.location.href = '" . base_url("dasbor/user_settings") . "';</script>";
    }

    public function hapus_user()
    {
        $this->load->model('mymodel');
        $where = array("userid" => $this->session->userdata('userid'));
        $query = $this->mymodel->Delete('user', $where);

        if ($query) {
            echo "<script>alert('Hapus sukses')</script>";
            
        } else {
            echo "<script>alert('Hapus gagal')</script>";
        }
        $this->logout();
    }
}
