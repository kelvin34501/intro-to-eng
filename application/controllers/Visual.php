<?php
class Visual extends CI_controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Lab_model');
        $this->load->model('Visual_model');
        $this->load->helper('url');
    }

    public function get_cn_neighbor() {
        if(isset($_GET['author_id'])) 
            $this->Visual_model->get_cn_neighbor($_GET['author_id']);
        else 
            $this->Visual_model->get_cn_neighbor();
    }

	public function get_publication_increament()
	{
		$author_id = $this->input->get('author_id');
		$paper = $this->Visual_model->publication_paper($author_id); 
		$mode = $this->input->get('mode');
		$result = array();
		if($mode == 1){
			$i = 1;
			$year = $paper[0]["paper_publish_year"];
			$result[0]["year"] = $paper[0]["paper_publish_year"] - 1;
			$result[0]["publication"] = 0;
			foreach ($paper as $row)
			{
				while ($year<$row["paper_publish_year"])
				{
					$result[$i]["year"] = $year;
					$result[$i]["publication"] = 0;
					$i++;
					$year++;
				}
				$result[$i]["year"] = $row["paper_publish_year"];
				$result[$i]["publication"] = $row["papers"];
				$year++;
				$i++;
			}
			
			$result[$i]["year"] = $result[$i-1]["year"] + 1;
			$result[$i]["publication"] = 0;
		}
		elseif($mode == 2){
			$accum = 0;
			$year = $paper[0]["paper_publish_year"];
			$result[0]["year"] = $paper[0]["paper_publish_year"] - 1;
			$result[0]["publication"] = $accum;
			$i = 1;
			foreach ($paper as $row)
			{
				while ($year<$row["paper_publish_year"])
				{
					$result[$i]["year"] = $year;
					$result[$i]["publication"] = $accum;
					$i++;
					$year++;
				}
				$accum += $row["papers"];
				$result[$i]["year"] = $row["paper_publish_year"];
				$result[$i]["publication"] = $accum;
				$year++;
				$i++;
			}
			$result[$i]["year"] = $result[$i-1]["year"] + 1;
			$result[$i]["publication"] = $accum;
		}
		echo json_encode($result);
    }
    
    public function publication_reference_count() {

    }
}