<?php

require "Pagin.php";

class Lab extends CI_controller {
    private $res_per_page = 10;

    public function __construct() {
        parent::__construct();
        $this->load->model('Lab_model');
        $this->load->helper('url');
    }

    public function index() {
        $data['title'] = 'Home';
        $data['result_handler'] = base_url().'lab/index';
        $data['auto_completer'] = base_url().'autocomplete/search_author';

        $author = $this->input->get('author');
        $affiliation = $this->input->get('affiliation');
        $conference = $this->input->get('conference');
        $paper = $this->input->get('paper');
        $id = $this->input->get('id');
        if ($author != "") {
            redirect(base_url().'lab/search_author?author='.$author);
        } else if ($affiliation != "") {
            redirect(base_url().'lab/search_affi?affi='.$affiliation);
        } else if ($conference != "") {
            redirect(base_url().'lab/search_conference?conference='.$conference);
        } else if ($paper != "") {
            redirect(base_url().'lab/search_paper?paper='.$paper);
        }
        $this->load->view('templates/header', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/home');
        $this->load->view('templates/footer');
    }

    public function search_author()
    {
        $data['title'] = 'Result';
        $data['display_author'] = true;
        $data['display_affiliation'] = $data['display_conference'] = $data['display_paper'] = false;

        $data['author_name'] = $this->input->get('author');
        $data['total_result'] = $this->Lab_model->get_author_total_number($data['author_name']);
        Pagin::_fill_pagenum(1,
                             ceil($data['total_result'] / $this->res_per_page),
                             $data);
        $data['fieldname'] = 'author'; $data['field'] = $data['author_name'];
        $data['content_handle'] = 'lab-result-author-panel';
        $data['pagin_handle'] = 'lab-result-author-pagination';
        $data['content_fetch_url'] = base_url().'lab/search_author_table?';
        $data['pagin_fetch_url'] = base_url().'pagin/pagin_bar?';

        $this->load->view('templates/header');
        $this->load->view('shared/pagin.savevar.php', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/result.frame.php', $data);
        $this->load->view('templates/footer');
    }

    public function search_author_table()
    {
        $field = $this->input->get('author');

        $page = $this->input->get('page');
        if($page===null || $page <= 0)
            $page = 1;
        $pagenum = ($page - 1) * $this->res_per_page;

        $retrieve = $this->Lab_model->search_author($field, $pagenum, $this->res_per_page);

        foreach($retrieve as $index => $content) {
            $q = $this->Lab_model->get_most_freq_affi($content['AuthorID']);
            $retrieve[$index]['AffiliationID'] = $q['AffiliationID'];
            $retrieve[$index]['AffiliationName'] = $q['AffiliationName'];
        }

        $data['query_result'] = $retrieve;
        $data['offset'] = $pagenum;
        echo $this->load->view('lab/author/author.table.php', $data, true);
    }

    public function search_affi()
    {
        $data['title'] = 'Result';
        $data['display_affiliation'] = true;
        $data['display_author'] = $data['display_conference'] = $data['display_paper'] = false;

        $data['affi_name'] = $this->input->get('affi');
        $data['total_result'] = $this->Lab_model->get_affi_total_number($data['affi_name']);
        Pagin::_fill_pagenum(1,
                             ceil($data['total_result'] / $this->res_per_page),
                             $data);
        $data['fieldname'] = 'affi'; $data['field'] = $data['affi_name'];
        $data['content_handle'] = 'lab-result-affiliation-panel';
        $data['pagin_handle'] = 'lab-result-affiliation-pagination';
        $data['content_fetch_url'] = base_url().'lab/search_affi_table?';
        $data['pagin_fetch_url'] = base_url().'pagin/pagin_bar?';

        $this->load->view('templates/header');
        $this->load->view('shared/pagin.savevar.php', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/result.frame.php', $data);
        $this->load->view('templates/footer');
    }

    public function search_affi_table()
    {
        $field = $this->input->get('affi');

        $page = $this->input->get('page');
        if($page===null || $page <= 0)
            $page = 1;
        $pagenum = ($page - 1) * $this->res_per_page;

        $retrieve = $this->Lab_model->search_affi($field, $pagenum, $this->res_per_page);

        $data['query_result'] = $retrieve;
        $data['offset'] = $pagenum;
        echo $this->load->view('lab/affi/affi.table.php', $data, true);
    }

    public function search_conference()
    {
        $data['title'] = 'Result';
        $data['display_conference'] = true;
        $data['display_author'] = $data['display_affiliation'] = $data['display_paper'] = false;

        $data['conference_name'] = $this->input->get('conference');
        $data['total_result'] = $this->Lab_model->get_conference_total_number($data['conference_name']);
        Pagin::_fill_pagenum(1,
                             ceil($data['total_result'] / $this->res_per_page),
                             $data);
        $data['fieldname'] = 'conference'; $data['field'] = $data['conference_name'];
        $data['content_handle'] = 'lab-result-conference-panel';
        $data['pagin_handle'] = 'lab-result-conference-pagination';
        $data['content_fetch_url'] = base_url().'lab/search_conference_table?';
        $data['pagin_fetch_url'] = base_url().'pagin/pagin_bar?';

        $this->load->view('templates/header');
        $this->load->view('shared/pagin.savevar.php', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/result.frame.php', $data);
        $this->load->view('templates/footer');
    }

    public function search_conference_table()
    {
        $field = $this->input->get('conference');

        $page = $this->input->get('page');
        if($page===null || $page <= 0)
            $page = 1;
        $pagenum = ($page - 1) * $this->res_per_page;

        $retrieve = $this->Lab_model->search_conference($field, $pagenum, $this->res_per_page);

        $data['query_result'] = $retrieve;
        $data['offset'] = $pagenum;
        echo $this->load->view('lab/conference/conference.table.php', $data, true);
    }

    public function search_paper()
    {
        $data['title'] = 'Result';
        $data['display_paper'] = true;
        $data['display_author'] = $data['display_affiliation'] = $data['display_conference'] = false;

        $data['paper_name'] = $this->input->get('paper');
        $data['total_result'] = $this->Lab_model->get_paper_total_number($data['paper_name']);
        Pagin::_fill_pagenum(1,
                             ceil($data['total_result'] / $this->res_per_page),
                             $data);
        $data['fieldname'] = 'paper'; $data['field'] = $data['paper_name'];
        $data['content_handle'] = 'lab-result-paper-panel';
        $data['pagin_handle'] = 'lab-result-paper-pagination';
        $data['content_fetch_url'] = base_url().'lab/search_paper_table?';
        $data['pagin_fetch_url'] = base_url().'pagin/pagin_bar?';

        $this->load->view('templates/header');
        $this->load->view('shared/pagin.savevar.php', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/result.frame.php', $data);
        $this->load->view('templates/footer');
    }

    public function search_paper_table()
    {
        $field = $this->input->get('paper');

        $page = $this->input->get('page');
        if($page===null || $page <= 0)
            $page = 1;
        $pagenum = ($page - 1) * $this->res_per_page;

        $retrieve = $this->Lab_model->search_paper($field, $pagenum, $this->res_per_page);
        foreach($retrieve as $index => $content) {
            $retrieve[$index]['ConferenceName'] = 
                $this->Lab_model->get_conference($content['ConferenceID'])['ConferenceName'];
            $namelist = $this->Lab_model->get_author_of_paper($content['PaperID']);
            $caption = "";
            foreach($namelist as $ind => $name) {
                if (strlen($caption) < 40) {
                    if ($ind == 0) {
                        $caption = $caption.ucwords($name['AuthorName']);
                    } else {
                        $caption = $caption.', '.ucwords($name['AuthorName']);
                    }
                } else {
                    $caption = $caption."...";
                    break;
                }
            }
            $retrieve[$index]['AuthorList'] = $caption;
        }
        
        $data['query_result'] = $retrieve;
        $data['offset'] = $pagenum;
        echo $this->load->view('lab/paper/paper.table.php', $data, true);
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
