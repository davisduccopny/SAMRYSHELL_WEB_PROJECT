<?php 
    class NotificationModel {
        private $conn;
        public function __construct($conn) {
            $this->conn = $conn;
        }
        public function insertNotification($content, $description, $customer_id) {
            $query = "INSERT INTO notification (content,description, customer_id) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssi", $content, $description, $customer_id);
            return $stmt->execute();
        }
        public function deleteNotification ($not_id){
            $query = "DELETE FROM notification WHERE id = ? ";
            $stmt = $this->conn->prepare($query);
            $stmt -> bind_param ("i", $not_id);
            $stmt -> execute();
        }

    }

?>