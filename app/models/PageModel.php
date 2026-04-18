<?php

require_once(ROOT . '/core/Model.php');

class PageModel extends Model {
    public function getPageByType($type) {
        $sql = "SELECT type,detail from tblpages where type=:type";
        $query = $this->db->prepare($sql);
        $query->bindParam(':type', $type, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
