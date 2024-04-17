<?php
require_once('Models.php');
class Transactions extends Models {
    private static $instance = null;
    protected $db;
    private $table;
    public function __construct() {
        require_once($this->getDocumentRoot() . '/inc/conn.php');
        $this->db = DB::getInstance();
        $this->table = 'transactions';
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

    /**
     * generateTransactionNo
     * Format YY-XXXXX (23-00001)
     * return @mixed;
     */
    public function generateTransactionNo() : string {
        $currentYear = date('Y');
        $year = date('y');
        $sql = "SELECT COUNT(*) AS total_no FROM transactions WHERE year(created_at) = $currentYear";
        // echo $sql;
        $rows = $this->db->select($sql, 'assoc');

        $count = $rows['total_no'] + 1;
        $sequential = str_pad($count, 5, '0', STR_PAD_LEFT);
        $billNo = $year . '-' . $sequential;
        return $billNo;
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

    public function getJoinWhere($where = '', $sortBy = 'st.id DESC', $startFrom = 0, $pageNo = 20, $enableLimit = 'Y') {
        $sql = "SELECT t.*, u.first_name, u.last_name 
                FROM transactions t
                LEFT JOIN users u ON u.id = t.created_by
                WHERE t.status != 'D'
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

    public function getTotal($where = '', $sortBy = 'un.id ASC') {
        $sql = "SELECT COUNT(*) AS total_count
                FROM transactions t
                LEFT JOIN users u ON u.id = t.created_by
                WHERE t.status != 'D'";
        
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql, 'assoc');
        return $rows['total_count'];
    }

    public function getSalesCount($where = '', $sortBy = 't.id ASC') {
        $sql = "SELECT SUM(qty) AS sales FROM transactions t 
                JOIN transaction_details td ON td.transaction_id = t.id
                WHERE t.status != 'D'";
        
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql, 'assoc');
        return $rows['sales'];
    }
}