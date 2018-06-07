<?php
class Visual_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_cn_neighbor($author_id=null)
	{
		$nodes = array();
		$links = array();
		
		if($author_id != null)
		{
			$neighbors = $this->db->query(
                "select SecondID as neighbor_id from Cooperations 
                where FirstID = ? union 
                select FirstID as neighbor_id from Cooperations 
                where SecondID = ?;",
                array($author_id, $author_id)
            )->result_array();
			
			$advisors = array_column($this->db->query(
                "select FirstID AS advisor_id from Cooperations 
                where SecondID = ? AND IsAdvisor = 1;",
                array($author_id)
            )->result_array(), 'advisor_id');
			
			$advisees = array_column($this->db->query(
                "select SecondID AS advisee_id from Cooperations 
                where FirstID = ? AND IsAdvisor = 1;",
                array($author_id)
            )->result_array(), 'advisee_id');
			
			
			array_push($nodes, array(
				'id' => $author_id,
				'group' => 1
			));
			foreach($neighbors as $neighbor)
			{
				$neighbor_id = $neighbor['neighbor_id'];
				if(in_array($neighbor_id, $advisors)) $group = 3;
				elseif(in_array($neighbor_id, $advisees)) $group = 4;
				else $group = 2;
				array_push($nodes, array(
					'id' => $neighbor_id,
					'group' => $group
				));
				array_push($links, array(
					'source' => $author_id,
					'target' => $neighbor_id,
					'value' => 6
				));

				$extensions = array_column($this->db->query(
                    "select SecondID as neighbor_id from Cooperations 
                    where FirstID = ? union 
                    select FirstID as neighbor_id from Cooperations 
                    where SecondID = ?;",
                    array($neighbor_id, $neighbor_id)
                )->result_array(), 'neighbor_id');
				
				$cnt = 0;
				foreach($neighbors as $cand)
				{
					$cand_id = $cand['neighbor_id'];
					if($cand_id != $neighbor_id and in_array($cand_id, $extensions))
					{
						array_push($links, array(
							'source' => $neighbor_id,
							'target' => $cand_id,
							'value' => 2
						));
						$cnt += 1;
					}
				}
			}
		}
		else
		{
			$cnt = 0;
			$sql = "select AuthorID as author_id from Authors";
			foreach($this->db->query($sql)->result_array() as $author)
			{
				array_push($nodes, array(
					'id' => $author["author_id"],
					'group' => 1
				));
			}
            $sql = "select FirstID as f_author_id,
                SecondID as t_author_id
                from Cooperations";
			foreach($this->db->query($sql)->result_array() as $edge)
			{
				array_push($links, array(
					'source' => $edge["f_author_id"],
					'target' => $edge["t_author_id"],
					'value' => 3
				));
			}
		}
		
		$result = array(
			'nodes' => $nodes,
			'links' => $links
		);
		echo json_encode($result);
	}
	
    public function publication_paper($q)
	{
		$query = $this->db->query(
            "select count(Papers.PaperId)papers, 
            Papers.PaperPublishYear as paper_publish_year from Papers 
            inner join PaperAuthorAffiliation 
            on Papers.PaperId = PaperAuthorAffiliation.PaperID
            where PaperAuthorAffiliation.AuthorID=? 
            group by paper_publish_year order by paper_publish_year",
            array($q)
        );
		return $query->result_array();
    }
    
    public function publication_IDyear($q)
	{
		$sql = "select paper.paper_publish_year,paper.paper_id from paper inner join paper_author_affiliation
				on paper.paper_id=paper_author_affiliation.paper_id where paper_author_affiliation.author_id='{$q}' 
				order by paper.paper_publish_year asc";
		$query = $this->db->query($sql);
		return $query->result_array();
    }
    
	public function publication_ref_num($q)
	{
		$sql = "select count(reference_id)rid from reference where reference_id='{$q}' ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}