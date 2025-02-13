<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Labo_model (Labo Model)
 * Labo model class to get to handle labo related data 
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 18 Jun 2022
 */
class Labo_model extends CI_Model
{
    /**
     * This function is used to get the labo listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function laboListingCount($searchText)
    {
        $this->db->select('a.id , a.labo_name');
        $this->db->from('laboratoires as a');
        if(!empty($searchText)) {
            $likeCriteria = "(a.labo_name LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the labo listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function laboListing($searchText, $page, $segment)
    {
        $this->db->select('a.id , a.labo_name');
        $this->db->from('laboratoires as a');
        if(!empty($searchText)) {
            $likeCriteria = "(a.labo_name LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->order_by('a.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    /**
     * This function is used to add new labo to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewLabo($laboInfo)
    {
        $this->db->trans_start();
        $this->db->insert('laboratoires', $laboInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get labo information by id
     * @param number $laboId : This is labo id
     * @return array $result : This is labo information
     */
    function getLaboInfo($laboId)
    {
        $this->db->select('a.id , a.labo_name');
        $this->db->from('laboratoires as a');
        $this->db->where('id', $laboId);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * This function is used to update the labo information
     * @param array $laboInfo : This is labo updated information
     * @param number $laboId : This is labo id
     */
    function editLabo($laboInfo, $laboId)
    {
        $this->db->where('id', $laboId);
        $this->db->update('laboratoires', $laboInfo);
        return TRUE;
    }
    function deleteLabo($laboId)
    {
        $this->db->delete('laboratoires', array('id' => $laboId));

        return $this->db->affected_rows();
    }
}