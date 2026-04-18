<?php

require_once(ROOT . '/core/Model.php');

class ApiBookingModel extends Model
{
    public function create($packageId, $userEmail, $fromDate, $toDate, $comment, $numberOfPeople, $totalPrice)
    {
        $status = 0;
        $sql = "INSERT INTO tblbooking(PackageId, UserEmail, FromDate, ToDate, Comment, NumberOfPeople, TotalPrice, status)
                VALUES(:packageId, :userEmail, :fromDate, :toDate, :comment, :numberOfPeople, :totalPrice, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':packageId', (int)$packageId, PDO::PARAM_INT);
        $stmt->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);
        $stmt->bindValue(':fromDate', $fromDate, PDO::PARAM_STR);
        $stmt->bindValue(':toDate', $toDate, PDO::PARAM_STR);
        $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindValue(':numberOfPeople', (int)$numberOfPeople, PDO::PARAM_INT);
        $stmt->bindValue(':totalPrice', (float)$totalPrice);
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$this->db->lastInsertId();
    }

    public function getById($bookingId)
    {
        $sql = "SELECT b.*, p.PackageName, p.PackagePrice
                FROM tblbooking b
                INNER JOIN tbltourpackages p ON p.PackageId = b.PackageId
                WHERE b.BookingId = :bookingId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':bookingId', (int)$bookingId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUserEmail($userEmail)
    {
        $sql = "SELECT b.*, p.PackageName, p.PackagePrice
                FROM tblbooking b
                INNER JOIN tbltourpackages p ON p.PackageId = b.PackageId
                WHERE b.UserEmail = :userEmail
                ORDER BY b.RegDate DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cancelByUser($bookingId, $userEmail)
    {
        $status = 2;
        $cancelledBy = 'u';
        $stmt = $this->db->prepare("UPDATE tblbooking SET status = :status, CancelledBy = :cancelledBy WHERE BookingId = :bookingId AND UserEmail = :userEmail");
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->bindValue(':cancelledBy', $cancelledBy, PDO::PARAM_STR);
        $stmt->bindValue(':bookingId', (int)$bookingId, PDO::PARAM_INT);
        $stmt->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getPackagePrice($packageId)
    {
        $stmt = $this->db->prepare("SELECT PackagePrice FROM tbltourpackages WHERE PackageId = :packageId");
        $stmt->bindValue(':packageId', (int)$packageId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (float)$row['PackagePrice'] : null;
    }
}
