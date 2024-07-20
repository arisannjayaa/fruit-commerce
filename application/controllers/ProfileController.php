<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfileController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->service('ProfileService', 'profileService');
		$this->load->model('User');
    }

	/**
	 * menampilkan halaman profile
	 * @return string
	 */
	public function index()
    {
		if (!$this->auth->check()) {
			redirect(base_url('login'));
		}

		$data['user'] = $this->User->find($this->auth->user()->id);

		if ($this->auth->isAdmin()) {
			return view('profile/index', $data);
		}

		if ($this->auth->isMember()) {
			return view('home/settings/bio-settings', $data);
		}
    }

	/**
	 * get data by id
	 * @param $id
	 * @return void
	 */
	public function edit($id)
	{
		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->output->set_status_header(200);
		echo json_encode(array('success' => true, 'code' => 200, 'data' => $this->User->find($id)));
	}

	/**
	 * update data profile
	 * @return void
	 */
	public function update()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("Anda tidak memiliki izin untuk mengakses sumber daya ini.", 403, "Akses Ditolak");
		}

		$this->rules($this->input->post('id'));

		if ($this->input->post('attachment') == null || $this->input->post('attachment') == "") {
			if (empty($_FILES['attachment']['name'])) {
				$this->form_validation->set_rules('attachment', 'Lampiran', 'required', array(
					'required' => '%s tidak boleh kosong.',
				));
			}
		}

		$old_attachment = $this->input->post('old_attachment');

		if ($this->form_validation->run() == FALSE) {
			$this->output->set_status_header(400);
			$errors = $this->form_validation->error_array();

			$errorObj = [];
			foreach ($errors as $key => $value) {
				$errorObj[$key] = [[$value]];
			}

			echo json_encode(array('errors' => $errorObj));
			return;
		}

		if (@$_FILES['attachment']['name']) {
			$path = 'uploads/profile/';

			if (!is_dir($path)) {
				mkdir($path, 0777, TRUE);
			}

			$config['upload_path'] 		= './'.$path;
			$config['allowed_types'] 	= 'jpg|jpeg|png';
			$config['max_filename']	 	= '255';
			$config['encrypt_name'] 	= TRUE;
			$config['max_size'] 		= 2024;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload("attachment")) {
				$this->output->set_status_header(400);

				echo json_encode(array('attachment' => "Terjadi error saat upload file"));
				return;
			}

			$file_data 	= $this->upload->data();
			$file_name 	= $path.$file_data['file_name'];
			$arr_file 	= explode('.', $file_name);
			$extension 	= end($arr_file);

			if(file_exists('./' . $old_attachment)) {
				unlink('./'.$old_attachment);
			}
		} else {
			$file_name = $old_attachment;
		}

		$data = array(
			'id' => $this->input->post('id'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email' => $this->input->post('email'),
			'telephone' => $this->input->post('telephone'),
			'attachment' => $file_name,
		);

		return $this->profileService->update($data);
	}

	/**
	 * rules validasi
	 * @param $id
	 * @return void
	 */
	public function rules($id = null)
	{
		$rules = array(
			'first_name' => $id == null ? 'required|is_unique[users.first_name]' : 'required',
			'last_name' => $id == null ? 'required|is_unique[users.last_name]' : 'required',
			'email' => $id == null ? 'required|is_unique[users.email]' : 'required',
			'telephone' => $id == null ? 'required|is_unique[users.telephone]' : 'required'
		);

		$this->form_validation->set_rules('first_name', 'Nama Awal', $rules['first_name'], array(
			'required' => '%s tidak boleh kosong',
			'is_unique' => '%s harus berisi nilai unik',
		));
		$this->form_validation->set_rules('last_name', 'Nama Akhir', $rules['last_name'], array(
			'required' => '%s tidak boleh kosong',
			'is_unique' => '%s harus berisi nilai unik',
		));
		$this->form_validation->set_rules('email', 'Email', $rules['email'], array(
			'required' => '%s tidak boleh kosong',
			'is_unique' => '%s harus berisi nilai unik',
		));
		$this->form_validation->set_rules('telephone', 'Telepon', $rules['telephone'] .'|numeric', array(
			'required' => '%s tidak boleh kosong',
			'numeric' => '%s harus berupa angka',
			'is_unique' => '%s harus berisi nilai unik',
		));
	}
}

/* End of file DashboardController.php and path \application\controllers\DashboardController.php */
