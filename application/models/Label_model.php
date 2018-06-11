<?php
class Label_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	public function paper_label($q)
	{
		$sql = "select Label,count(Label) from PaperLabel where PaperID='{$q}'
				group by Label order by count(Label) desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function author_label($q)
	{
		$sql = "select PaperLabel.Label,count(PaperLabel.Label) from PaperLabel
				inner join PaperAuthorAffiliation on PaperLabel.PaperID=PaperAuthorAffiliation.PaperID
				where PaperAuthorAffiliation.AuthorID='{$q}'
				group by PaperLabel.Label order by count(Label) desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function affiliation_label($q)
	{
		$sql = "select PaperLabel.Label,count(PaperLabel.Label) from PaperLabel
				inner join PaperAuthorAffiliation on PaperLabel.PaperID=PaperAuthorAffiliation.PaperID
				where PaperAuthorAffiliation.AffiliationID='{$q}'
				group by PaperLabel.Label order by count(Label) desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function conference_label($q)
	{
		$sql = "select PaperLabel.Label,count(PaperLabel.Label) from PaperLabel
				inner join Papers on Papers.PaperID=PaperLabel.PaperID
				where Papers.ConferenceID='{$q}'
				group by PaperLabel.Label order by count(Label) desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function label_paper($q)
	{
		$sql = "select PaperID from PaperLabel where Label='{$q}'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
    public function fetch_paper_label($PaperID, $begin, $num) {
		$result = $this->paper_label($PaperID);
		
		foreach ($result as $row)
			$label[]=$row['Label'];
        $slice = array_slice($label, $begin, $num);
        return array('num' => count($label), 'slice' => $slice);
    }
    public function fetch_author_label($AuthorID, $begin, $num) {
		$result = $this->author_label($AuthorID);
		
		foreach ($result as $row)
		{	
			$label[]=$row['Label'];
			$cloud[]=['text'=>$row['Label'],'size'=>$row['count(PaperLabel.Label)']];
		}	
        $slice = array_slice($label, $begin, $num);
        return array('num' => count($label), 'slice' => $slice, 'cloud' => $cloud);
    }
    public function fetch_affi_label($AffiliationID, $begin, $num) {
		$result = $this->affiliation_label($AffiliationID);
		
		foreach ($result as $row)
		{	
			$label[]=$row['Label'];
			$cloud[]=['text'=>$row['Label'],'size'=>$row['count(PaperLabel.Label)']];
		}		
        $slice = array_slice($label, $begin, $num);
        return array('num' => count($label), 'slice' => $slice, 'cloud' => $cloud);    
	}
    public function fetch_conf_label($ConferenceID, $begin, $num) {
		$result = $this->conference_label($ConferenceID);
		
		foreach ($result as $row)
		{	
			$label[]=$row['Label'];
			$cloud[]=['text'=>$row['Label'],'size'=>$row['count(PaperLabel.Label)']];
		}		
        $slice = array_slice($label, $begin, $num);
        return array('num' => count($label), 'slice' => $slice, 'cloud' => $cloud);
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
		$sql = "select AuthorName from Authors where AuthorID='{$q}'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function recommend_PaperInfo($q)
	{
		$sql = "select count(PaperReference.ReferenceID) ReferenceNum,Papers.PaperPublishYear,Papers.Title,Conferences.ConferenceName
				from Papers left join PaperReference on Papers.PaperID=PaperReference.ReferenceID
				inner join Conferences on Conferences.ConferenceID=Papers.ConferenceID
				where Papers.PaperID='{$q}'";
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
			$AuthorID[$i]=$row['AuthorID'];//find all the Authors of this paper
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
					$recommend[$row0['PaperID']]['Reference']++;//add one common reference of two Papers

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
			$result = $this->recommend_paper_a($q);//select PaperID from PaperAuthorAffiliation where AuthorID='{$q}'
			foreach ($result as $row0)
			{
				if ($row0['PaperID']==$PaperID)
					continue;
				if (in_array($row0['PaperID'],$paper))
				{
					$recommend[$row0['PaperID']]['Author']++;//add one common author of two Papers

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
		
		$result = $this->paper_label($PaperID);
		foreach ($result as $row)
			$label = $row['Label'];
		
		foreach ($label as $row)
		{
			$target = $this->label_paper($row);
			foreach ($target as $row0)
			{
				if ($row0['PaperID']==$PaperID)
					continue;
				if (in_array($row0['PaperID'],$paper))
				{
					$recommend[$row0['PaperID']]['Label']++;//add one common author of two Papers

				}
				else
				{
					$paper[$num]=$row0['PaperID']; //add one potential paper
					$recommend[$row0['PaperID']]['Reference'] = 0;
					$recommend[$row0['PaperID']]['Label'] = 1;
					$recommend[$row0['PaperID']]['Author'] = 0;
					$num=$num+1;
				}
				$recommend[$row0['PaperID']]['coL'][]=$row;
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
		return $recommends;
	}
}