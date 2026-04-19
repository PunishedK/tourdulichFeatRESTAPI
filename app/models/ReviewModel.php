<?php

require_once ROOT . '/core/Model.php';


class ReviewModel extends Model {
    /**
     * @return object{avg_rating: ?float, review_count: int}
     */
    public function getStatsByPackageId($packageId) {
        $pid = (int) $packageId;
        $sql = 'SELECT ROUND(AVG(Rating), 1) AS avg_rating, COUNT(*) AS review_count
                FROM tbltourreviews WHERE PackageId = :pid';
        $q = $this->db->prepare($sql);
        $q->bindParam(':pid', $pid, PDO::PARAM_INT);
        $q->execute();
        $row = $q->fetch(PDO::FETCH_OBJ);
        if (!$row) {
            return (object) ['avg_rating' => null, 'review_count' => 0];
        }
        $row->review_count = (int) $row->review_count;
        $row->avg_rating = $row->avg_rating !== null ? (float) $row->avg_rating : null;
        return $row;
    }

    /**
     * @return array<int, object>
     */
    public function getReviewsByPackageId($packageId, $limit = 50) {
        $pid = (int) $packageId;
        $lim = max(1, min(100, (int) $limit));
        $sql = "SELECT r.ReviewId, r.PackageId, r.UserEmail, r.Rating, r.Note, r.RegDate, u.FullName
                FROM tbltourreviews r
                INNER JOIN tblusers u ON u.EmailId = r.UserEmail
                WHERE r.PackageId = :pid
                ORDER BY r.RegDate DESC
                LIMIT {$lim}";
        $q = $this->db->prepare($sql);
        $q->bindParam(':pid', $pid, PDO::PARAM_INT);
        $q->execute();
        return $q->fetchAll(PDO::FETCH_OBJ);
    }

    public function userHasReviewed($packageId, $email) {
        $pid = (int) $packageId;
        $sql = 'SELECT ReviewId FROM tbltourreviews WHERE PackageId = :pid AND UserEmail = :email LIMIT 1';
        $q = $this->db->prepare($sql);
        $q->bindParam(':pid', $pid, PDO::PARAM_INT);
        $q->bindParam(':email', $email, PDO::PARAM_STR);
        $q->execute();
        return (bool) $q->fetch(PDO::FETCH_OBJ);
    }

    public function getUserReview($packageId, $email) {
        $pid = (int) $packageId;
        $sql = 'SELECT ReviewId, PackageId, UserEmail, Rating, Note, RegDate
                FROM tbltourreviews
                WHERE PackageId = :pid AND UserEmail = :email
                LIMIT 1';
        $q = $this->db->prepare($sql);
        $q->bindParam(':pid', $pid, PDO::PARAM_INT);
        $q->bindParam(':email', $email, PDO::PARAM_STR);
        $q->execute();
        return $q->fetch(PDO::FETCH_OBJ);
    }

    public function addReview($packageId, $userEmail, $rating, $note) {
        if ($this->userHasReviewed($packageId, $userEmail)) {
            return false;
        }
        $pid = (int) $packageId;
        $rating = (int) $rating;
        if ($rating < 1 || $rating > 5) {
            return false;
        }
        $note = mb_substr(trim($note), 0, 1000, 'UTF-8');
        $sql = 'INSERT INTO tbltourreviews (PackageId, UserEmail, Rating, Note) VALUES (:pid, :email, :rating, :note)';
        $q = $this->db->prepare($sql);
        $q->bindParam(':pid', $pid, PDO::PARAM_INT);
        $q->bindParam(':email', $userEmail, PDO::PARAM_STR);
        $q->bindParam(':rating', $rating, PDO::PARAM_INT);
        $q->bindParam(':note', $note, PDO::PARAM_STR);
        return $q->execute();
    }

    public function updateReview($packageId, $userEmail, $rating, $note) {
        $pid = (int) $packageId;
        $rating = (int) $rating;
        if ($rating < 1 || $rating > 5) {
            return false;
        }
        $note = mb_substr(trim($note), 0, 1000, 'UTF-8');
        $sql = 'UPDATE tbltourreviews
                SET Rating = :rating, Note = :note, RegDate = NOW()
                WHERE PackageId = :pid AND UserEmail = :email';
        $q = $this->db->prepare($sql);
        $q->bindParam(':rating', $rating, PDO::PARAM_INT);
        $q->bindParam(':note', $note, PDO::PARAM_STR);
        $q->bindParam(':pid', $pid, PDO::PARAM_INT);
        $q->bindParam(':email', $userEmail, PDO::PARAM_STR);
        return $q->execute();
    }

    public function deleteReview($packageId, $userEmail) {
        $pid = (int) $packageId;
        $sql = 'DELETE FROM tbltourreviews WHERE PackageId = :pid AND UserEmail = :email';
        $q = $this->db->prepare($sql);
        $q->bindParam(':pid', $pid, PDO::PARAM_INT);
        $q->bindParam(':email', $userEmail, PDO::PARAM_STR);
        return $q->execute();
    }
}
