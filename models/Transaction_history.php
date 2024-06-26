<?php
require_once('Models.php');
class Transaction_history extends Models {
    private static $instance = null;
    protected $db;
    private $table;
    public function __construct() {
        require_once($this->getDocumentRoot() . '/inc/conn.php');
        $this->db = DB::getInstance();
        $this->table = 'transaction_history';
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

    public function getGrossRevenue($where = '', $sortBy = 't.id ASC') {
        $sql = "SELECT SUM((td.price - pr.original_price)*td.qty) AS revenue, SUM(t.total_amount) AS gross 
                FROM transactions t 
                JOIN transaction_details td ON td.transaction_id = t.id
                JOIN prices pr ON pr.product_id = td.product_id
                WHERE t.status != 'D'";
        
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql, 'assoc');
        return $rows;
    }

    public function getTransactions($where = '', $sortBy = 't.id ASC') {
        $sql = "SELECT t.*, e.name AS event_name 
                FROM transactions t
                JOIN events e ON e.id = t.event_id
                WHERE t.status != 'D'";
        
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
    }
}