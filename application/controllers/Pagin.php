<?php
class Pagin extends CI_controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    static private function _gen_page_ind($p, $a, $b, $page_per_bar=10) {
        //return an array with page number and status
        $res = array();
        $m = $p - floor($page_per_bar/2);
        $begin = ( $m > 0 ) ? $m : 1;

        if( $p <= floor($page_per_bar/2) ) {
            if( $b >= $page_per_bar )
                $end = $page_per_bar;
            else
                $end = $b;
        } else {
            $n = $p + floor($page_per_bar/2) - 1;
            $end = ( $n <= $b ) ? $n : $b;
        }

        for($i=$begin; $i<=$end; $i++) {
            if($i != $p)
                $res[] = array('number'=>$i, 'status'=>'', 'active'=>'');
            else
                $res[] = array('number'=>$i, 'status'=>'', 'active'=>'pagination-dark-disabled');
        }
        return $res;
    }

    static private function _gen_page_backward($p, $a, $b) {
        $res = array();
        if($p == $a) {
            $res['number'] = $p; $res['status'] = ''; $res['active'] = 'disabled';
        } else {
            $res['number'] = $p - 1; $res['status'] = ''; $res['active'] = '';
        }
        return $res;
    }

    static private function _gen_page_forward($p, $a, $b) {
        $res = array();
        if($p == $b) {
            $res['number'] = $p; $res['status'] = ''; $res['active'] = 'disabled';
        } else {
            $res['number'] = $p + 1; $res['status'] = ''; $res['active'] = '';
        }
        return $res;
    }

    static public function _fill_pagenum($page, $total, &$data, $res_per_page=10) {
        // pass data by reference
        if($page===null || $page <= 0)
            $page = 1;
        $pagenum = ($page - 1) * $res_per_page;
        $startpage = 1;
        $endpage = $total;

        $data['page'] = $page;
        $data['startpage'] = $startpage;
        $data['endpage'] = $endpage;
    }

    public function pagin_bar() {
        $pagin_handle = $this->input->get('handle');
        $page = $this->input->get('page');
        $startpage = $this->input->get('startpage');
        $endpage = $this->input->get('endpage');
        $pageforward = $this->_gen_page_forward($page,  $startpage, $endpage);
        $pagebackward = $this->_gen_page_backward($page, $startpage, $endpage);
        $pageindex = $this->_gen_page_ind($page, $startpage, $endpage);

        $data['pagin_handle'] = $pagin_handle;

        $data['page'] = $page;
        $data['startpage'] = $startpage;
        $data['endpage'] = $endpage;
        $data['pageforward'] = $pageforward;
        $data['pagebackward'] = $pagebackward;
        $data['pageindex'] = $pageindex;

        echo $this->load->view('shared/pagin.bar.php', $data, true);
    }
}
