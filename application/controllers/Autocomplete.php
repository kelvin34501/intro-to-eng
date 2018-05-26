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
}
