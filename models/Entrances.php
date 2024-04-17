<?php
require_once('Models.php');
class Entrances extends Models {
    private static $instance = null;
    protected $db;
    private $table;
    public function __construct() {
        require_once($this->getDocumentRoot() . '/inc/conn.php');
        $this->db = DB::getInstance();
        $this->table = 'entrances';
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

    public function getJoinWhere($where = '', $sortBy = 'e.id DESC', $startFrom = 0, $pageNo = 20, $enableLimit = 'Y') {
        $sql = "SELECT e.*, e.name AS event_name 
                FROM $this->table e
                LEFT JOIN events et ON et.id = e.event_id
                WHERE e.status != 'D'
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

    public function getTotal($where = '', $sortBy = 'e.id ASC') {
        $sql = "SELECT COUNT(*) AS total_count
                FROM $this->table e
                LEFT JOIN events et ON et.id = e.event_id
                WHERE e.status != 'D'";
        
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql, 'assoc');
        return $rows['total_count'];
    }

    /**
     * generateTransactionNo
     * Format YY-E-XXXXX (23-E-00001)
     * return @mixed;
     */
    public function generateTransactionNo() : string {
        $currentYear = date('Y');
        $year = date('y');
        $sql = "SELECT COUNT(*) AS total_no FROM entrances WHERE year(created_at) = $currentYear";
        // echo $sql;
        $rows = $this->db->select($sql, 'assoc');

        $count = $rows['total_no'] + 1;
        $sequential = str_pad($count, 5, '0', STR_PAD_LEFT);
        $trxnNo = $year . '-E-' . $sequential;
        return $trxnNo;
    }

    public function getEntranceRevenue($where = '', $sortBy = 'id ASC') {
        $sql = "SELECT SUM(total) AS total 
                FROM entrances
                WHERE status != 'D'";
        
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql, 'assoc');
        return $rows['total'];
    }

    public function getEntranceByCategory($where = '') {
        $sql = "SELECT ed.name, SUM(ed.qty) AS quantity
                FROM entrances e
                JOIN entrance_details ed ON ed.entrance_id = e.id
                WHERE e.status != 'D'";
        
        if(!empty($where)) {
            $sql .= " $where";
        }

        $rows = $this->db->select($sql);
        return $rows;
    }
}