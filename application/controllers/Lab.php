<?php
class Lab extends CI_controller {
    private $res_per_page = 12;
    private $page_per_bar = 10;
    private $pub_per_page = 10;

    private function _gen_page_ind($p, $a, $b) {
        //return an array with page number and status
        $res = array();
        $m = $p - floor($this->page_per_bar/2);
        $begin = ( $m > 0 ) ? $m : 1;

        if( $p <= floor($this->page_per_bar/2) ) {
            if( $b >= $this->page_per_bar )
                $end = $this->page_per_bar;
            else
                $end = $b;
        } else {
            $n = $p + floor($this->page_per_bar/2) - 1;
            $end = ( $n <= $b ) ? $n : $b;
        }

        for($i=$begin; $i<=$end; $i++) {
            if($i != $p)
                $res[] = array('number'=>$i, 'status'=>'', 'active'=>'');
            else
                $res[] = array('number'=>$i, 'status'=>'active', 'active'=>'');
        }
        return $res;
    }

    private function _gen_page_backward($p, $a, $b) {
        $res = array();
        if($p == $a) {
            $res['number'] = $p;
            $res['status'] = '';
            $res['active'] = 'disabled';
        } else {
            $res['number'] = $p - 1;
            $res['status'] = '';
            $res['active'] = '';
        }
        return $res;
    }

    private function _gen_page_forward($p, $a, $b) {
        $res = array();
        if($p == $b) {
            $res['number'] = $p;
            $res['status'] = '';
            $res['active'] = 'disabled';
        } else {
            $res['number'] = $p + 1;
            $res['status'] = '';
            $res['active'] = '';
        }
        return $res;
    }

    private function _fill_pagenum($page, $total, &$data) {
        // pass data by reference
        if($page===null || $page <= 0)
            $page = 1;
        $pagenum = ($page - 1) * $this->res_per_page;
        $startpage = 1;
        $endpage = $total;

        $data['page'] = $page;
        $data['startpage'] = $startpage;
        $data['endpage'] = $endpage;
    }

    public function __construct() {
        parent::__construct();
        $this->load->model('Lab_model');
        $this->load->helper('url');
    }

    public function index() {
        $data['title'] = 'Home';
        $data['result_handler'] = base_url().'lab/index';
        $data['auto_completer'] = base_url().'autocomplete/search_author';

        $field = $this->input->get('author_name');

        if(!$field) {
            $this->load->view('templates/header',$data);
            $this->load->view('lab/form',$data);
            $this->load->view('templates/footer');

        } else {
            //$this->load->library('javascript/jquery');I don't know how to pass GET information between methods
            //So I redirect it...
            redirect(base_url().'lab/result?author_name='.$field);
        }
    }

    public function navi_bar() {
        $navi_handle = $this->input->get('handle');
        $page = $this->input->get('page');
        $startpage = $this->input->get('startpage');
        $endpage = $this->input->get('endpage');
        $pageforward = $this->_gen_page_forward($page,  $startpage, $endpage);
        $pagebackward = $this->_gen_page_backward($page, $startpage, $endpage);
        $pageindex = $this->_gen_page_ind($page, $startpage, $endpage);

        $data['navi_handle'] = $navi_handle;

        $data['page'] = $page;
        $data['startpage'] = $startpage;
        $data['endpage'] = $endpage;
        $data['pageforward'] = $pageforward;
        $data['pagebackward'] = $pagebackward;
        $data['pageindex'] = $pageindex;

        echo $this->load->view('shared/navi.bar.php', $data, true);
    }

    public function result() {
        $data['navi_handle'] = "result"; // navi bar id
        $data['content_handle'] = "result_table"; // the method name
        $data['fieldname'] = "author_name";

        //get request in url
        $field = $this->input->get('author_name');
        $page = $this->input->get('page');

        //get data through model
        $data['title'] = "QueryResult";
        $data['field'] = $field;
        $retrieve = $this->Lab_model->search_author($field);

        //process the page numbers
        $this->_fill_pagenum($page,
                             ceil(count($retrieve)/$this->res_per_page),
                             $data);

        $this->load->view('templates/header', $data);
        $this->load->view('lab/result', $data);
        $this->load->view('templates/footer');
    }

    public function result_table() {
        $field = $this->input->get('author_name');
        $retrieve = $this->Lab_model->search_author($field);

        $page = $this->input->get('page');
        if($page===null || $page <= 0)
            $page = 1;
        $pagenum = ($page - 1) * $this->res_per_page;

        //slice the retrieve
        $retrieve = array_slice($retrieve, $pagenum, $this->res_per_page);

        foreach($retrieve as $index => $content) {
            $q = $this->Lab_model->get_most_freq_affi($content['AuthorID']);
            $retrieve[$index]['AffiliationID'] = $q['AffiliationID'];
            $retrieve[$index]['AffiliationName'] = $q['AffiliationName'];
        }

        $data['query_result'] = $retrieve;
        echo $this->load->view('lab/result.table.php', $data, true);
    }

    public function author() {
        $data['navi_handle'] = "author"; // navi bar id
        $data['content_handle'] = "author_table"; // the method name
        $data['visual_handler'] = "author_visual_json";
        $data['fieldname'] = "author_id";

        $author_id = $this->input->get('author_id');
        $data['field'] = $author_id;
        $data['author_item'] = $this->Lab_model->get_author($author_id);
        $retrieve = $this->Lab_model->get_author_pub($author_id);
        $data['author_affi'] = $this->Lab_model->get_most_freq_affi($author_id)['AffiliationName'];

        // process pages
        $page = $this->input->get('page');
        $this->_fill_pagenum($page,
                             ceil(count($retrieve)/$this->pub_per_page),
                             $data);

        $data['title'] = 'Author';

        $this->load->view('templates/header', $data);
        $this->load->view('lab/view', $data);
        $this->load->view('templates/footer');
    }

    public function author_table() {
        $author_id = $this->input->get('author_id');
        $data['author_item'] = $this->Lab_model->get_author($author_id);
        $retrieve = $this->Lab_model->get_author_pub($author_id);
        $data['author_affi'] = $this->Lab_model->get_most_freq_affi($author_id)['AffiliationName'];

        $page = $this->input->get('page');
        if($page===null || $page <= 0)
            $page = 1;
        $pagenum = ($page - 1) * $this->pub_per_page;

        //slice the retrieve
        $retrieve = array_slice($retrieve, $pagenum, $this->pub_per_page);
        $data['author_pub'] = $retrieve;

        foreach($data['author_pub'] as $index => $content) {
            $q = $this->Lab_model->get_paper_basic($content['PaperID']);
            $data['author_pub'][$index]['Title'] = $q['Title'];
            $data['author_pub'][$index]['PaperPublishYear'] = $q['PaperPublishYear'];
            $r = $this->Lab_model->get_conference($q['ConferenceID']);
            $data['author_pub'][$index]['ConferenceName'] = $r['ConferenceName'];
            $data['author_pub'][$index]['Links'] = $this->Lab_model->get_paper_links($content['PaperID']);
        }

        echo $this->load->view('lab/view.table.php', $data, true);
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

    public function datatable() {
        $data['author'] = $this->Lab_model->get_all();
        $data['title'] = 'DataTable';

        $this->load->view('templates/header',$data);
        $this->load->view('lab/datatable',$data);
        $this->load->view('templates/footer');
    }

}
