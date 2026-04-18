<?php

require_once(ROOT . '/core/Model.php');

class IssueModel extends Model {
    public function getIssuesByUserEmail($email) {
        $sql = "SELECT * from tblissues where UserEmail=:email ORDER BY PostingDate DESC";
        $query = $this->db->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function createIssue($email, $issue, $description) {
        $sql = "INSERT INTO tblissues(UserEmail,Issue,Description) VALUES(:email,:issue,:description)";
        $query = $this->db->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':issue', $issue, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
}
