<?php
class SignupUserDB {
    private $conn;
    
    public function __construct() {
        $this->conn = new mysqli('localhost', 'admin', 'flamerootpassword', 'userDB');
        if ($this->conn->connect_error) {
            throw new Exception('userDB connection failed: ' . $this->conn->connect_error);
        }
        $this->conn->set_charset('utf8');
    }

    private function createNicknameTable($Nickname) {
        $tableName = $this->conn->real_escape_string($Nickname);
        $sql = "CREATE TABLE IF NOT EXISTS `$tableName` (
            NICKNAME VARCHAR(50) PRIMARY KEY,
            FLAG VARCHAR(100) DEFAULT NULL
        )";
        
        if (!$this->conn->query($sql)) {
            throw new Exception('Failed to create nickname table: ' . $this->conn->error);
        }
    }

    private function insertInitialData($Nickname) {
        $tableName = $this->conn->real_escape_string($Nickname);
        $stmt = $this->conn->prepare("INSERT INTO `$tableName` (NICKNAME) VALUES (?)");
        $stmt->bind_param("s", $Nickname);
        if (!$stmt->execute()) {
            throw new Exception('Failed to insert initial data: ' . $stmt->error);
        }
    }

    private function createDBUser($ID, $PW, $Nickname) {
        $escapedID = $this->conn->real_escape_string($ID);
        $escapedPW = $this->conn->real_escape_string($PW);
        $escapedNickname = $this->conn->real_escape_string($Nickname);

        // 사용자 생성
        $createUserSql = "CREATE USER IF NOT EXISTS '$escapedID'@'localhost' IDENTIFIED BY '$escapedPW'";
        if (!$this->conn->query($createUserSql)) {
            throw new Exception('Failed to create MySQL user: ' . $this->conn->error);
        }

        // 권한 부여
        $grantSql = "GRANT UPDATE ON userDB.`$escapedNickname` TO '$escapedID'@'localhost'";
        if (!$this->conn->query($grantSql)) {
            throw new Exception('Failed to grant permissions: ' . $this->conn->error);
        }

        // 권한 적용
        $this->conn->query("FLUSH PRIVILEGES");
    }

    private function cleanup($ID, $Nickname) {
        // 오류 발생 시 정리 작업
        $tableName = $this->conn->real_escape_string($Nickname);
        $escapedID = $this->conn->real_escape_string($ID);
        
        $this->conn->query("DROP TABLE IF EXISTS `$tableName`");
        $this->conn->query("DROP USER IF EXISTS '$escapedID'@'localhost'");
        $this->conn->query("FLUSH PRIVILEGES");
    }

    public function process($ID, $PW, $Nickname) {
        $this->conn->begin_transaction();

        try {
            $this->createNicknameTable($Nickname);
            $this->insertInitialData($Nickname);
            $this->createDBUser($ID, $PW, $Nickname);

            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollback();
            $this->cleanup($ID, $Nickname);
            throw $e;
        } finally {
            $this->conn->close();
        }
    }
} 