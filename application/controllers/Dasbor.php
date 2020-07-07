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

    public function cek_pendek()
    {
        $this->load->model('mymodel');

        if ($this->input->post('pendek') == "") {
            //echo "kosong";
            return;
        }

        if ($this->input->post('pendek') == $this->input->post('ori_pendek')) {
            //echo "kosong";
            return;
        }

        $data = array('pendek' => $this->input->post('pendek'));
        $cek = $this->mymodel->GetWhere('link', $data);
        if (count($cek) > 0) {
            echo '<span class="text-danger">Tidak tersedia</span>';
        } else {
            echo '<span class="text-success">Tersedia</span>';
        }
    }

    public function edit_link($pendek)
    {
        $this->load->model('mymodel');
        $where = array("userid" => $this->session->userdata('userid'), "pendek" => $pendek);
        $link = $this->mymodel->GetWhere("link", $where);

        $data = array(
            'link' => $link[0]
        );
        $this->load->view('dasbor/edit_link', $data);
    }

    public function hapus_link($pendek)
    {
        $this->load->model('mymodel');
        $where = array("pendek" => $pendek);
        $query = $this->mymodel->Delete('link', $where);

        if ($query) {
            echo "<script>alert('Hapus sukses')</script>";
        } else {
            echo "<script>alert('Hapus gagal')</script>";
        }
        echo '<script>window.location = "' . base_url("dasbor") . '";</script>';
    }

    public function add_link()
    {
        $pendek = $this->input->post('pendek');

        if ($pendek == "" | $pendek == null) {
            $data = array(
                'pendek' => $this->random_strings(8),
                'panjang' => $this->input->post('panjang'),
                'userid' => $this->session->userdata('userid'),
            );
        }else{
            $data = array(
                'pendek' => $this->input->post('pendek'),
                'panjang' => $this->input->post('panjang'),
                'userid' => $this->session->userdata('userid'),
            );
        }

        $query = $this->mymodel->Insert('link', $data);
        if ($query) {
            echo "<script>alert('Tambah link sukses')</script>";
        } else {
            echo "<script>alert('Tambah link gagal')</script>";
        }
        echo "<script>window.location.href = '" . base_url("dasbor") . "';</script>";
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

    public function proses_update_link()
    {
        $pendek = $this->input->post('pendek');

        $ori_pendek = $this->input->post('ori_pendek');

        $where = array('pendek'=>$ori_pendek);

        if ($pendek == "" | $pendek == null) {
            $data = array(
                'pendek' => $this->random_strings(8),
                'panjang' => $this->input->post('panjang'),
                'userid' => $this->session->userdata('userid'),
            );
        }else{
            $data = array(
                'pendek' => $this->input->post('pendek'),
                'panjang' => $this->input->post('panjang'),
                'userid' => $this->session->userdata('userid'),
            );
        }

        $query = $this->mymodel->Update('link', $data, $where);
        if ($query) {
            echo "<script>alert('Update link sukses')</script>";
        } else {
            echo "<script>alert('Update link gagal')</script>";
        }
        echo "<script>window.location.href = '" . base_url("dasbor") . "';</script>";
    }
    
}
