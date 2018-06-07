<?php
class Visual extends CI_controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Lab_model');
        $this->load->helper('url');
    }

    public function author_visual_json() {
        $author_id = $this->input->get('author_id');
        $author_item = $this->Lab_model->get_author($author_id);
        $author_cooperation = $this->Lab_model->get_cooperation($author_id);
        $res = array();
        $res["nodes"][] = array("id"=> $author_id, "group"=>0);
        $res["links"][] = array("source"=> $author_id, "target"=>$author_id, "value"=>1);

        // process the cooperators of the author
        foreach($author_cooperation as $next_author) {
            $second_id = $next_author['SecondID'];
            $res["links"][] = array("source"=>$author_id, "target"=>$second_id, "value"=>2);
            $rela = $this->Lab_model->get_relationship($author_id, $second_id);
            $rev_rela = $this->Lab_model->get_relationship($second_id, $author_id);
            if ($rela == 0 && $rev_rela == 0) {
                $res["nodes"][] = array("id"=> $second_id, "group"=>1);
            } else if ($rela == 1 && $rev_rela == 0) {
                $res["nodes"][] = array("id"=> $second_id, "group"=>2);
            } else if ($rela == 0 && $rev_rela == 1) {
                $res["nodes"][] = array("id"=> $second_id, "group"=>3);
            } else {
                $res["nodes"][] = array("id"=> $second_id, "group"=>4);
            }
        }

        //process the interseections
        $len = count($author_cooperation);
        for ($i = 0; $i < $len - 1; $i++) {
            for ($j = $i + 1; $j < $len; $j++) {
                if ($this->Lab_model->is_cooperated($author_cooperation[$i]['SecondID'],
                                                    $author_cooperation[$j]['SecondID'])) {
                    $res["links"][] = array("source"=>$author_cooperation[$i]['SecondID'],
                                            "target"=>$author_cooperation[$j]['SecondID'],
                                            "value"=>1);
                }
            }
        }
        echo json_encode($res);
    }
}