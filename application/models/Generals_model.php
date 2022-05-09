
function get_data($table,$data) {
	$this->db->select(*)->where($data)->get($table)->result();
}
