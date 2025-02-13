<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Dashboard extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dossier_model', 'bm');
        $this->isLoggedIn();
        $this->module = 'Dashboard';
    }


    public function index()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {

           $analyses = $this->db->query('select * from analyses')->result();
           $dossiers = $this->db->query('SELECT * from dossiers group by patient_id')->result();
           $data = $this->bm->getAnalyses();

            $this->global['pageTitle'] = 'GSA : Dashboard';

            $this->loadViews("general/dashboard", $this->global, ['analyses'=>count($analyses),'dossiers'=>count($dossiers),'data'=>$data], NULL);
        }
    }

}
