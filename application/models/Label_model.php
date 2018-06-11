<?php
class Label_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function fetch_paper_label($PaperID, $begin, $num) {
		$Title = $this->recommend_Title($PaperID);
		$Title = $Title[0]['Title'];
		
		$result = $this->recommend_label();
		foreach ($result as $row)
			$set[$row['Label']] = 0;
		$words = explode(" ",$Title);
		
		$i=0;
		$label = [];
		while ($i<count($words)-1)
		{
			$st = join(" ",array($words[$i],$words[$i+1]));
			if (isset($set[$st]))
			{
				if (!in_array($st,$label))
					$label[] = $st;
				$i=$i+2;
			}
			else
			{
				if (isset($set[$words[$i]]))
					if (!in_array($st,$label))
						$label[] = $words[$i];
				$i=$i+1;
			}				
		}
		if ($i==count($words)-1&&isset($set[$words[$i]]))
            $label[] = $words[$i];
        $slice = array_slice($label, $begin, $num);
        return array('num' => count($label), 'slice' => $slice);
    }
    public function fetch_author_label($AuthorID, $begin, $num) {
		$Titles = $this->label_author($AuthorID);
		
		$result = $this->recommend_label();
		foreach ($result as $row)
			$set[$row['Label']] = 0;
			
		foreach ($Titles as $title)
		{
			$words = explode(" ",$title["Title"]);
			$i=0;
			while ($i<count($words)-1)
			{
				$st = join(" ",array($words[$i],$words[$i+1]));
				if (isset($set[$st]))
				{
					if (!isset($judger[$st]))
					{
						$judger[$st]=0;
						$label[] = $st;
					}
					$i=$i+2;
				}
				else
				{
					if (isset($set[$words[$i]]))
						if (!isset($judger[$words[$i]]))
						{
							$judger[$words[$i]]=0;
							$label[] = $words[$i];
						}
					$i=$i+1;
				}				
			}
			if ($i==count($words)-1&&isset($set[$words[$i]]))
				if (!isset($judger[$words[$i]]))
				{
					$judger[$words[$i]]=0;
					$label[] = $words[$i];
				}
        }
        $slice = array_slice($label, $begin, $num);
        return array('num' => count($label), 'slice' => $slice);
    }
    public function fetch_affi_label($AffiliationID, $begin, $num) {
		$Titles = $this->label_affiliation($AffiliationID);
		
		$result = $this->recommend_label();
		foreach ($result as $row)
			$set[$row['Label']] = 0;
			
		$judger=[];
		$label=[];
		
		foreach ($Titles as $title)
		{
			$words = explode(" ",$title["Title"]);
			$i=0;
			while ($i<count($words)-1)
			{
				$st = join(" ",array($words[$i],$words[$i+1]));
				if (isset($set[$st]))
				{
					if (!isset($judger[$st]))
					{
						$judger[$st]=0;
						$label[] = $st;
					}
					$i=$i+2;
				}
				else
				{
					if (isset($set[$words[$i]]))
						if (!isset($judger[$words[$i]]))
						{
							$judger[$words[$i]]=0;
							$label[] = $words[$i];
						}
					$i=$i+1;
				}				
			}
			if ($i==count($words)-1&&isset($set[$words[$i]]))
				if (!isset($judger[$words[$i]]))
				{
					$judger[$words[$i]]=0;
					$label[] = $words[$i];
				}
		}
        $slice = array_slice($label, $begin, $num);
        return array('num' => count($label), 'slice' => $slice);
    }
    public function fetch_conf_label($ConferenceID, $begin, $num) {
		$Titles = $this->label_conference($ConferenceID);
		
		$result = $this->recommend_label();
		foreach ($result as $row)
			$set[$row['Label']] = 0;
			
		$judger=[];
		$label=[];
		
		foreach ($Titles as $title)
		{
			$words = explode(" ",$title["Title"]);
			$i=0;
			while ($i<count($words)-1)
			{
				$st = join(" ",array($words[$i],$words[$i+1]));
				if (isset($set[$st]))
				{
					if (!isset($judger[$st]))
					{
						$judger[$st]=0;
						$label[] = $st;
					}
					$i=$i+2;
				}
				else
				{
					if (isset($set[$words[$i]]))
						if (!isset($judger[$words[$i]]))
						{
							$judger[$words[$i]]=0;
							$label[] = $words[$i];
						}
					$i=$i+1;
				}				
			}
			if ($i==count($words)-1&&isset($set[$words[$i]]))
				if (!isset($judger[$words[$i]]))
				{
					$judger[$words[$i]]=0;
					$label[] = $words[$i];
				}
		}
        $slice = array_slice($label, $begin, $num);
        return array('num' => count($label), 'slice' => $slice);
    }

    public function label_author($q)
	{
		$sql = "select Papers.Title from Papers inner join PaperAuthorAffiliation 
				on Papers.PaperID=PaperAuthorAffiliation.PaperID 
				where PaperAuthorAffiliation.AuthorID='{$q}' ";
		$query = $this->db->query($sql);
		return $query->result_array();				
	}
	public function label_affiliation($q)
	{
		$sql = "select Papers.Title from Papers inner join PaperAuthorAffiliation 
				on Papers.PaperID=PaperAuthorAffiliation.PaperID 
				where PaperAuthorAffiliation.AffiliationID='{$q}' ";
		$query = $this->db->query($sql);
		return $query->result_array();				
	}
	public function label_conference($q)
	{
		$sql = "select Title from Papers where ConferenceID='{$q}' ";
		$query = $this->db->query($sql);
		return $query->result_array();				
	}
	
    public function recommend_reference($q)
	{
		$sql = "select ReferenceID from PaperReference where PaperID='{$q}'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function recommend_author($q)
	{
		$sql = "select AuthorID from PaperAuthorAffiliation where PaperID='{$q}'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function recommend_paper_r($q)
	{
		$sql = "select PaperID from PaperReference where ReferenceID='{$q}'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function recommend_paper_a($q)
	{
		$sql = "select PaperID from PaperAuthorAffiliation where AuthorID='{$q}'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function recommend_Title($q)
	{
		$sql = "select Title from Papers where PaperID='{$q}'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function recommend_label()
	{
		$sql = "select Label from Labels";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function recommend_allpaper()
	{
		$sql = "select PaperID,Title from Papers";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function recommend_AuthorName($q)
	{
		$sql = "select AuthorName from authors where AuthorID='{$q}'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function recommend_PaperInfo($q)
	{
		$sql = "select count(paper_reference.ReferenceID) ReferenceNum,papers.PaperPublishYear,papers.Title,conferences.ConferenceName
				from papers left join paper_reference on papers.PaperID=paper_reference.ReferenceID
				inner join conferences on conferences.ConferenceID=papers.ConferenceID
				where papers.PaperID='{$q}'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function paper_recommend($PaperID)
	{
		$q = $PaperID;
		$result = $this->recommend_reference($q);
		$i=0;
		$ReferenceID=[];
		foreach ($result as $row)
		{
			$ReferenceID[$i]=$row['ReferenceID'];//find all the references of this paper
			$i++;
		}
		$result = $this->recommend_author($q);
		$i=0;
		$AuthorID=[];
		foreach ($result as $row)
		{
			$AuthorID[$i]=$row['AuthorID'];//find all the authors of this paper
			$i++;
		}
		$paper = [];
		$num=0; //num of potential recommendation
		foreach ($ReferenceID as $row)
		{
			$q = $row;
			$result = $this->recommend_paper_r($q);
			foreach ($result as $row0)
			{
				if ($row0['PaperID']==$PaperID)
					continue;
				if (in_array($row0['PaperID'],$paper))
				{
					$recommend[$row0['PaperID']]['Reference']++;//add one common reference of two papers

				}
				else
				{
					$paper[$num]=$row0['PaperID']; //add one potential paper
					$recommend[$row0['PaperID']]['Reference'] = 1;
					$recommend[$row0['PaperID']]['Label'] = 0;
					$recommend[$row0['PaperID']]['Author'] = 0;
					$num=$num+1;
				}
				$tmp = $this->recommend_Title($row)[0]["Title"];
				$recommend[$row0['PaperID']]['coR'][]=['PaperID'=>$row,'Title'=>$tmp];

			}
		}
		
		foreach ($AuthorID as $row)
		{
			$q = $row;
			$result = $this->recommend_paper_a($q);//select PaperID from paper_author_affiliation where AuthorID='{$q}'
			foreach ($result as $row0)
			{
				if ($row0['PaperID']==$PaperID)
					continue;
				if (in_array($row0['PaperID'],$paper))
				{
					$recommend[$row0['PaperID']]['Author']++;//add one common author of two papers

				}
				else
				{
					$paper[$num]=$row0['PaperID']; //add one potential paper
					$recommend[$row0['PaperID']]['Reference'] = 0;
					$recommend[$row0['PaperID']]['Label'] = 0;
					$recommend[$row0['PaperID']]['Author'] = 1;
					$num=$num+1;
				}
				$tmp = $this->recommend_AuthorName($row)[0]["AuthorName"];
				$recommend[$row0['PaperID']]['coA'][]=['AuthorID'=>$row,'AuthorName'=>$tmp];

			}
		}
		
		$Title = $this->recommend_Title($PaperID);
		$Title = $Title[0]['Title'];
		
		$result = $this->recommend_label();
		foreach ($result as $row)
			$set[$row['Label']] = 0;
		$words = explode(" ",$Title);
		
		$i = 0;
		$label = [];
		while ($i<count($words)-1)
		{
			$st = join(" ",array($words[$i],$words[$i+1]));
			if (isset($set[$st]))
			{
				$label[] = $st;
				$i=$i+2;
			}
			else
			{
				if (isset($set[$words[$i]]))
					$label[] = $words[$i];
				$i=$i+1;
			}				
		}
		if ($i==count($words)-1&&isset($set[$words[$i]]))
			$label[] = $words[$i];
		
		$all_paper = $this->recommend_allpaper();
		
		foreach ($all_paper as $row)
		{
			if ($row['PaperID']==$PaperID)
				continue;
			foreach ($label as $i)
			{
				if (strstr($row["Title"],$i)=="")
					continue;
				if (in_array($row['PaperID'],$paper))
				{
					$recommend[$row['PaperID']]['Label']++;//add one common label of two papers
	
				}
				else
				{
					$paper[$num]=$row['PaperID']; //add one potential paper
					$recommend[$row['PaperID']]['Reference'] = 0;
					$recommend[$row['PaperID']]['Label'] = 1;
					$recommend[$row['PaperID']]['Author'] = 0;
					$num=$num+1;
				}
				$recommend[$row['PaperID']]['coL'][]=$i;
			}		
		}
		
		
		foreach ($paper as $row)
			$recommend[$row]['Score'] = $recommend[$row]['Reference'] + $recommend[$row]['Author'] + $recommend[$row]['Label']; //calculate the score of recommendation
		
		for ($i=0;$i<$num;$i++)
			$recommend[$paper[$i]]['PaperID']=$paper[$i];
		
		$recommend_num=4; //num of recommendation
		for ($i=0;$i<min($recommend_num,$num);$i++)
			for ($j=$i+1;$j<$num;$j++)
				if ($recommend[$paper[$i]]['Score']<$recommend[$paper[$j]]['Score'])
				{
					$temp=$paper[$i];
					$paper[$i]=$paper[$j];
					$paper[$j]=$temp;
				}//partly sort

		for ($i=0;$i<min($recommend_num,$num);$i++)
		{
			$tmp = $this->recommend_PaperInfo($paper[$i])[0];
			$recommend[$paper[$i]] =array_merge($recommend[$paper[$i]],$tmp);
		}
			
		$recommends = array();
		for ($i=0;$i<min($recommend_num,$num);$i++)
			array_push($recommends, $recommend[$paper[$i]]);
		return recommends;
	}
}