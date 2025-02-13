<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Dossier_model (Dossier Model)
 * Dossier model class to get to handle dossier related data 
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 18 Jun 2022
 */
class Dossier_model extends CI_Model
{
    /**
     * This function is used to get the dossier listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function dossierListingCount($searchText)
    {

        // Initialize the base query
        $queryStr = "
        SELECT d.*, 
               CONCAT(p.first_name, ' ', p.last_name) AS full_name, 
                GROUP_CONCAT(a.analyse_name SEPARATOR ', ') AS analyses_names,
               p.age, p.phone, p.description, 
               SUM(a.analyse_price) as price,
               DATE_FORMAT(d.date_update, '%d/%m/%Y') AS update_date
        FROM dossiers as d
        JOIN analyses as a ON a.id = d.analyse_id
        JOIN patients as p ON p.id = d.patient_id";

        // Bindings array for the query
        $bindings = [];

        // Add search criteria if search text is provided
        if (!empty($searchText)) {
            $queryStr .= " WHERE CONCAT(p.first_name, ' ', p.last_name) LIKE ?";
            $bindings[] = "%{$searchText}%"; // Add wildcard for the LIKE clause
        }

        // Group by, order by, and limit
        $queryStr .= " GROUP BY d.patient_id";

        $query = $this->db->query($queryStr, $bindings);

        return $query->num_rows();

    }
    
    /**
     * This function is used to get the dossier listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function dossierListing($searchText, $page, $segment)
    {
        // Initialize the base query
        $queryStr = "
        SELECT d.*, 
               CONCAT(p.first_name, ' ', p.last_name) AS full_name, 
                GROUP_CONCAT(a.analyse_name SEPARATOR ', ') AS analyses_names,
               p.age, p.phone, p.description,l.labo_name, 
               SUM(a.analyse_price) as price,
               DATE_FORMAT(d.date_update, '%d/%m/%Y') AS update_date
        FROM dossiers as d
        JOIN analyses as a ON a.id = d.analyse_id
        JOIN laboratoires as l ON l.id = d.labo_id
        JOIN patients as p ON p.id = d.patient_id";

        // Bindings array for the query
        $bindings = [];

        // Add search criteria if search text is provided
        if (!empty($searchText)) {
            $queryStr .= " WHERE CONCAT(p.first_name, ' ', p.last_name) LIKE ?";
            $bindings[] = "%{$searchText}%"; // Add wildcard for the LIKE clause
        }

        // Group by, order by, and limit
        $queryStr .= "
        GROUP BY d.patient_id
        ORDER BY d.id DESC
        LIMIT ?, ?";

        // Add LIMIT parameters to the bindings
        $bindings[] = (int)$segment;
        $bindings[] = (int)$page;

        // Execute the query with bindings
        $query = $this->db->query($queryStr, $bindings);

        // Fetch and return results
        return $query->result();
    }



    /**
     * This function is used to add new dossier to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewDossier($analyses,$patientInfo,$labo,$date)
    {
        $this->db->trans_start();
        $this->db->insert('patients', $patientInfo);

        $patient_id = $this->db->insert_id();

        $_date = DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');

        foreach ($analyses as $analyse){
            $data = [
                'patient_id'=>$patient_id,
                'analyse_id'=>$analyse,
                'labo_id'=>$labo,
                'date_update'=>$_date,
            ];
            $this->db->insert('dossiers', $data);

        }

        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get dossier information by id
     * @param number $dossierId : This is dossier id
     * @return array $result : This is dossier information
     */

    function getDossierInfo($patient_id)
    {
        $this->db->select('a.id,a.patient_id,a.labo_id,a.date_update, p.first_name, p.last_name,p.age, p.phone, p.description',);
        $this->db->from('dossiers as a');
        $this->db->join('patients as p', 'a.patient_id = p.id',);
        $this->db->where('a.patient_id', $patient_id);
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->row();
        $data->date_update = date("d-m-Y", strtotime($data->date_update));
        return $data;
    }

    public function getSelectedAnalyses($patient_id) {
        $this->db->select('analyse_id');
        $this->db->from('dossiers');
        $this->db->where('patient_id', $patient_id);
        $query = $this->db->get();
        return array_column($query->result_array(), 'analyse_id');
    }



    /**
     * This function is used to update the dossier information
     * @param array $dossierInfo : This is dossier updated information
     * @param number $dossierId : This is dossier id
     */
    function editDossier($analyses, $patientInfo,$patientId,$labo,$date)
    {
        // Start the transaction
        $this->db->trans_start();

        // Update the patient record
        $this->db->where('id', $patientId);
        $this->db->update('patients', $patientInfo);



        // Delete existing dossiers for this patient.
        $this->db->where('patient_id', $patientId);
        $this->db->delete('dossiers');

        if ($this->db->affected_rows() === 0) {
            $this->db->trans_rollback();
            return FALSE;
        }
        $_date = DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        if (!empty($analyses)) {
            foreach ($analyses as $analyse) {
                $data = [
                    'patient_id' => $patientId,
                    'analyse_id' => $analyse,
                    'labo_id' => $labo,
                    'date_update' => $_date,
                ];
                $this->db->insert('dossiers', $data);
            }
        }

        // Complete the transaction and check its status
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    function deleteDossier($patientId)
    {
        $this->db->where('patient_id', $patientId);
        $this->db->delete('dossiers');
        $this->db->where('id', $patientId);
        $this->db->delete('patients');

        return $this->db->affected_rows();
    }

    function getAnalyses()
    {
        $this->db->select('*');
        $this->db->from('analyses');
        $query = $this->db->get();
        return $query->result();
    }

    function dossierData($startDate, $endDate,$labo_id)
    {
        // Check if start and end dates are the same
        if ($startDate == $endDate) {
            // Append times to cover the whole day
            $startDateTime = $startDate . " 00:00:00";
            $endDateTime   = $endDate . " 23:59:59";
        } else {
            // Use the dates as provided (adjust if necessary)
            $startDateTime = $startDate;
            $endDateTime   = $endDate;
        }

        $queryStr = "
        SELECT d.*, 
               CONCAT(p.first_name, ' ', p.last_name) AS full_name, 
               GROUP_CONCAT(a.analyse_name SEPARATOR ', ') AS analyses_names,
               p.age, p.phone, p.description, 
               SUM(a.analyse_price) AS price,
               DATE_FORMAT(d.date_update, '%d/%m/%Y') AS update_date
        FROM dossiers AS d
        JOIN analyses AS a ON a.id = d.analyse_id
        JOIN patients AS p ON p.id = d.patient_id
        JOIN laboratoires AS l ON l.id = d.labo_id
        WHERE d.date_update BETWEEN ? AND ? and d.labo_id=$labo_id
        GROUP BY d.patient_id";

        $query = $this->db->query($queryStr, [$startDateTime, $endDateTime]);

        return $query->result();
    }

    function getLabo()
    {
        $this->db->select('*');
        $this->db->from('laboratoires');
        $query = $this->db->get();
        return $query->result();
    }

}