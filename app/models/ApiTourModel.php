<?php

require_once(ROOT . '/core/Model.php');

class ApiTourModel extends Model
{
    public function getAll($filters = [])
    {
        $sql = "SELECT * FROM tbltourpackages WHERE 1=1";
        $params = [];

        if (!empty($filters['q'])) {
            $sql .= " AND (PackageName LIKE :q OR PackageLocation LIKE :q)";
            $params[':q'] = '%' . $filters['q'] . '%';
        }

        if (!empty($filters['location'])) {
            $sql .= " AND PackageLocation = :location";
            $params[':location'] = $filters['location'];
        }

        if (isset($filters['min_price']) && $filters['min_price'] !== '') {
            $sql .= " AND PackagePrice >= :min_price";
            $params[':min_price'] = (int)$filters['min_price'];
        }

        if (isset($filters['max_price']) && $filters['max_price'] !== '') {
            $sql .= " AND PackagePrice <= :max_price";
            $params[':max_price'] = (int)$filters['max_price'];
        }

        $limit = isset($filters['limit']) ? max(1, (int)$filters['limit']) : 20;
        $offset = isset($filters['offset']) ? max(0, (int)$filters['offset']) : 0;

        $sql .= " ORDER BY Creationdate DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            if (in_array($key, [':min_price', ':max_price'], true)) {
                $stmt->bindValue($key, (int)$value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM tbltourpackages WHERE PackageId = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO tbltourpackages
                (PackageName, PackageType, TourDuration, PackageLocation, PackagePrice, PackageFetures, PackageDetails, PackageImage)
                VALUES (:name, :type, :duration, :location, :price, :features, :details, :image)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $data['PackageName'], PDO::PARAM_STR);
        $stmt->bindValue(':type', $data['PackageType'], PDO::PARAM_STR);
        $stmt->bindValue(':duration', $data['TourDuration'], PDO::PARAM_STR);
        $stmt->bindValue(':location', $data['PackageLocation'], PDO::PARAM_STR);
        $stmt->bindValue(':price', (int)$data['PackagePrice'], PDO::PARAM_INT);
        $stmt->bindValue(':features', $data['PackageFetures'], PDO::PARAM_STR);
        $stmt->bindValue(':details', $data['PackageDetails'], PDO::PARAM_STR);
        $stmt->bindValue(':image', $data['PackageImage'], PDO::PARAM_STR);
        $stmt->execute();
        return (int)$this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $sql = "UPDATE tbltourpackages
                SET PackageName = :name,
                    PackageType = :type,
                    TourDuration = :duration,
                    PackageLocation = :location,
                    PackagePrice = :price,
                    PackageFetures = :features,
                    PackageDetails = :details,
                    PackageImage = :image
                WHERE PackageId = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $data['PackageName'], PDO::PARAM_STR);
        $stmt->bindValue(':type', $data['PackageType'], PDO::PARAM_STR);
        $stmt->bindValue(':duration', $data['TourDuration'], PDO::PARAM_STR);
        $stmt->bindValue(':location', $data['PackageLocation'], PDO::PARAM_STR);
        $stmt->bindValue(':price', (int)$data['PackagePrice'], PDO::PARAM_INT);
        $stmt->bindValue(':features', $data['PackageFetures'], PDO::PARAM_STR);
        $stmt->bindValue(':details', $data['PackageDetails'], PDO::PARAM_STR);
        $stmt->bindValue(':image', $data['PackageImage'], PDO::PARAM_STR);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM tbltourpackages WHERE PackageId = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
