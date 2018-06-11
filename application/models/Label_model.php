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
}