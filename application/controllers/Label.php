<?php
class Label extends CI_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Label_model');
        $this->load->helper('url');
    }

    public function view_paper_label() {
        $paper_id = $this->input->get('field');
        $page = $this->input->get('page');
        if($page===null || $page <= 0)
            $page = 1;
        $pagenum = ($page - 1) * 10;

        $data['query_result'] = $this->Label_model->fetch_paper_label($paper_id, $pagenum, 10)['slice'];
        // var_dump($data['query_result']); die();
        echo $this->load->view('lab/label/label.content.php', $data, true);
    }

    public function view_conf_label() {
        $conf_id = $this->input->get('field');
        $page = $this->input->get('page');
        if($page===null || $page <= 0)
            $page = 1;
        $pagenum = ($page - 1) * 10;

        $data['query_result'] = $this->Label_model->fetch_conf_label($conf_id, $pagenum, 10)['slice'];
        echo $this->load->view('lab/label/label.content.php', $data, true);
    }

    public function view_affi_label() {
        $conf_id = $this->input->get('field');
        $page = $this->input->get('page');
        if($page===null || $page <= 0)
            $page = 1;
        $pagenum = ($page - 1) * 10;

        $data['query_result'] = $this->Label_model->fetch_affi_label($conf_id, $pagenum, 10)['slice'];
        echo $this->load->view('lab/label/label.content.php', $data, true);
    }

    public function view_author_label() {
        $conf_id = $this->input->get('field');
        $page = $this->input->get('page');
        if($page===null || $page <= 0)
            $page = 1;
        $pagenum = ($page - 1) * 5;

        $data['query_result'] = $this->Label_model->fetch_author_label($conf_id, $pagenum, 5)['slice'];
        echo $this->load->view('lab/label/label.content.php', $data, true);
    }
}