<?php
class Autocomplete extends CI_controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Lab_model');
    }

    public function search_author() {
        $field = strtolower($this->input->get('term'));

        $retrieve = $this->Lab_model->search_author($field,10);
        $result=array();
        foreach($retrieve as $row) {
            $result[] = $row['AuthorName'];
        }
        echo json_encode($result);
    }

    public function search_affi() {
        $field = strtolower($this->input->get('term'));

        $retrieve = $this->Lab_model->search_affi($field,10);
        $result=array();
        foreach($retrieve as $row) {
            $result[] = $row['AffiliationName'];
        }
        echo json_encode($result);
    }

    public function search_conference() {
        $field = strtolower($this->input->get('term'));

        $retrieve = $this->Lab_model->search_conference($field,10);
        $result=array();
        foreach($retrieve as $row) {
            $result[] = $row['ConferenceName'];
        }
        echo json_encode($result);
    }

    public function search_paper() {
        $field = strtolower($this->input->get('term'));

        $retrieve = $this->Lab_model->search_paper($field,10);
        $result=array();
        foreach($retrieve as $row) {
            $result[] = $row['Title'];
        }
        echo json_encode($result);
    }
}
