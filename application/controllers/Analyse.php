<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Analyse (AnalyseController)
 * Analyse Class to control analyse related operations.
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 18 Jun 2022
 */
class Analyse extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Analyse_model', 'bm');
        $this->isLoggedIn();
        $this->module = 'Analyse';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('analyse/analyseListing');
    }

    /**
     * This function is used to load the analyse list
     */
    function analyseListing()
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

            $count = $this->bm->analyseListingCount($searchText);

			$returns = $this->paginationCompress ( "analyseListing/", $count, 10 );

            $data['records'] = $this->bm->analyseListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'GSA : Analyse';

            $this->loadViews("analyse/list", $this->global, $data, NULL);
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
            $this->global['pageTitle'] = 'GSA : Add New Analyse';

            $this->loadViews("analyse/add", $this->global, NULL, NULL);
        }
    }

    /**
     * This function is used to add new user to the system
     */
    function addNewAnalyse()
    {
        if(!$this->hasCreateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('analyse_name','Analyse','trim|callback_html_clean|required|max_length[50]');
            $this->form_validation->set_rules('analyse_price','Prix','trim|callback_html_clean|required|max_length[1024]');

            if($this->form_validation->run() == FALSE)
            {
                $this->add();
            }
            else
            {
                $analyse_name = $this->security->xss_clean($this->input->post('analyse_name'));
                $analyse_price = $this->security->xss_clean($this->input->post('analyse_price'));

                $analyseInfo = array('analyse_name'=>$analyse_name, 'analyse_price'=>$analyse_price);

                $result = $this->bm->addNewAnalyse($analyseInfo);

                if($result > 0) {
                    $this->session->set_flashdata('success', 'New Analyse created successfully');
                } else {
                    $this->session->set_flashdata('error', 'Analyse creation failed');
                }

                redirect('analyse/analyseListing');
            }
        }
    }


    /**
     * This function is used load analyse edit information
     * @param number $analyseId : Optional : This is analyse id
     */
    function edit($analyseId = NULL)
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            if($analyseId == null)
            {
                redirect('analyse/analyseListing');
            }

            $data['analyseInfo'] = $this->bm->getAnalyseInfo($analyseId);

            $this->global['pageTitle'] = 'GSA : Edit Analyse';

            $this->loadViews("analyse/edit", $this->global, $data, NULL);
        }
    }


    /**
     * This function is used to edit the user information
     */
    function editAnalyse()
    {
        if(!$this->hasUpdateAccess())
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');

            $analyseId = $this->input->post('analyseId');

            $this->form_validation->set_rules('analyse_name','Analyse','trim|callback_html_clean|required|max_length[50]');
            $this->form_validation->set_rules('analyse_price','Prix','trim|callback_html_clean|required|max_length[1024]');

            if($this->form_validation->run() == FALSE)
            {
                $this->edit($analyseId);
            }
            else
            {
                $analyse_name = $this->security->xss_clean($this->input->post('analyse_name'));
                $analyse_price = $this->security->xss_clean($this->input->post('analyse_price'));


                $analyseInfo = array('analyse_name'=>$analyse_name, 'analyse_price'=>$analyse_price);

                $result = $this->bm->editAnalyse($analyseInfo, $analyseId);

                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Analyse updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Analyse updation failed');
                }

                redirect('analyse/analyseListing');
            }
        }
    }
    function deleteAnalyse()
    {

        $analyseId = $this->input->post('analyseId');

        $result = $this->bm->deleteAnalyse($analyseId);

        if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
        else { echo(json_encode(array('status'=>FALSE))); }


    }

    public function html_clean($s, $v)
    {
        return strip_tags((string) $s);
    }
}

?>