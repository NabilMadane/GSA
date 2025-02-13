<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Labo (LaboController)
 * Labo Class to control labo related operations.
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 18 Jun 2022
 */
class Labo extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Labo_model', 'bm');
        $this->isLoggedIn();
        $this->module = 'Labo';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('labo/laboListing');
    }

    /**
     * This function is used to load the labo list
     */
    function laboListing()
    {
        if(!$this->hasListAccess())
        {
            $this->loadThis();
        }
        else
        {
            $searchText = '';
            if(!empty($this->input->post('searchText'))) {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->bm->laboListingCount($searchText);

			$returns = $this->paginationCompress ( "laboListing/", $count, 10 );

            $data['records'] = $this->bm->laboListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'GSA : Labo';

            $this->loadViews("labo/list", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function add()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->global['pageTitle'] = 'GSA : Add New Labo';

            $this->loadViews("labo/add", $this->global, NULL, NULL);
        }
    }

    /**
     * This function is used to add new user to the system
     */
    function addNewLabo()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('labo_name','Labo','trim|callback_html_clean|required|max_length[50]');

            if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $labo_name = $this->security->xss_clean($this->input->post('labo_name'));

                $laboInfo = array('labo_name'=>$labo_name);

                $result = $this->bm->addNewLabo($laboInfo);

                if($result > 0) {
                    $this->session->set_flashdata('success', 'New Labo created successfully');
                } else {
                    $this->session->set_flashdata('error', 'Labo creation failed');
                }

                redirect('labo/laboListing');
            }
        }
    }


    /**
     * This function is used load labo edit information
     * @param number $laboId : Optional : This is labo id
     */
    function edit($laboId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($laboId == null)
            {
                redirect('labo/laboListing');
            }

            $data['laboInfo'] = $this->bm->getLaboInfo($laboId);

            $this->global['pageTitle'] = 'GSA : Edit Labo';

            $this->loadViews("labo/edit", $this->global, $data, NULL);
        }
    }


    /**
     * This function is used to edit the user information
     */
    function editLabo()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $laboId = $this->input->post('laboId');

            $this->form_validation->set_rules('labo_name','Labo','trim|callback_html_clean|required|max_length[50]');

            if($this->form_validation->run() == FALSE)
            {
                $this->edit($laboId);
            }
            else
            {
                $labo_name = $this->security->xss_clean($this->input->post('labo_name'));


                $laboInfo = array('labo_name'=>$labo_name);

                $result = $this->bm->editLabo($laboInfo, $laboId);

                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Labo updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Labo updation failed');
                }

                redirect('labo/laboListing');
            }
        }
    }
    function deleteLabo()
    {

        $laboId = $this->input->post('laboId');

        $result = $this->bm->deleteLabo($laboId);

        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }


    }

    public function html_clean($s, $v)
    {
        return strip_tags((string) $s);
    }
}

?>