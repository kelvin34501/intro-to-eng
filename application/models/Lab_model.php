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
        $target = "\"".$author_id."\"";
        $command = "SELECT a.AffiliationID AS AffiliationID, AffiliationTimes, AffiliationName FROM 
        (SELECT AffiliationID,AffiliationTimes FROM 
        (SELECT AffiliationID, COUNT(AffiliationID) AS AffiliationTimes FROM PaperAuthorAffiliation WHERE AuthorID=$target GROUP BY AffiliationID) a 
        ORDER BY AffiliationTimes DESC LIMIT 1) a 
        INNER JOIN Affiliations b On a.AffiliationID=b.AffiliationID;";
        $query = $this->db->query($command);
        return $query->row_array();
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
            "SELECT a.PaperID AS PaperID, c.Title AS Title, COUNT(DISTINCT(b.ReferenceID)) AS ReferenceNum FROM
            (SELECT PaperID From PaperAuthorAffiliation WHERE AffiliationID=?) a 
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

    public function get_paper_basic($paper_id) {
        $target = "\"".$paper_id."\"";
        $command = "SELECT Title, ConferenceID, PaperPublishYear FROM Papers WHERE PaperID=$target;";
        $query = $this->db->query($command);
        return $query->row_array();
    }

    public function get_paper_links($paper_id) {
        $target = "\"".$paper_id."\"";
        $command = "SELECT a.AuthorID, AuthorName, AuthorSequence FROM 
            (SELECT AuthorID,AuthorSequence FROM PaperAuthorAffiliation WHERE PaperID=$target) a 
            INNER JOIN Authors b ON a.AuthorID=b.AuthorID ORDER BY AuthorSequence;";
        $query = $this->db->query($command);
        return $query->result_array();
    }

    public function get_cooperation($author_id) {
        $this->db->select('SecondID');
        $this->db->distinct();
        $query = $this->db->get_where('Cooperations', array('FirstID' => $author_id));
        return $query->result_array();
    }

    public function get_relationship($first_id, $second_id) {
        $this->db->select('IsAdvisor');
        $this->db->distinct();
        $query = $this->db->get_where('Cooperations', array('FirstID' => $first_id,
                                                            'SecondID' => $second_id));
        $flag = $query->row_array()['IsAdvisor'];
        return (int) $flag;
    }

    public function is_cooperated($first_id, $second_id) {
        $this->db->distinct();
        $query = $this->db->get_where('CooperationsDup', array('FirstID' => $first_id,
                                                            'SecondID' => $second_id));
        $r = $query->row_array();
        return $r !== NULL;
    }
}
