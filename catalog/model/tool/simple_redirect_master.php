<?php

/**
 * @property DB $db
 */
class ModelToolSimpleRedirectMaster extends Model {

    /**
     * @param string $from
     * @param int $store_id
     *
     * @return array
     */
    public function getRedirect($from, $store_id = 0) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "srm_redirect` WHERE `from` = '" . $this->db->escape($from) . "' AND `store_id` = '" . (int)$store_id . "' AND `status` = '1' LIMIT 1");

	    if ($query->num_rows) {
	    	return array(
			    'redirect_id' => (int)$query->row['redirect_id'],
			    'from' => $query->row['from'],
			    'to' => $query->row['to'],
			    'code' => (int)$query->row['code'],
			    'store_id' => isset($query->row['store_id']) ? (int)$query->row['store_id'] : 0,
			    'status' => (int)$query->row['status']
		    );
	    }

        return array();
    }

    /**
     * @return bool
     */
    public function isModuleEnabled() {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension` WHERE `type` = 'module' AND `code` = 'simple_redirect_master'");

        return $query->num_rows > 0;
    }
}