<?php
require_once('Models.php');
class Prices extends Models {
    private static $instance = null;
    protected $db;
    private $table;
    public function __construct() {
        require_once($this->getDocumentRoot() . '/inc/conn.php');
        $this->db = DB::getInstance();
        $this->table = 'prices';
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

    public function getJoinWhere($where = '', $sortBy = 'pr.id DESC', $startFrom = 0, $pageNo = 20, $enableLimit = 'Y') {
        $sql = "SELECT pr.*, p.name as product_name, un.name AS unit_name, e.name AS event_name  
                FROM $this->table pr
                LEFT JOIN products p ON p.id = pr.product_id
                LEFT JOIN units un ON un.id = pr.unit_id
                LEFT JOIN users u ON u.id = pr.created_by
                LEFT JOIN events e ON e.id = pr.event_id
                WHERE pr.status != 'D'
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
                FROM $this->table pr
                LEFT JOIN products p ON p.id = pr.product_id
                LEFT JOIN units un ON un.id = pr.unit_id
                LEFT JOIN users u ON u.id = pr.created_by
                LEFT JOIN events e ON e.id = pr.event_id
                WHERE pr.status != 'D'";
        
        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql, 'assoc');
        return $rows['total_count'];
    }

    public function getProductsWithPrice($where = '', $sortBy = '') {
        $sql = "SELECT pr.*, p.name as product_name, un.name AS unit_name, st.quantity, st.purchase
                FROM $this->table pr
                LEFT JOIN products p ON p.id = pr.product_id
                LEFT JOIN units un ON un.id = pr.unit_id
                LEFT JOIN users u ON u.id = pr.created_by
                LEFT JOIN stocks st ON st.product_id = pr.product_id
                WHERE pr.status != 'D' ";
        
        if(!empty($where)) {
            $sql .= " $where";
        }

        if(!empty($sortBy)) {
            $sql .= " ORDER BY $sortBy ";
        }

        $rows = $this->db->select($sql);
        return $rows;
    }    
}