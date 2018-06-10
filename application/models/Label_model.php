<?php
class Lab_model extends CI_Model {
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