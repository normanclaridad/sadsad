<?php
require_once('Models.php');
class Requested_dances extends Models {
    private static $instance = null;
    protected $db;
    private $table;
    public function __construct() {
        require_once($this->getDocumentRoot() . '/inc/conn.php');
        $this->db = DB::getInstance();
        $this->table = 'requested_dances';
    }

    public function getWhere($where = '', $sortBy = '') {
        $sql = "SELECT * FROM $this->table";
        
        if(!empty($where)) {
            $sql .= " $where";
        }

        if(!empty($sortBy)) {
            $sql .= " ORDER BY $sortBy ";
        }

        $rows = $this->db->select($sql);
        return $rows;
    }

    public function insertData($data) {
        $sql = "INSERT INTO $this->table (";
        $sql .= implode(",", array_keys($data)) . ') VALUES ';            
        $sql .= "('" . implode("','", array_values($data)) . "')";
        $this->db->exec($sql);
        return $this->db->lastInsertId($sql);
    }

    public function updateData($data, $where) {
        $set = [];
        foreach($data as $key => $value) {
            $set[] = "$key='$value'";
        }
        
        $sql = "UPDATE $this->table SET ". implode(', ', $set);
        $sql .= " WHERE $where";
        return $this->db->exec($sql);
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id=" . $id;
        return $this->db->exec($sql);
    }

    public function getJoinWhere($where = '', $sortBy = 'rd.id DESC', $startFrom = 0, $pageNo = 20, $enableLimit = 'Y') {
        $sql = "SELECT rd.*, dc.name AS dance_category_name
                FROM requested_dances rd
                JOIN dance_categories dc ON dc.id = rd.dance_category_id
                WHERE rd.status != 'D'
                ";
        
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";

        if($enableLimit == 'Y') {
            $sql .= " LIMIT $startFrom, $pageNo";
        }

        $rows = $this->db->select($sql);
        return $rows;
    }

    public function getTotal($where = '', $sortBy = 'rd.id ASC') {
        $sql = "SELECT COUNT(*) AS total_count
                FROM requested_dances rd
                JOIN dance_categories dc ON dc.id = rd.dance_category_id
                WHERE rd.status != 'D'";
        
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql, 'assoc');
        return $rows['total_count'];
    }

    public function getCurachaRequestDance($where = '', $sortBy = 'id ASC') {
        $sql = "SELECT SUM(amount) AS total 
                FROM requested_dances 
                WHERE 
                status != 'D'";
        
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql, 'assoc');
        return $rows['total'];
    }

    public function getCurachaRequestDanceDetails($where = '', $sortBy = 'rd.id ASC') {
        $sql = "SELECT rd.*, dc.name AS dance_category_name 
                FROM requested_dances rd
                JOIN dance_categories dc ON dc.id = rd.dance_category_id
                WHERE rd.status != 'D'";
        
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }
}