<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book_model extends CI_Model {

	// insert to database
	var $table = "books";

	public function book_add($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	// ambil data dari table database
	public function get_all_book($table)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('id','DESC');

		return $query = $this->db->get();	
	}

	// detail data for edit
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('book_id', $id);

		return $query = $this->db->get();
	}

	// update
	public function book_update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}


	// delete
	public function delete_by_id($id)
	{
		$this->db->where('book_id', $id);
		$this->db->delete($this->table);
	}

}

/* End of file Book_model.php */
/* Location: ./application/models/Book_model.php */