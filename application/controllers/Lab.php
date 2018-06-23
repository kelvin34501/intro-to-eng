<?php

require "Pagin.php";

class Lab extends CI_controller {
    private $res_per_page = 10;

    public function __construct() {
        parent::__construct();
        $this->load->model('Lab_model');
        $this->load->model('Label_model');
        $this->load->helper('url');
        $this->load->helper('cookie');
    }

    public function index() {
        $data['title'] = 'Home';
        $data['result_handler'] = base_url().'lab/index';

        $author = $this->input->get('author');
        $affiliation = $this->input->get('affiliation');
        $conference = $this->input->get('conference');
        $paper = $this->input->get('paper');
        $id = $this->input->get('id');
        delete_cookie('query_url');
        if ($author != "") {
            set_cookie(
                'query_url', base_url().'lab/search_author?author='.$author, 65536
            );
            redirect(base_url().'lab/search_author?author='.$author);
        } else if ($affiliation != "") {
            set_cookie(
                'query_url', base_url().'lab/search_affi?affi='.$affiliation, 65536
            );
            redirect(base_url().'lab/search_affi?affi='.$affiliation);
        } else if ($conference != "") {
            set_cookie(
                'query_url', base_url().'lab/search_conference?conference='.$conference, 65536
            );
            redirect(base_url().'lab/search_conference?conference='.$conference);
        } else if ($paper != "") {
            set_cookie(
                'query_url', base_url().'lab/search_paper?paper='.$paper, 65536
            );
            redirect(base_url().'lab/search_paper?paper='.$paper);
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('shared/navibar.topfix.php', $data);
            $this->load->view('lab/home');
            $this->load->view('templates/footer');
        }
    }
	
