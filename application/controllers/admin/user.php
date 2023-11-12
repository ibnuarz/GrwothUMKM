<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
        $this->load->model('Madmin');
    }

	public function index()
	{
		$this->load->view('admin/login');
	}

    public function adduser(){
        if (!$this->session->userdata('status') == 'login') {
            redirect('admin/admincontroll');
        }
        $data['paket_data'] = $this->Madmin->getAllPaket();
        if ($this->input->post()) {
            $this->form_validation->set_rules('namauser', 'Nama User', 'required');
            $this->form_validation->set_rules('alamatuser', 'Alamat User', 'required');
            $this->form_validation->set_rules('emailuser', 'Email User', 'required|valid_email|is_unique[tb_user.email]', array(
                'is_unique' => 'Email Yang tadi diinput Sudah Terdaftar.'
            ));
            $this->form_validation->set_rules('tlpuser', 'Telepon User', 'required');
            $this->form_validation->set_rules('usernameuser', 'Username User', 'required|is_unique[tb_user.username_user]', array(
                'is_unique' => 'Username Yang tadi diinput Sudah Terdaftar.'
            ));
            $this->form_validation->set_rules('passuser', 'Password User', 'required');
            $this->form_validation->set_rules('tgldaftar', 'Tanggal Daftar', 'required');
            $this->form_validation->set_rules('id_paket', 'Id Paket', 'required');
            if ($this->form_validation->run() == true) {
                $data_user = array(
                    'nama_user' => $this->input->post('namauser'),
                    'alamat_user' => $this->input->post('alamatuser'),
                    'email' => $this->input->post('emailuser'),
                    'telp_user' => $this->input->post('tlpuser'),
                    'username_user' => $this->input->post('usernameuser'),
                    'pass_user' => $this->input->post('passuser'),
                    'tgl_daftar' => $this->input->post('tgldaftar'),
                    'id_paket' => $this->input->post('id_paket')
                );
                $this->Madmin->insertUser($data_user);
                redirect('admin/admincontroll/user');
            } else {
                $data['validation_error'] = validation_errors();
                $data['all_admin'] = $this->Madmin->getAllAdmin();
                $data['paket_data'] = $this->Madmin->getAllPaket();
                $data['user_data'] = $this->Madmin->getAllUser();
                $this->load->view('admin/layout/header', $data);
                $this->load->view('admin/datauser', $data);
                $this->load->view('admin/layout/footer');
            }    
        }
	}
    public function edituser($id) {

    }
    
    public function deleteuser($id){
        if (!$this->session->userdata('status') == 'login') {
            redirect('admincontroll');
        }
        $this->Madmin->deleteUser($id);
        redirect('admin/admincontroll/user');
    }

}






