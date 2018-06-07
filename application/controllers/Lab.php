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
        $data['title'] = 'Result Page';
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
        $data['title'] = 'Result Page';
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
        $data['title'] = 'Result Page';
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

    private function _makeup_dyn_padin(
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
        
        $this->load->view('templates/header');
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/author/author.frame.php', $data);

        // dyn pagin loading
        $this->_makeup_dyn_padin("main", "author_pub", $data['author_id'],
            $this->Lab_model->get_author_pub_total_number($data['author_id']),
            $this->res_per_page, 10,
            "lab-author-main-panel" ,"lab-author-main-pagination",
            base_url()."lab/view_author_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->_makeup_dyn_padin("affi", "author_affi", $data['author_id'],
            $this->Lab_model->get_author_affi_total_number($data['author_id']), 5, 5,
            "lab-author-sidebar-af-items", "lab-author-sidebar-af-pagination",
            base_url()."lab/view_author_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->_makeup_dyn_padin("conf", "author_conf", $data['author_id'],
            $this->Lab_model->get_author_conf_total_number($data['author_id']), 5, 5,
            "lab-author-sidebar-cf-items", "lab-author-sidebar-cf-pagination",
            base_url()."lab/view_author_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->_makeup_dyn_padin("coau", "author_coau", $data['author_id'],
            $this->Lab_model->get_author_coau_total_number($data['author_id']), 5, 5,
            "lab-author-sidebar-ca-items", "lab-author-sidebar-ca-pagination",
            base_url()."lab/view_author_content?", 
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
        
        $this->load->view('templates/header');
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/affi/affi.frame.php', $data);

        // dyn pagin loading
        $this->_makeup_dyn_padin("main", "affi_auth", $data['affiliation_id'],
            $this->Lab_model->get_affi_auth_total_number($data['affiliation_id']),
            $this->res_per_page, 10,
            "lab-affiliation-main-panel" ,"lab-affiliation-main-pagination",
            base_url()."lab/view_affi_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->_makeup_dyn_padin("paper", "affi_paper", $data['affiliation_id'],
            $this->Lab_model->get_affi_paper_total_number($data['affiliation_id']), 10, 5,
            "lab-affiliation-sidebar-pp-items", "lab-affiliation-sidebar-pp-pagination",
            base_url()."lab/view_affi_content?", 
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
        
        $this->load->view('templates/header');
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/conference/conference.frame.php', $data);

        // dyn pagin loading
        $this->_makeup_dyn_padin("main", "conf_paper", $data['conference_id'],
            $this->Lab_model->get_conf_paper_total_number($data['conference_id']),
            $this->res_per_page, 10,
            "lab-conference-main-panel" ,"lab-conference-main-pagination",
            base_url()."lab/view_conf_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->_makeup_dyn_padin("auth", "conf_auth", $data['conference_id'],
            $this->Lab_model->get_conf_auth_total_number($data['conference_id']), 10, 5,
            "lab-conference-sidebar-au-items", "lab-conference-sidebar-au-pagination",
            base_url()."lab/view_conf_content?", 
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
        $this->load->view('templates/header');
        $this->load->view('shared/navibar.topfix.php', $data);
        $this->load->view('lab/paper/paper.frame.php', $data);

        // dyn pagin loading
        $this->_makeup_dyn_padin("ref", "paper_ref", $data['paper_id'],
            $this->Lab_model->get_paper_ref_total_number($data['paper_id']),
            $this->res_per_page, 10,
            "lab-paper-reference-items" ,"lab-paper-reference-pagination",
            base_url()."lab/view_paper_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->_makeup_dyn_padin("cite", "paper_cite", $data['paper_id'],
            $this->Lab_model->get_paper_cite_total_number($data['paper_id']), 10, 5,
            "lab-paper-citedby-items", "lab-paper-citedby-pagination",
            base_url()."lab/view_paper_content?", 
            base_url()."pagin/pagin_bar?", $data
        );
        $this->_makeup_dyn_padin("coau", "paper_coau", $data['paper_id'],
            $this->Lab_model->get_paper_author_total_number($data['paper_id']), 10, 5,
            "lab-paper-sidebar-ca-items", "lab-paper-sidebar-ca-pagination",
            base_url()."lab/view_paper_content?", 
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
            $data['query_result'] = $retrieve;
            $data['offset'] = $pagenum;
            echo $this->load->view('lab/author/author.content.php', $data, true);
        }
    }

    public function view_stats()
    {
        $mode = $this->input->get('title');
        if ($mode == "Author Page") {
            $data['title'] = 'Author Stats';

            $author_id = $this->input->get('item_id');
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
            $this->load->view('templates/header');
            $this->load->view('shared/navibar.topfix.php', $data);
            $this->load->view('lab/author/author.stats.php', $data);
            $this->load->view('templates/footer');
        }
    }
}
