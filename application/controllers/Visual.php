<?php
class Visual extends CI_controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Lab_model');
        $this->load->model('Visual_model');
		$this->load->model('Label_model');
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
		$author_id = $this->input->get('id');
		$mode = $this->input->get('mode');
		$key = $this->input->get('key');
		$paper = $this->Visual_model->publication_paper($author_id, $key);
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
    
	public function publication_reference_count()
	{
		$AuthorID = $this->input->get('author_id');
		$paper = $this->Visual_model->publication_IDyear($AuthorID);
		$i=0;
		foreach ($paper as $row)
		{
			$paper[$i]["Reference_num"]=
				$this->Visual_model->publication_ref_num($row["paper_id"])[0]["rid"];
			$i++;
		}
		$j=-1;
		for ($i=0;$i<count($paper);$i++)
		{
			if ($i==0||$paper[$i]["paper_publish_year"]!=$paper[$i-1]["paper_publish_year"])
			{
				$j++;
				$result[$j]["year"]=$paper[$i]["paper_publish_year"];
				$result[$j]["reference"]=[];
				$result[$j]["reference"][]=$paper[$i]["Reference_num"];
				
			}
			else
			{
				$result[$j]["reference"][]=$paper[$i]["Reference_num"];
			}
		}
		
		$result=json_encode($result);
		echo $result;
	}
	
	public function paper_referred()
	{
		$PaperID = $this->input->get('paper_id');
		$temp = $this->Visual_model->referred($PaperID);
		$i=0;
		foreach ($temp as $row)
		{
			$result[$i]["year"]=$row["paper_publish_year"];
			$result[$i]["number"]=$row["count"];
			$i++;
		}
		$result=json_encode($result);
		echo $result;
	}
	
	public function paper_referring()
	{
		$PaperID = $this->input->get('paper_id');
		$temp = $this->Visual_model->referring($PaperID);
		$i=0;
		foreach ($temp as $row)
		{
			$result[$i]["year"]=$row["paper_publish_year"];
			$result[$i]["number"]=$row["count"];
			$i++;
		}
		$result=json_encode($result);
		echo $result;
	}
	
	public function author_con()
	{
		$AuthorID = $this->input->get('id');
		$key = $this->input->get('key');
		$temp = $this->Visual_model->author_con($AuthorID, $key);
		for ($i=0;$i<count($temp);$i++)
		{
			$result[$i]["conference_id"]=$temp[$i]["conference_id"];
			$result[$i]["number"]=$temp[$i]["number"];
		}
		$result=json_encode($result);
		echo $result;
	}
	
	public function conference_top_pub()
	{
		$conference_id = $this->input->get('id');
		$key = $this->input->get('key');
		$temp = $this->Visual_model->conference_top_pub($conference_id, $key);
		echo json_encode($temp);
	}

	public function get_af_cn_neighbor()
	{
		$this->Visual_model->get_af_cn_neighbor($_GET['affiliation_id']);
	}
	
	public function get_advanced_dyn_cn_neighbor()
	{
		$this->Visual_model->get_dyn_cn_neighbor($_GET['author_id']);
		//$this->search_model->dyn_test($_GET['author_id']);
	}
	
	public function get_affi_label()
	{
		$result = $this->Label_model->fetch_affi_label($_GET['affi_id'], 0, 10);
		echo json_encode($result['cloud']);
	}
	
	public function get_author_label()
	{
		$result = $this->Label_model->fetch_author_label($_GET['author_id'], 0, 10);
		echo json_encode($result['cloud']);
	}
	
	public function get_conf_label()
	{
		$result = $this->Label_model->fetch_conf_label($_GET['conf_id'], 0, 10);
		echo json_encode($result['cloud']);
	}
}