    public function search_author()
    {
        $data['title'] = 'Result Page';
        $data['display_author'] = true;
        $data['display_affiliation'] = $data['display_conference'] = $data['display_paper'] = false;

		$data['author_name'] = $this->input->get('author');
        $data['total_result'] = $this->Lab_model->get_author_total_number($data['author_name']);
        Pagin::_fill_pagenum(1,
                             ceil($data['total_result'] / $this->res_per_page),
                             $data);
        $data['fieldname'] = 'field'; $data['field'] = $data['author_name'];
        $data['content_handle'] = 'lab-result-author-panel';
        $data['pagin_handle'] = 'lab-result-author-pagination';
        $data['content_fetch_url'] = base_url().'lab/search_author_table?';
        $data['pagin_fetch_url'] = base_url().'pagin/pagin_bar?';

        $this->load->view('templates/header', $data);
        $this->load->view('shared/pagin.savevar.php', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/result.frame.php', $data);
        $this->load->view('templates/footer');
    }

    public function search_author_table()
    {
        $field = $this->input->get('field');

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
        $data['title'] = 'Result Page';
        $data['display_affiliation'] = true;
        $data['display_author'] = $data['display_conference'] = $data['display_paper'] = false;

		$data['affi_name'] = $this->input->get('affi');
        $data['total_result'] = $this->Lab_model->get_affi_total_number($data['affi_name']);
        Pagin::_fill_pagenum(1,
                             ceil($data['total_result'] / $this->res_per_page),
                             $data);
        $data['fieldname'] = 'field'; $data['field'] = $data['affi_name'];
        $data['content_handle'] = 'lab-result-affiliation-panel';
        $data['pagin_handle'] = 'lab-result-affiliation-pagination';
        $data['content_fetch_url'] = base_url().'lab/search_affi_table?';
        $data['pagin_fetch_url'] = base_url().'pagin/pagin_bar?';

        $this->load->view('templates/header', $data);
        $this->load->view('shared/pagin.savevar.php', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/result.frame.php', $data);
        $this->load->view('templates/footer');
    }

    public function search_affi_table()
    {
        $field = $this->input->get('field');

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
        $data['title'] = 'Result Page';
        $data['display_conference'] = true;
        $data['display_author'] = $data['display_affiliation'] = $data['display_paper'] = false;

		$data['conference_name'] = $this->input->get('conference');
        $data['total_result'] = $this->Lab_model->get_conference_total_number($data['conference_name']);
        Pagin::_fill_pagenum(1,
                             ceil($data['total_result'] / $this->res_per_page),
                             $data);
        $data['fieldname'] = 'field'; $data['field'] = $data['conference_name'];
        $data['content_handle'] = 'lab-result-conference-panel';
        $data['pagin_handle'] = 'lab-result-conference-pagination';
        $data['content_fetch_url'] = base_url().'lab/search_conference_table?';
        $data['pagin_fetch_url'] = base_url().'pagin/pagin_bar?';

        $this->load->view('templates/header', $data);
        $this->load->view('shared/pagin.savevar.php', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/result.frame.php', $data);
        $this->load->view('templates/footer');
    }

    public function search_conference_table()
    {
        $field = $this->input->get('field');

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
        $data['title'] = 'Result Page';
        $data['display_paper'] = true;
        $data['display_author'] = $data['display_affiliation'] = $data['display_conference'] = false;

		$data['paper_name'] = $this->input->get('paper');
		$data['total_result'] = $this->Lab_model->get_paper_total_number($data['paper_name']);
        Pagin::_fill_pagenum(1,
                             ceil($data['total_result'] / $this->res_per_page),
                             $data);
        $data['fieldname'] = 'field'; $data['field'] = $data['paper_name'];
        $data['content_handle'] = 'lab-result-paper-panel';
        $data['pagin_handle'] = 'lab-result-paper-pagination';
        $data['content_fetch_url'] = base_url().'lab/search_paper_table?';
        $data['pagin_fetch_url'] = base_url().'pagin/pagin_bar?';

        $this->load->view('templates/header', $data);
        $this->load->view('shared/pagin.savevar.php', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/result.frame.php', $data);
        $this->load->view('templates/footer');
    }

    public function search_paper_table()
    {
        $field = $this->input->get('field');

        $page = $this->input->get('page');
        if($page===null || $page <= 0)
            $page = 1;
        $pagenum = ($page - 1) * $this->res_per_page;

        $retrieve = $this->Lab_model->search_paper($field, $pagenum, $this->res_per_page);
        foreach($retrieve as $index => $content) {
            $retrieve[$index]['ConferenceName'] = 
                $this->Lab_model->get_conference($content['ConferenceID'])['ConferenceName'];
            $namelist = $this->Lab_model->search_author_of_paper($content['PaperID']);
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
        $data['AuthorListType'] = "text";
        $data['NeedConference'] = true;
        echo $this->load->view('lab/paper/paper.table.php', $data, true);
    }

    private function _makeup_dyn_pagin(
        $prefix, $mode, $field, $total, $nitem, $width,
        $c_hdl, $p_hdl, $c_url, $p_url,
        &$data)
    {
        $data['prefix'] = $prefix;
        $data['field'] = array(
            "mode" => $mode,
            "field" => $field);
        $data['total_result'] = $total;
        Pagin::_fill_pagenum(1,
            ceil($total / $nitem),
            $data);
        $data['width'] = $width;
        $data['content_handle'] = $c_hdl;
        $data['pagin_handle'] = $p_hdl;
        $data['content_fetch_url'] = $c_url;
        $data['pagin_fetch_url'] = $p_url;

        $this->load->view('multi_pagin/dyn_pagin_savevar.php', $data);
        $this->load->view('multi_pagin/dyn_pagin.php', $data);
    }

    public function view_author()
    {
        $data['title'] = "Author Page";
        $data['author_id'] = $this->input->get('author_id');
        $data['author_name'] = $this->Lab_model->get_author($data['author_id'])['AuthorName'];
        $data['item_url'] = get_cookie('query_url');
        
        $this->load->view('templates/header', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/author/author.frame.php', $data);

        // dyn pagin loading
        $this->_makeup_dyn_pagin("main", "author_pub", $data['author_id'],
            $this->Lab_model->get_author_pub_total_number($data['author_id']),
            $this->res_per_page, 10,
            "lab-author-main-panel" ,"lab-author-main-pagination",
            base_url()."lab/view_author_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->_makeup_dyn_pagin("affi", "author_affi", $data['author_id'],
            $this->Lab_model->get_author_affi_total_number($data['author_id']), 5, 5,
            "lab-author-sidebar-af-items", "lab-author-sidebar-af-pagination",
            base_url()."lab/view_author_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->_makeup_dyn_pagin("conf", "author_conf", $data['author_id'],
            $this->Lab_model->get_author_conf_total_number($data['author_id']), 5, 5,
            "lab-author-sidebar-cf-items", "lab-author-sidebar-cf-pagination",
            base_url()."lab/view_author_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->_makeup_dyn_pagin("coau", "author_coau", $data['author_id'],
            $this->Lab_model->get_author_coau_total_number($data['author_id']), 5, 5,
            "lab-author-sidebar-ca-items", "lab-author-sidebar-ca-pagination",
            base_url()."lab/view_author_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $lbl_count = $this->Label_model->fetch_author_label($data['author_id'],0,0)['num'];
        $this->_makeup_dyn_pagin("labl", "auth_labl", $data['author_id'],
            $lbl_count, 5, 5,
            "lab-author-sidebar-lb-items", "lab-author-sidebar-lb-pagination",
            base_url()."label/view_author_label?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->load->view('templates/footer');
    }

    public function view_author_content()
    {
        $mode = $this->input->get('mode');
        $author_id = $this->input->get('field');
        if ($mode == "author_pub") {
            $page = $this->input->get('page');
            if($page===null || $page <= 0)
                $page = 1;
            $pagenum = ($page - 1) * $this->res_per_page;
    
            $retrieve = $this->Lab_model->search_paper_of_author($author_id, $pagenum, $this->res_per_page);
            foreach($retrieve as $index => $content) {
                $retrieve[$index]['ConferenceName'] = 
                    $this->Lab_model->get_conference($content['ConferenceID'])['ConferenceName'];
                $retrieve[$index]['AuthorList'] = $this->Lab_model->search_author_of_paper($content['PaperID']);
            }
            
            $data['query_result'] = $retrieve;
            $data['offset'] = $pagenum;
            $data['AuthorListType'] = "link";
            $data['NeedConference'] = true;
            echo $this->load->view('lab/paper/paper.table.php', $data, true);
        } else if ($mode == "author_affi") {
            $page = $this->input->get('page');
            if($page===null || $page <= 0)
                $page = 1;
            $pagenum = ($page - 1) * 5;
    
            $retrieve = $this->Lab_model->search_affi_of_author(
                $author_id, $pagenum, 5);
            $data['query_result'] = $retrieve;
            $data['offset'] = $pagenum;
            echo $this->load->view('lab/affi/affi.content.php', $data, true);
        } else if ($mode == "author_conf") {
            $page = $this->input->get('page');
            if($page===null || $page <= 0)
                $page = 1;
            $pagenum = ($page - 1) * 5;
    
            $retrieve = $this->Lab_model->search_conf_of_author(
                $author_id, $pagenum, 5);
            $data['query_result'] = $retrieve;
            $data['offset'] = $pagenum;
            echo $this->load->view('lab/conference/conference.content.php', $data, true);
        } else if ($mode == "author_coau") {
            $page = $this->input->get('page');
            if($page===null || $page <= 0)
                $page = 1;
            $pagenum = ($page - 1) * 5;
    
            $retrieve = $this->Lab_model->search_coau_of_author(
                $author_id, $pagenum, 5);
            $data['query_result'] = $retrieve;
            $data['offset'] = $pagenum;
            echo $this->load->view('lab/author/coauthor.content.php', $data, true);
        }
    }

    public function view_affi()
    {
        $data['title'] = "Affiliation Page";
        $data['affiliation_id'] = $this->input->get('affi_id');
        $data['affiliation_name'] = 
            $this->Lab_model->get_affi($data['affiliation_id'])['AffiliationName'];
        $data['item_url'] = get_cookie('query_url');
        
        $this->load->view('templates/header', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/affi/affi.frame.php', $data);

        // dyn pagin loading
        $this->_makeup_dyn_pagin("main", "affi_auth", $data['affiliation_id'],
            $this->Lab_model->get_affi_auth_total_number($data['affiliation_id']),
            $this->res_per_page, 10,
            "lab-affiliation-main-panel" ,"lab-affiliation-main-pagination",
            base_url()."lab/view_affi_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->_makeup_dyn_pagin("paper", "affi_paper", $data['affiliation_id'],
            $this->Lab_model->get_affi_paper_total_number($data['affiliation_id']), 10, 5,
            "lab-affiliation-sidebar-pp-items", "lab-affiliation-sidebar-pp-pagination",
            base_url()."lab/view_affi_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $lbl_count = $this->Label_model->fetch_affi_label($data['affiliation_id'],0,0)['num'];
        $this->_makeup_dyn_pagin("labl", "affi_labl", $data['affiliation_id'],
            $lbl_count, 10, 5,
            "lab-affiliation-sidebar-lb-items", "lab-affiliation-sidebar-lb-pagination",
            base_url()."label/view_affi_label?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->load->view('templates/footer');
    }

    public function view_affi_content()
    {
        $mode = $this->input->get('mode');
        $affi_id = $this->input->get('field');
        if ($mode == "affi_auth") {
            $page = $this->input->get('page');
            if($page===null || $page <= 0)
                $page = 1;
            $pagenum = ($page - 1) * $this->res_per_page;
    
            $retrieve = $this->Lab_model->search_author_of_affi($affi_id, $pagenum, $this->res_per_page);
            foreach($retrieve as $index => $content) {
                $q = $this->Lab_model->get_most_freq_affi($content['AuthorID']);
                $retrieve[$index]['AffiliationID'] = $q['AffiliationID'];
                $retrieve[$index]['AffiliationName'] = $q['AffiliationName'];
            }
            $data['query_result'] = $retrieve;
            $data['offset'] = $pagenum;
            echo $this->load->view('lab/author/author.table.php', $data, true);
        } else if ($mode == "affi_paper") {
            $page = $this->input->get('page');
            if($page===null || $page <= 0)
                $page = 1;
            $pagenum = ($page - 1) * 10;
    
            $retrieve = $this->Lab_model->search_paper_of_affi(
                $affi_id, $pagenum, 10);
            $data['query_result'] = $retrieve;
            $data['offset'] = $pagenum;
            echo $this->load->view('lab/paper/paper.content.php', $data, true);
        }
    }

    public function view_conf()
    {
        $data['title'] = "Conference Page";
        $data['conference_id'] = $this->input->get('conf_id');
        $data['conference_name'] = 
            $this->Lab_model->get_conference($data['conference_id'])['ConferenceName'];
        $data['item_url'] = get_cookie('query_url');
        
        $this->load->view('templates/header', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/conference/conference.frame.php', $data);

        // dyn pagin loading
        $this->_makeup_dyn_pagin("main", "conf_paper", $data['conference_id'],
            $this->Lab_model->get_conf_paper_total_number($data['conference_id']),
            $this->res_per_page, 10,
            "lab-conference-main-panel" ,"lab-conference-main-pagination",
            base_url()."lab/view_conf_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->_makeup_dyn_pagin("auth", "conf_auth", $data['conference_id'],
            $this->Lab_model->get_conf_auth_total_number($data['conference_id']), 10, 5,
            "lab-conference-sidebar-au-items", "lab-conference-sidebar-au-pagination",
            base_url()."lab/view_conf_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $lbl_count = $this->Label_model->fetch_conf_label($data['conference_id'],0,0)['num'];
        $this->_makeup_dyn_pagin("labl", "conf_labl", $data['conference_id'],
            $lbl_count, 10, 5,
            "lab-conference-sidebar-lb-items", "lab-conference-sidebar-lb-pagination",
            base_url()."label/view_conf_label?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->load->view('templates/footer');
    }

    public function view_conf_content()
    {
        $mode = $this->input->get('mode');
        $affi_id = $this->input->get('field');
        if ($mode == "conf_paper") {
            $page = $this->input->get('page');
            if($page===null || $page <= 0)
                $page = 1;
            $pagenum = ($page - 1) * $this->res_per_page;
    
            $retrieve = $this->Lab_model->search_paper_of_conf($affi_id, $pagenum, $this->res_per_page);
            foreach($retrieve as $index => $content) {
                $retrieve[$index]['AuthorList'] = $this->Lab_model->search_author_of_paper($content['PaperID']);
            }
            $data['query_result'] = $retrieve;
            $data['offset'] = $pagenum;
            $data['AuthorListType'] = "link";
            $data['NeedConference'] = false;
            echo $this->load->view('lab/paper/paper.table.php', $data, true);
        } else if ($mode == "conf_auth") {
            $page = $this->input->get('page');
            if($page===null || $page <= 0)
                $page = 1;
            $pagenum = ($page - 1) * 10;
    
            $retrieve = $this->Lab_model->search_author_of_conf(
                $affi_id, $pagenum, 10);
            $data['query_result'] = $retrieve;
            $data['offset'] = $pagenum;
            echo $this->load->view('lab/author/author.content.php', $data, true);
        }
    }

    public function view_paper()
    {
        $data['title'] = "Paper Page";
        $data['paper_id'] = $this->input->get('paper_id');
        $paper_item = $this->Lab_model->get_paper($data['paper_id']);
        $data['paper_title'] = $paper_item['Title'];
        $data['published_year'] = $paper_item['PaperPublishYear'];
        $data['times_cited'] = $this->Lab_model->get_paper_cite_total_number($data['paper_id']);
        $data['total_references'] = $this->Lab_model->get_paper_ref_total_number($data['paper_id']);
        $data['venue'] = 
            $this->Lab_model->get_conference($paper_item['ConferenceID'])['ConferenceName'];
        $data['venue_id'] = $paper_item['ConferenceID'];

        $data['item_url'] = get_cookie('query_url');
        $this->load->view('templates/header', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/paper/paper.frame.php', $data);

        // dyn pagin loading
        $this->_makeup_dyn_pagin("ref", "paper_ref", $data['paper_id'],
            $this->Lab_model->get_paper_ref_total_number($data['paper_id']),
            $this->res_per_page, 10,
            "lab-paper-reference-items" ,"lab-paper-reference-pagination",
            base_url()."lab/view_paper_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->_makeup_dyn_pagin("cite", "paper_cite", $data['paper_id'],
            $this->Lab_model->get_paper_cite_total_number($data['paper_id']), 10, 5,
            "lab-paper-citedby-items", "lab-paper-citedby-pagination",
            base_url()."lab/view_paper_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->_makeup_dyn_pagin("coau", "paper_coau", $data['paper_id'],
            $this->Lab_model->get_paper_author_total_number($data['paper_id']), 10, 5,
            "lab-paper-panel-ca-items", "lab-paper-panel-ca-pagination",
            base_url()."lab/view_paper_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $lbl_count = $this->Label_model->fetch_paper_label($data['paper_id'],0,0)['num'];
        $this->_makeup_dyn_pagin("labl", "paper_labl", $data['paper_id'],
            $lbl_count, 10, 5,
            "lab-paper-sidebar-lb-items", "lab-paper-sidebar-lb-pagination",
            base_url()."label/view_paper_label?", 
            base_url()."pagin/pagin_bar?", $data
        );

        $this->load->view('templates/footer');
    }

    public function view_paper_content()
    {
        $mode = $this->input->get('mode');
        $paper_id = $this->input->get('field');
        if ($mode == "paper_ref") {
            $page = $this->input->get('page');
            if($page===null || $page <= 0)
                $page = 1;
            $pagenum = ($page - 1) * $this->res_per_page;
    
            $retrieve = $this->Lab_model->search_ref_of_paper($paper_id, $pagenum, $this->res_per_page);
            foreach($retrieve as $index => $content) {
                $retrieve[$index]['AuthorList'] = $this->Lab_model->search_author_of_paper($content['PaperID']);
            }
            $data['query_result'] = $retrieve;
            $data['offset'] = $pagenum;
            $data['AuthorListType'] = "link";
            $data['NeedConference'] = false;
            echo $this->load->view('lab/paper/paper.table.php', $data, true);
        } else if ($mode == "paper_cite") {
            $page = $this->input->get('page');
            if($page===null || $page <= 0)
                $page = 1;
            $pagenum = ($page - 1) * $this->res_per_page;
    
            $retrieve = $this->Lab_model->search_cite_of_paper($paper_id, $pagenum, $this->res_per_page);
            foreach($retrieve as $index => $content) {
                $retrieve[$index]['AuthorList'] = $this->Lab_model->search_author_of_paper($content['PaperID']);
            }
            $data['query_result'] = $retrieve;
            $data['offset'] = $pagenum;
            $data['AuthorListType'] = "link";
            $data['NeedConference'] = false;
            echo $this->load->view('lab/paper/paper.table.php', $data, true);
        } else if ($mode == "paper_coau") {
            $page = $this->input->get('page');
            if($page===null || $page <= 0)
                $page = 1;
            $pagenum = ($page - 1) * 10;
    
            $retrieve = $this->Lab_model->search_author_of_paper(
                $paper_id, $pagenum, 10);
            foreach($retrieve as $index=>$item) {
                $retrieve[$index]['Affiliation'] = 
                    $this->Lab_model->get_paper_author_affi($paper_id, $item['AuthorID']);
            }
            $data['query_result'] = $retrieve;
            $data['offset'] = $pagenum;
            echo $this->load->view('lab/author/author.paper.table.php', $data, true);
        }
    }

    public function view_author_stats()
    {
        $title = $this->input->get('title');
        $data['title'] = 'Author Stats';

        $author_id = $this->input->get('item_id');
        $data['author_id'] = $author_id;
        $data['author_info'] = $this->Lab_model->get_author($author_id);
        $data['author_info']['Affiliation'] = 
            ucwords($this->Lab_model->get_most_freq_affi($author_id)['AffiliationName']);
        $data['author_info']['Conference'] =
            $this->Lab_model->get_most_freq_conf($author_id)['ConferenceName'];
        $data['author_info']['total_paper'] =
            $this->Lab_model->get_author_pub_total_number($author_id);
        $coau_list = 
            $this->Lab_model->get_most_freq_coau($author_id);
        foreach($coau_list as $coau) {
            $data['author_info']['coauthors'][] = 
                ucwords($this->Lab_model->get_author($coau['SecondID'])['AuthorName']);
        }
        $this->load->view('templates/header', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/author/author.stats.php', $data);
        $this->load->view('templates/footer');
    }

    public function view_affiliation_stats()
    {
        $affi_id = $this->input->get('item_id');
        
        $data["affiliation_id"] = $affi_id;
        $data["title"] = "Affiliation Stats";
        $data['affiliation_info'] = $this->Lab_model->get_affi($affi_id);
        $data['affiliation_info']['AuthorNum'] = 
            $this->Lab_model->get_affi_auth_total_number($affi_id);
        $data['affiliation_info']['PaperNum'] = 
            $this->Lab_model->get_affi_paper_total_number($affi_id);
            
        $this->load->view('templates/header', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/affi/affi.stats.php', $data);
        $this->load->view('templates/footer', $data);
    }

    public function view_conference_stats()
	{
        $conf_id = $this->input->get('item_id');
        $data['conference_id'] = $conf_id;
        $data['title'] = "Conference Stats";
        $data['conference_info'] = $this->Lab_model->get_conference($conf_id);
        $data['conference_info']['PaperNum'] = 
            $this->Lab_model->get_conf_paper_total_number($conf_id);
        $data['conference_info']['AuthorNum'] = 
            $this->Lab_model->get_conf_auth_total_number($conf_id);
        
        $this->load->model('Visual_model');
        $data['author_list'] = $this->Visual_model->conference_top_pub($conf_id,'author');
        $data['affi_list'] = $this->Visual_model->conference_top_pub($conf_id,'affiliation');
		
        $this->load->view('templates/header', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
		$this->load->view('lab/conference/conference.stats.php', $data);
		$this->load->view('templates/footer', $data);
    }
    
    public function view_paper_stats()
	{
        $paper_id = $this->input->get('item_id');
		$data["paper_id"] = $paper_id;
        $data["title"] = "Paper Stats";
        $data['paper_info'] = $this->Lab_model->get_paper($paper_id);

        $tmp = $this->Lab_model->get_paper_affi($paper_id); $len = count($tmp);
        $affi_list = "";
        foreach($tmp as $index => $item) {
            if ($index == 0) {
                $affi_list .= ucwords($item['AffiliationName']);
            } else if ($index = $len - 1) {
                $affi_list .= ' and '.ucwords($item['AffiliationName']);
            } else {
                $affi_list .= ', '.ucwords($item['AffiliationName']);
            }
        }
        $data['paper_info']['Affiliation'] = $affi_list;

        $tmp = $this->Lab_model->get_paper_conf($paper_id); $len = count($tmp);
        $conf_list = "";
        foreach($tmp as $index => $item) {
            if ($index == 0) {
                $conf_list .= ucwords($item['ConferenceName']);
            } else if ($index = $len - 1) {
                $conf_list .= ' and '.ucwords($item['ConferenceName']);
            } else {
                $conf_list .= ', '.ucwords($item['ConferenceName']);
            }
        }
        $data['paper_info']['Conference'] = $conf_list;
        
		$data['recommends'] = $this->Label_model->paper_recommend($paper_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('shared/navibar.topfix.php', $data);
		$this->load->view('lab/paper/paper.stats.php', $data);
		$this->load->view('templates/footer', $data);
    }

    public function hyper_search()
	{
		$command = $this->input->get('command');
        $begin = stripos($command, '$');
		if($begin !== false){
            $end = stripos($command, '$', $begin+1);
			if($end === false) {
                redirect($_SERVER['HTTP_REFERER']);
            }
			else{
                $key = trim(substr($command, $begin+1, $end-$begin-1));
				$value = trim(substr($command, $end+1));
				if($key=="author"){
					set_cookie(
						'query_url', base_url().'lab/search_author?author='.$value, 65536
					);
					redirect(base_url().'lab/search_author?author='.$value);
				}
				elseif($key=="paper"){
					set_cookie(
						'query_url', base_url().'lab/search_paper?paper='.$value, 65536
					);
					redirect(base_url().'lab/search_paper?paper='.$value);
				}
				elseif($key=="affiliation" or $key=="affi"){
					set_cookie(
						'query_url', base_url().'lab/search_affi?affi='.$value, 65536
					);
					redirect(base_url().'lab/search_affi?affi='.$value);
				}
				elseif($key=="conference" or $key=="venue"){
					set_cookie(
						'query_url', base_url().'lab/search_conference?conference='.$value, 65536
					);
					redirect(base_url().'lab/search_conference?conference='.$value);
				}
				elseif($key=="author_id"){
					redirect(base_url().'lab/view_author?author_id='.$value);
				}
				elseif($key=="paper_id"){
					redirect(base_url().'lab/view_paper?paper_id='.$value);
				}
				elseif($key=="affiliation_id" or $key=="affi_id"){
					redirect(base_url().'lab/view_affi?affi_id='.$value);
				}
				elseif($key=="conference_id" or $key=="venue_id"){
					redirect(base_url().'lab/view_conf?conf_id='.$value);
				}
			}
		}
		else{
            // global search
            set_cookie(
                'query_url', base_url().'lab/hyper_search?command='.$command, 65536
            );
            $data['title'] = 'Result Page';

            $command = trim($this->input->get('command'));

            $num_author = $this->Lab_model->get_author_total_number($command);
            $num_affi = $this->Lab_model->get_affi_total_number($command);
            $num_conf = $this->Lab_model->get_conference_total_number($command);
            $num_paper = $this->Lab_model->get_paper_total_number($command);
            
            $data['display_author'] = $data['display_affiliation'] = 
            $data['display_conference'] = $data['display_paper'] = false;
            $data['dyn_pagin'] = true;
            $data['total_result'] = $num_author + $num_affi +  $num_conf + $num_paper;
            $this->load->view('templates/header', $data);
            $this->load->view('shared/navibar.topfix.php', $data);

            if ($num_author > 0)
                $data['display_author'] = true;
            if ($num_affi > 0) 
                $data['display_affiliation'] = true;
            if ($num_conf > 0)
                $data['display_conference'] = true;
            if ($num_paper > 0)
                $data['display_paper'] = true;

            $this->load->view('lab/result.frame.php', $data);

            if ($num_author > 0) {
                $this->_makeup_dyn_pagin("auth", "hyper_auth", 
                    $command, $num_author,
                    $this->res_per_page, 10,
                    "lab-result-author-panel" ,"lab-result-author-pagination",
                    base_url()."lab/search_author_table?", 
                    base_url()."pagin/pagin_bar?", $data
                );
            }
            if ($num_affi> 0) {
                $this->_makeup_dyn_pagin("affi", "hyper_affi", 
                    $command, $num_affi,
                    $this->res_per_page, 10,
                    "lab-result-affiliation-panel" ,"lab-result-affiliation-pagination",
                    base_url()."lab/search_affi_table?", 
                    base_url()."pagin/pagin_bar?", $data
                );
            }
            if ($num_conf> 0) {
                $this->_makeup_dyn_pagin("conf", "hyper_conf", 
                    $command, $num_conf,
                    $this->res_per_page, 10,
                    "lab-result-conference-panel" ,"lab-result-conference-pagination",
                    base_url()."lab/search_conference_table?", 
                    base_url()."pagin/pagin_bar?", $data
                );
            }
            if ($num_paper> 0) {
                $this->_makeup_dyn_pagin("paper", "hyper_paper", 
                    $command, $num_paper,
                    $this->res_per_page, 10,
                    "lab-result-paper-panel" ,"lab-result-paper-pagination",
                    base_url()."lab/search_paper_table?", 
                    base_url()."pagin/pagin_bar?", $data
                );
            }
            
            $this->load->view('templates/footer');
        }
	}
}
