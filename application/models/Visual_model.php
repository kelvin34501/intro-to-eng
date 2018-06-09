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

	public function get_dyn_cn_neighbor($affiliation_id=null)
	{
		$nodes = array();
		$links = array();
		
		if($affiliation_id != null)
		{
			$authors = $this->db->query(
				"select distinct(AuthorID) as author_id from PaperAuthorAffiliation 
				where AffiliationID = ?",
				array($affiliation_id)
			)->result_array();
			$advisors = $this->db->query(
				"select aid.author_id as author_id from 
				(select distinct(AuthorID)author_id from PaperAuthorAffiliation 
				where AffiliationID = ?) aid 
				inner join 
				(select distinct(FirstID)author_id from Cooperations
				where IsAdvisor=1) adid 
				on aid.author_id = adid.author_id",
				array($affiliation_id)
			)->result_array();
			foreach($authors as $author){
				if(in_array($author, $advisors)) $group = 2;
				else $group = 1;
				
				$advisors = $this->db->query(
					"select FirstID as author_id from Cooperations 
					where SecondID = ? and IsAdvisor = 1",
					array($author['author_id'])
				)->result_array();
				$advisees = $this->db->query(
					"select SecondID as author_id from Cooperations 
					where FirstID = ? and IsAdvisor = 1",
					array($author['author_id'])
				)->result_array();
				array_push($nodes, array(
					'id' => $author['author_id'],
					'group' => $group,
					'advisors' => array_column($advisors, 'author_id'),
					'advisees' => array_column($advisees, 'author_id')
				));
				
				$neighbors = $this->db->query(
					"select af.author_id as author_id from 
					(
						(select FirstID as author_id from Cooperations 
						where SecondID = ?) 
						union 
						(select SecondID as author_id from Cooperations 
						where FirstID = ?)
					)neighbor 
					inner join (select distinct(AuthorID) as author_id from 
					PaperAuthorAffiliation where AffiliationID = ?)af 
					on neighbor.author_id = af.author_id",
					array($author['author_id'],$author['author_id'],$affiliation_id)
				)->result_array();
				foreach($neighbors as $neighbor){
					array_push($links, array(
						'source' => $author['author_id'],
						'target' => $neighbor['author_id'],
						'value' => 2
					));
				}
			}
			
		}
		
		$result = array(
			'nodes' => $nodes,
			'links' => $links
		);
		echo json_encode($result);
	}
	
	public function publication_paper($q, $mode='author')
	{
		if($mode=='author') {
			$query = $this->db->query(
				"select count(Papers.PaperId)papers, 
				Papers.PaperPublishYear as paper_publish_year from Papers 
				inner join PaperAuthorAffiliation 
				on Papers.PaperId = PaperAuthorAffiliation.PaperID
				where PaperAuthorAffiliation.AuthorID=? 
				group by paper_publish_year order by paper_publish_year",
				array($q)
			);
		}
		elseif($mode=='affiliation') {
			$query = $this->db->query(
				"select count(Papers.PaperID)papers, 
					Papers.PaperPublishYear as paper_publish_year from Papers 
				inner join PaperAuthorAffiliation 
				on Papers.PaperID = PaperAuthorAffiliation.PaperID 
				where PaperAuthorAffiliation.AffiliationID=? 
				group by paper_publish_year order by paper_publish_year",
				array($q)
			);
		}
		elseif($mode=='conference') {
			$query = $this->db->query(
				"select count(PaperID)papers, 
					PaperPublishYear as paper_publish_year from Papers 
				where ConferenceID = ?
				group by paper_publish_year order by paper_publish_year",
				array($q)
			);
		}
		return $query->result_array();
	}
    
    public function publication_IDyear($q)
	{
		$query = $this->db->query(
			"select Papers.PaperPublishYear as paper_publish_year
				,Papers.PaperID as paper_id from Papers
			inner join PaperAuthorAffiliation
			on Papers.PaperID=PaperAuthorAffiliation.PaperID
			where PaperAuthorAffiliation.AuthorID=? 
			order by Papers.PaperPublishYear asc",
			array($q)
		);
		return $query->result_array();
    }
    
	public function publication_ref_num($q)
	{
		$query = $this->db->query(
			"select count(ReferenceID) as rid from PaperReference where ReferenceID=?",
			array($q)
		);
		return $query->result_array();
	}

	public function referred($q)
	{
		$query = $this->db->query(
			"select count(PaperReference.PaperID) as count,
				Papers.PaperPublishYear as paper_publish_year from Papers 
			inner join PaperReference
			on Papers.PaperID=PaperReference.PaperID where PaperReference.ReferenceID=?
			group by paper_publish_year order by paper_publish_year asc ",
			array($q)
		);
		return $query->result_array();
	}
	
	public function referring($q)
	{
		$query = $this->db->query(
			"select count(PaperReference.ReferenceID) as count,
				Papers.PaperPublishYear as paper_publish_year from Papers 
			inner join PaperReference
			on Papers.PaperID=PaperReference.ReferenceID where PaperReference.PaperID=?
			group by paper_publish_year order by paper_publish_year asc ",
			array($q)
		);
		return $query->result_array();
	}
	
	public function author_con($q, $key)
	{
		if ($key=='author') {
			$query = $this->db->query(
				"select Papers.ConferenceID as conference_id,
					count(Papers.PaperID)number 
				from Papers
				inner join PaperAuthorAffiliation 
				on Papers.PaperID=PaperAuthorAffiliation.PaperID 
				where PaperAuthorAffiliation.AuthorID=?
				group by conference_id",
				array($q)
			);
		} else if( $key=='affiliation') {
			$query = $this->db->query(
				"select Papers.ConferenceID as conference_id,
					count(Papers.PaperID)number from Papers 
				inner join PaperAuthorAffiliation 
				on Papers.PaperID=PaperAuthorAffiliation.PaperID
				where PaperAuthorAffiliation.AffiliationID='{$q}'
				group by conference_id",
				array($q)
			);
		}
		return $query->result_array();
	}
	
	public function conference_top_pub($q, $key)
	{
		if ($key=="author") {
			$query = $this->db->query(
				"select Authors.AuthorName as name, res.papers as papers from 
				Authors 
				inner join 
				(select PaperAuthorAffiliation.AuthorID as author_id, 
					count(pid.paper_id)papers from 
					PaperAuthorAffiliation 
					inner join 
					(select PaperID as paper_id from Papers where ConferenceID = ?)pid 
					on PaperAuthorAffiliation.PaperID = pid.paper_id 
					group by author_id 
					order by papers desc limit 0,11)res 
				on Authors.AuthorID = res.author_id",
				array($q)
			);
		} elseif ($key=="affiliation") {
			$query = $this->db->query(
				"select Affiliations.AffiliationName as name, res.papers as papers from 
				Affiliations 
				inner join 
				(select PaperAuthorAffiliation.AffiliationID as affiliation_id, 
					count(pid.paper_id)papers from 
					PaperAuthorAffiliation 
					inner join 
					(select PaperID as paper_id from Papers where ConferenceID = ?)pid 
					on PaperAuthorAffiliation.PaperID = pid.paper_id
					group by affiliation_id 
					order by papers desc limit 0,11)res
				on Affiliations.AffiliationID = res.affiliation_id",
				array($q)
			);
		}
		return $query->result_array();
	}
}