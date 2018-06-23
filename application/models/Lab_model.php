<?php
class Lab_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_author($author_id) {
        $query = $this->db->get_where('Authors', array('AuthorID' => $author_id));
        return $query->row_array();
    }

    public function get_affi($affi_id) {
        $query = $this->db->get_where('Affiliations', array('AffiliationID' => $affi_id));
        return $query->row_array();
    }

    public function get_paper($paper_id) {
        $query = $this->db->get_where('Papers', array('PaperID' => $paper_id));
        return $query->row_array();
    }

    public function get_paper_affi($paper_id) {
        $query = $this->db->query(
            "SELECT AffiliationName FROM
            (SELECT DISTINCT(AffiliationID) FROM PaperAuthorAffiliation WHERE PaperID=?) a
            INNER JOIN Affiliations b
            ON a.AffiliationID = b.AffiliationID",
            array($paper_id)
        );
        return $query->result_array();
    }

    public function get_paper_conf($paper_id) {
        $query = $this->db->query(
            "SELECT ConferenceName FROM
            (SELECT ConferenceID FROM Papers WHERE PaperID=?) a
            INNER JOIN Conferences b
            ON a.ConferenceID = b.ConferenceID;",
            array($paper_id)
        );
        return $query->result_array();
    }

    public function get_paper_author_affi($paper_id, $author_id) {
        $query = $this->db->query(
            "SELECT a.AffiliationID, AffiliationName FROM
            (SELECT AffiliationID FROM PaperAuthorAffiliation 
            WHERE PaperID=? AND AuthorID=?) a 
            INNER JOIN Affiliations b ON a.AffiliationID=b.AffiliationID",
            array($paper_id, $author_id)
        );
        return $query->row_array();
    }

    public function get_conference($conference_id) {
        $query = $this->db->get_where('Conferences', array('ConferenceID' => $conference_id));
        return $query->row_array();
    }

    public function get_author_total_number($author_name) {
        $target = "( |^)".$author_name;
        $query = $this->db->query("SELECT COUNT(*) AS Num FROM Authors WHERE AuthorName REGEXP (?);", array($target));
        return $query->row_array()['Num'];
    }

    public function get_affi_total_number($affi_name) {
        $target = "( |^)".$affi_name;
        $query = $this->db->query(
            "SELECT COUNT(*) AS Num FROM Affiliations WHERE AffiliationName REGEXP (?);", 
            array($target)
        );
        return $query->row_array()['Num'];
    }

    public function get_conference_total_number($conference_name) {
        $target = "%".$conference_name."%";
        $query = $this->db->query(
            "SELECT COUNT(*) AS Num FROM Conferences WHERE ConferenceName LIKE (?);",
            array($target)
        );
        return $query->row_array()['Num'];
    }

    public function get_paper_total_number($paper_name) {
        $target = "( |^)".$paper_name;
        $query = $this->db->query(
            "SELECT COUNT(*) AS Num FROM Papers WHERE Title REGEXP (?);",
            array($target)
        );
        return $query->row_array()['Num'];
    }

    public function search_author($author_name, $begin=null, $num=null) {
        $target = "( |^)".$author_name;
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query("SELECT a.AuthorID AS AuthorID, a.AuthorName AS AuthorName,COUNT(b.PaperID) AS PaperNum FROM 
        (SELECT * FROM Authors WHERE AuthorName REGEXP (?) ) a 
        LEFT JOIN PaperAuthorAffiliation b ON a.AuthorID=b.AuthorID 
        GROUP BY AuthorID ORDER BY PaperNum DESC $limit;", array($target));
        return $query->result_array();
    }

    public function search_affi($affi_name, $begin=null, $num=null) {
        $target = "( |^)".$affi_name;
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query(
            "SELECT a.AffiliationID AS AffiliationID, a.AffiliationName AS AffiliationName, COUNT(b.PaperID) AS PaperNum FROM
            (SELECT * FROM Affiliations WHERE AffiliationName REGEXP (?) ) a
            LEFT JOIN PaperAuthorAffiliation b ON a.AffiliationID=b.AffiliationID
            GROUP BY AffiliationID ORDER BY PaperNum DESC $limit;",
            array($target)
        );
        return $query->result_array();
    }

    public function search_conference($conference_name, $begin=null, $num=null) {
        $target = "%".$conference_name."%";
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query(
            "SELECT a.ConferenceID AS ConferenceID, a.ConferenceName AS ConferenceName, COUNT(b.PaperID) AS PaperNum FROM
            (SELECT * FROM Conferences WHERE ConferenceName LIKE (?)) a
            LEFT JOIN Papers b ON a.ConferenceID=b.ConferenceID
            GROUP BY ConferenceID ORDER BY PaperNum DESC $limit;",
            array($target)
        );
        return $query->result_array();
    }

    public function search_paper($paper_name, $begin=null, $num=null) {
        $target = "( |^)".$paper_name;
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query(
            "SELECT a.PaperID AS PaperID,
            a.Title AS Title, 
            a.PaperPublishYear AS PaperPublishYear,
            a.ConferenceID AS ConferenceID,
            COUNT(b.ReferenceID) AS ReferenceCount FROM 
            (SELECT * FROM Papers WHERE Title REGEXP (?) ) a 
            LEFT JOIN PaperReference b ON a.PaperID=b.ReferenceID 
            GROUP BY PaperID ORDER BY ReferenceCount DESC, PaperID ASC $limit;",
            array($target)
        );
        return $query->result_array();
    }

    public function get_most_freq_affi($author_id) {
        $query = $this->db->query(
            "SELECT a.AffiliationID AS AffiliationID, AffiliationTimes, AffiliationName FROM 
            (SELECT AffiliationID,AffiliationTimes FROM 
            (SELECT AffiliationID, COUNT(AffiliationID) AS AffiliationTimes FROM PaperAuthorAffiliation WHERE AuthorID=? GROUP BY AffiliationID) a 
            ORDER BY AffiliationTimes DESC LIMIT 1) a 
            INNER JOIN Affiliations b On a.AffiliationID=b.AffiliationID;",
            array($author_id)
        );
        return $query->row_array();
    }

    public function get_most_freq_conf($author_id) {
        $query = $this->db->query(
            "SELECT COUNT(a.PaperID) AS Count, b.ConferenceID, ConferenceName FROM
            (SELECT DISTINCT(PaperID) FROM PaperAuthorAffiliation WHERE AuthorID=?) a
            INNER JOIN Papers b ON a.PaperID=b.PaperID
            INNER JOIN Conferences c ON b.ConferenceID=c.ConferenceID
            GROUP BY ConferenceID ORDER BY Count DESC;",
            array($author_id)
        );
        return $query->row_array();
    }

    public function get_most_freq_coau($author_id) {
        $query = $this->db->query(
            "SELECT SecondID, Numbers FROM Cooperations WHERE FirstID=? 
            AND Numbers=(SELECT MAX(Numbers) FROM Cooperations WHERE FirstID=?);",
            array($author_id, $author_id)
        );
        return $query->result_array();
    }

    public function get_author_pub_total_number($author_id) {
        $query = $this->db->query(
            "SELECT COUNT(PaperID) AS Num FROM PaperAuthorAffiliation WHERE AuthorID=?;",
            array($author_id)
        );
        return $query->row_array()['Num'];
    }

    public function get_author_affi_total_number($author_id) {
        $query = $this->db->query(
            "SELECT COUNT(DISTINCT(AffiliationID)) AS Num 
            FROM PaperAuthorAffiliation 
            WHERE AuthorID=?;",
            array($author_id)
        );
        return $query->row_array()['Num'];
    }

    public function get_author_conf_total_number($author_id) {
        $query = $this->db->query(
            "SELECT COUNT(DISTINCT(b.ConferenceID)) AS Num FROM 
            (SELECT PaperID FROM PaperAuthorAffiliation WHERE AuthorID=?) a 
            INNER JOIN Papers b ON a.PaperID=b.PaperID",
            array($author_id)
        );
        return $query->row_array()['Num'];
    }

    public function get_author_coau_total_number($author_id) {
        $query = $this->db->query(
            "SELECT COUNT(DISTINCT(SecondID)) AS Num FROM Cooperations WHERE FirstID=?;",
            array($author_id)
        );
        return $query->row_array()['Num'];
    }

    public function get_affi_auth_total_number($affi_id) {
        $query = $this->db->query(
            "SELECT COUNT(DISTINCT(AuthorID)) AS Num FROM PaperAuthorAffiliation WHERE AffiliationID=?;",
            array($affi_id)
        );
        return $query->row_array()['Num'];
    }

    public function get_affi_paper_total_number($affi_id) {
        $query = $this->db->query(
            "SELECT COUNT(DISTINCT(PaperID)) AS Num From PaperAuthorAffiliation WHERE AffiliationID=?",
            array($affi_id)
        );
        return $query->row_array()['Num'];
    }

    public function get_conf_paper_total_number($conf_id) {
        $query = $this->db->query(
            "SELECT COUNT(PaperID) AS Num FROM Papers WHERE ConferenceID=?;",
            array($conf_id)
        );
        return $query->row_array()['Num'];
    }

    public function get_conf_auth_total_number($conf_id) {
        $query = $this->db->query(
            "SELECT COUNT(DISTINCT(AuthorID)) AS Num FROM
            (SELECT PaperID FROM Papers WHERE ConferenceID=?) a
            INNER JOIN PaperAuthorAffiliation b ON a.PaperID=b.PaperID;",
            array($conf_id)
        );
        return $query->row_array()['Num'];
    }

    public function get_paper_ref_total_number($paper_id) {
        $query = $this->db->query(
            "SELECT COUNT(DISTINCT(ReferenceID)) AS Num FROM PaperReference WHERE PaperID=?",
            array($paper_id)
        );
        return $query->row_array()['Num'];
    }
    
    public function get_paper_cite_total_number($paper_id) {
        $query = $this->db->query(
            "SELECT COUNT(DISTINCT(PaperID)) AS Num FROM PaperReference WHERE ReferenceID=?",
            array($paper_id)
        );
        return $query->row_array()['Num'];
    }
    
    public function get_paper_author_total_number($paper_id) {
        $query = $this->db->query(
            "SELECT COUNT(DISTINCT(AuthorID)) AS Num FROM PaperAuthorAffiliation WHERE PaperID=?",
            array($paper_id)
        );
        return $query->row_array()['Num'];
    }

    public function search_paper_of_author($author_id, $begin=null, $num=null) {
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query(
            "SELECT a.PaperID AS PaperID, Title, PaperPublishYear, ConferenceID, COUNT(b.ReferenceID) AS ReferenceCount FROM
            (SELECT PaperID From PaperAuthorAffiliation WHERE AuthorID=?) a 
            LEFT JOIN PaperReference b ON a.PaperID=b.ReferenceID 
            INNER JOIN Papers c ON a.PaperID=c.PaperID
            GROUP BY PaperID ORDER BY ReferenceCount DESC, PaperID $limit;",
            $author_id);
        return $query->result_array();
    }

    public function search_affi_of_author($author_id, $begin=null, $num=null) {
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query(
            "SELECT a.AffiliationID, AffiliationName, AffiliationCount FROM
            (SELECT AffiliationID, COUNT(AffiliationID) AS AffiliationCount FROM
            (SELECT AffiliationID FROM 
            PaperAuthorAffiliation WHERE AuthorID=?) a
            GROUP BY AffiliationID ORDER BY AffiliationCount DESC) a
            INNER JOIN Affiliations b ON a.AffiliationID=b.AffiliationID $limit;",
            array($author_id)
        );
        return $query->result_array();
    }

    public function search_conf_of_author($author_id, $begin=null, $num=null) {
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query(
            "SELECT a.ConferenceID AS ConferenceID, ConferenceName FROM 
            (SELECT DISTINCT(b.ConferenceID) FROM 
            (SELECT PaperID FROM PaperAuthorAffiliation WHERE AuthorID=?) a 
            INNER JOIN 
            Papers b ON a.PaperID=b.PaperID) a 
            INNER JOIN Conferences b 
            ON a.ConferenceID=b.ConferenceID $limit;",
            array($author_id)
        );
        return $query->result_array();
    }
    
    public function search_coau_of_author($author_id, $begin=null, $num=null) {
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query(
            "SELECT CoAuthorID, c.AuthorName AS CoAuthorName, COUNT(b.PaperID) As ReferenceCount FROM            
            (SELECT DISTINCT(SecondID) AS CoAuthorID FROM Cooperations WHERE FirstID=?) a 
            INNER JOIN PaperAuthorAffiliation b ON a.CoAuthorID = b.AuthorID
            INNER JOIN Authors c ON a.CoAuthorID = c.AuthorID
            GROUP BY a.CoAuthorID ORDER BY ReferenceCount DESC, CoAuthorID ASC $limit;",
            array($author_id)
        );
        return $query->result_array();
    }

    public function search_author_of_affi($affi_id, $begin=null, $num=null) {
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query(
            "SELECT a.AuthorID AS AuthorID, c.AuthorName AS AuthorName, COUNT(b.PaperID) As PaperNum FROM
            (SELECT DISTINCT(AuthorID) FROM PaperAuthorAffiliation WHERE AffiliationID=?) a
            INNER JOIN PaperAuthorAffiliation b ON a.AuthorID = b.AuthorID
            INNER JOIN Authors c ON a.AuthorID = c.AuthorID
            GROUP BY a.AuthorID ORDER BY PaperNum DESC, AuthorID ASC $limit;",
            array($affi_id)
        );
        return $query->result_array();
    }

    public function search_paper_of_affi($affi_id, $begin=null, $num=null) {
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query(
            "SELECT a.PaperID AS PaperID, c.Title AS Title, COUNT(b.ReferenceID) AS ReferenceNum FROM
            (SELECT DISTINCT(PaperID) From PaperAuthorAffiliation WHERE AffiliationID=?) a 
            LEFT JOIN PaperReference b ON a.PaperID=b.ReferenceID 
            INNER JOIN Papers c ON a.PaperID=c.PaperID
            GROUP BY PaperID ORDER BY ReferenceNum DESC, PaperID $limit;",
            array($affi_id)
        );
        return $query->result_array();
    }

    public function search_paper_of_conf($conf_id, $begin=null, $num=null) {
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query(
            "SELECT a.PaperID AS PaperID, Title, PaperPublishYear, COUNT(b.ReferenceID) AS ReferenceCount FROM
            (SELECT PaperID FROM Papers WHERE ConferenceID=?) a 
            LEFT JOIN PaperReference b ON a.PaperID=b.ReferenceID 
            INNER JOIN Papers c ON a.PaperID=c.PaperID
            GROUP BY PaperID ORDER BY ReferenceCount DESC, PaperID $limit;",
            array($conf_id)
        );
        return $query->result_array();
    }

    public function search_author_of_conf($conf_id, $begin=null, $num=null) {
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query(
            "SELECT a.AuthorID AS AuthorID, c.AuthorName AS AuthorName, COUNT(DISTINCT(b.PaperID)) As PaperNum FROM
            (SELECT DISTINCT(AuthorID) FROM
            (SELECT PaperID FROM Papers WHERE ConferenceID=?) a
            INNER JOIN PaperAuthorAffiliation b ON a.PaperID=b.PaperID) a
            INNER JOIN PaperAuthorAffiliation b ON a.AuthorID = b.AuthorID
            INNER JOIN Authors c ON a.AuthorID = c.AuthorID
            GROUP BY a.AuthorID ORDER BY PaperNum DESC, AuthorID ASC $limit;",
            array($conf_id)
        );
        return $query->result_array();
    }

    public function search_author_of_paper($paper_id, $begin=null, $num=null) {
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query(
            "SELECT a.AuthorID AS AuthorID, AuthorName FROM
            (SELECT AuthorID, AuthorSequence FROM PaperAuthorAffiliation WHERE PaperID=?) a
            INNER JOIN Authors b ON a.AuthorID=b.AuthorID
            ORDER BY AuthorSequence $limit;",
            array($paper_id)
        );
        return $query->result_array();
    }

    public function search_ref_of_paper($paper_id, $begin=null, $num=null) {
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query(
            "SELECT a.PaperID AS PaperID, Title, PaperPublishYear, 
            COUNT(b.ReferenceID) AS ReferenceCount FROM
            (SELECT a.ReferenceID AS PaperID FROM
            (SELECT ReferenceID FROM PaperReference WHERE PaperID=?) a
            INNER JOIN Papers b ON a.ReferenceID=b.PaperID) a
            LEFT JOIN PaperReference b ON a.PaperID=b.ReferenceID 
            INNER JOIN Papers c ON a.PaperID=c.PaperID
            GROUP BY PaperID ORDER BY ReferenceCount DESC, PaperID $limit;",
            array($paper_id)
        );
        return $query->result_array();
    }

    public function search_cite_of_paper($paper_id, $begin=null, $num=null) {
        if($begin !== null && $num === null) {
            //limit 1 to $begin
            $limit = "limit $begin";
        } else if($begin !==null && $num !==null) {
            //limit $begin to $num
            $limit = "limit $begin, $num";
        } else {
            $limit = "";
        }
        $query = $this->db->query(
            "SELECT a.PaperID AS PaperID, Title, PaperPublishYear, 
            COUNT(b.ReferenceID) AS ReferenceCount FROM
            (SELECT a.PaperID AS PaperID FROM
            (SELECT PaperID FROM PaperReference WHERE ReferenceID=?) a
            INNER JOIN Papers b ON a.PaperID=b.PaperID) a
            LEFT JOIN PaperReference b ON a.PaperID=b.ReferenceID 
            INNER JOIN Papers c ON a.PaperID=c.PaperID
            GROUP BY PaperID ORDER BY ReferenceCount DESC, PaperID $limit;",
            array($paper_id)
        );
        return $query->result_array();
    }

    public function label()
	{
        $this->load->model('Label_model');
		$PaperID = $this->input->get('PaperID');
		$Title = $this->Label_model->recommend_Title($PaperID);
		$Title = $Title[0]['Title'];
		
		$result = $this->Label_model->recommend_label($PaperID);
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
		$data['Label'] = $label;
		var_dump($label);
		
	}
	
	
	public function paper_recommend()
	{
        $this->load->model('Label_model');
		$PaperID = $this->input->get('PaperID');
		$q = $PaperID;
		$result = $this->Label_model->recommend_reference($q);
		$i=0;
		$ReferenceID=[];
		foreach ($result as $row)
		{
			$ReferenceID[$i]=$row['ReferenceID'];//find all the references of this paper
			$i++;
		}
		$result = $this->Label_model->recommend_author($q);
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
			$result = $this->Label_model->recommend_paper_r($q);
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
			}
		}
		
		foreach ($AuthorID as $row)
		{
			$q = $row;
			$result = $this->Label_model->recommend_paper_a($q);//select PaperID from paper_author_affiliation where AuthorID='{$q}'
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
			}
		}
		
		$Title = $this->Label_model->recommend_Title($PaperID);
		$Title = $Title[0]['Title'];
		
		$result = $this->Label_model->recommend_label();
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
		
		$all_paper = $this->Label_model->recommend_allpaper();
		
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
			}		
		}
		
		foreach ($paper as $row)
			$recommend[$row]['Score'] = $recommend[$row]['Reference'] + $recommend[$row]['Author'] + $recommend[$row]['Label']; //calculate the score of recommendation
		
		
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
			$data['Recommend'][$i]['PaperID']=$paper[$i];
			$q = $paper[$i];
			$result = $this->Label_model->recommend_Title($q);//select Title from papers where PaperID='{$q}'
			$data['Recommend'][$i]['Title']=$result[0]['Title'];
			//echo "{$data['Recommend'][$i]['PaperID']} {$data['Recommend'][$i]['Title']} {$recommend[$paper[$i]]['Score']}<br>";//
		}
	}
}
