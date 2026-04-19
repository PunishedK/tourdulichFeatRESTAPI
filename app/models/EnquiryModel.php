<?php

require_once ROOT . '/core/Model.php';

class EnquiryModel extends Model {
    public function createEnquiry($fname, $email, $mobile, $subject, $description) {
        $sql = 'INSERT INTO tblenquiry (FullName, EmailId, MobileNumber, Subject, Description, Status) VALUES (:fname, :email, :mobile, :subject, :description, 0)';
        $query = $this->db->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $query->bindParam(':subject', $subject, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    /**
     * @return array<int, object>
     */
    public function getByEmail($email) {
        $sql = 'SELECT * FROM tblenquiry WHERE EmailId = :email ORDER BY PostingDate DESC';
        $query = $this->db->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id) {
        $id = (int) $id;
        $sql = 'SELECT * FROM tblenquiry WHERE id = :id LIMIT 1';
        $query = $this->db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function setAdminReply($id, $replyText) {
        $id = (int) $id;
        $replyText = trim($replyText);
        if ($id <= 0 || $replyText === '') {
            return false;
        }
        $sql = 'UPDATE tblenquiry SET AdminReply = :reply, ReplyDate = NOW(), Status = 1 WHERE id = :id';
        $query = $this->db->prepare($sql);
        $query->bindParam(':reply', $replyText, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
}
