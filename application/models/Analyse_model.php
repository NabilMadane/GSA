<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Analyse_model (Analyse Model)
 * Analyse model class to get to handle analyse related data 
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 18 Jun 2022
 */
class Analyse_model extends CI_Model
{
    /**
     * This function is used to get the analyse listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function analyseListingCount($searchText)
    {
        $this->db->select('a.id , a.analyse_name, a.analyse_price');
        $this->db->from('analyses as a');
        if(!empty($searchText)) {
            $likeCriteria = "(a.analyse_name LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the analyse listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function analyseListing($searchText, $page, $segment)
    {
        $this->db->select('a.id , a.analyse_name, a.analyse_price');
        $this->db->from('analyses as a');
        if(!empty($searchText)) {
            $likeCriteria = "(a.analyse_name LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->order_by('a.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    /**
     * This function is used to add new analyse to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewAnalyse($analyseInfo)
    {
        $this->db->trans_start();
        $this->db->insert('analyses', $analyseInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get analyse information by id
     * @param number $analyseId : This is analyse id
     * @return array $result : This is analyse information
     */
    function getAnalyseInfo($analyseId)
    {
        $this->db->select('a.id , a.analyse_name, a.analyse_price');
        $this->db->from('analyses as a');
        $this->db->where('id', $analyseId);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * This function is used to update the analyse information
     * @param array $analyseInfo : This is analyse updated information
     * @param number $analyseId : This is analyse id
     */
    function editAnalyse($analyseInfo, $analyseId)
    {
        $this->db->where('id', $analyseId);
        $this->db->update('analyses', $analyseInfo);
        
        return TRUE;
    }
    function deleteAnalyse($analyseId)
    {
        $this->db->delete('analyses', array('id' => $analyseId));

        return $this->db->affected_rows();
    }


}