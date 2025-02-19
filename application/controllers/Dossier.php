<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Dompdf\Dompdf;

require APPPATH . '/libraries/BaseController.php';
require_once APPPATH . '../vendor/autoload.php';

/**
 * Class : Dossier (DossierController)
 * Dossier Class to control dossier related operations.
 * @author : Kishor Mali
 * @version : 1.5
 * @since : 18 Jun 2022
 */
class Dossier extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dossier_model', 'bm');
        $this->isLoggedIn();
        $this->module = 'Dossier';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        redirect('dossier/dossierListing');
    }

    /**
     * This function is used to load the dossier list
     */
    function dossierListing()
    {
        if (!$this->hasListAccess()) {
            $this->loadThis();
        } else {
            $searchText = '';
            if (!empty($this->input->post('searchText'))) {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->bm->dossierListingCount($searchText);

            $returns = $this->paginationCompress("dossierListing/", $count, 10);

            $data['records'] = $this->bm->dossierListing($searchText, $returns["page"], $returns["segment"]);
            $data['labos'] = $this->bm->getLabo();


            $this->global['pageTitle'] = 'GSA : Dossier';

            $this->loadViews("dossier/list", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function add()
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = 'GSA : Add New Dossier';
            $data['analyses'] = $this->bm->getAnalyses();
            $data['labos'] = $this->bm->getLabo();
            $this->loadViews("dossier/add", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to add new user to the system
     */
    function addNewDossier()
    {
        if (!$this->hasCreateAccess()) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('first_name', 'Nom', 'trim|callback_html_clean|required|max_length[50]');
            $this->form_validation->set_rules('last_name', 'Prenom', 'trim|callback_html_clean|required|max_length[50]');
            $this->form_validation->set_rules('date', 'Date', 'trim|required');
            // $this->form_validation->set_rules('analyses','Analyses','trim|callback_html_clean|required|max_length[1024]');

            if ($this->form_validation->run() == FALSE) {
                $this->add();
            } else {
                $first_name = $this->security->xss_clean($this->input->post('first_name'));
                $last_name = $this->security->xss_clean($this->input->post('last_name'));
                $age = $this->security->xss_clean($this->input->post('age'));
                $phone = $this->security->xss_clean($this->input->post('phone'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $patientId = $this->security->xss_clean($this->input->post('patientId'));
                $analyses = $this->input->post('analyses');
                $date = $this->input->post('date');
                $labo = $this->input->post('labos');
                $reduction = $this->input->post('reduction');


                $patientInfo = array('first_name' => $first_name, 'last_name' => $last_name, 'age' => $age, 'phone' => $phone);
                $dossiertInfo = (object)['reduction' => $reduction, 'date' => $date,'description' => $description];


                $result = $this->bm->addNewDossier($analyses, $patientInfo,$labo,$dossiertInfo,$patientId);

                if ($result > 0) {
                    $this->session->set_flashdata('success', 'Nouveau dossier créé avec succès');
                } else {
                    $this->session->set_flashdata('error', 'La création du dossier a échoué');
                }

                redirect('dossier/dossierListing');
            }
        }
    }


    /**
     * This function is used load dossier edit information
     * @param number $dossierId : Optional : This is dossier id
     */
    function edit($ref = NULL)
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            if ($ref == null) {
                redirect('dossier/dossierListing');
            }

            $data['dossierInfo'] = $this->bm->getDossierInfo($ref);

            $data['analyses'] = $this->bm->getAnalyses();
            $data['labos'] = $this->bm->getLabo();
            $data['selected_analyses_ids'] = $this->bm->getSelectedAnalyses($ref);
            $this->global['pageTitle'] = 'GSA : Edit Dossier';

            $this->loadViews("dossier/edit", $this->global, $data, NULL);
        }
    }


    /**
     * This function is used to edit the user information
     */
    function editDossier()
    {
        if (!$this->hasUpdateAccess()) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('first_name', 'Nom', 'trim|callback_html_clean|required|max_length[50]');
            $this->form_validation->set_rules('last_name', 'Prenom', 'trim|callback_html_clean|required|max_length[50]');
            $this->form_validation->set_rules('date_', 'Date', 'trim|required');

            $dossierId = $this->input->post('dossierId');
            $patientId = $this->input->post('patientId');
            $ref = $this->input->post('ref');



            if ($this->form_validation->run() == FALSE) {
                $this->edit($dossierId);
            } else {
                $first_name = $this->security->xss_clean($this->input->post('first_name'));
                $last_name = $this->security->xss_clean($this->input->post('last_name'));
                $age = $this->security->xss_clean($this->input->post('age'));
                $phone = $this->security->xss_clean($this->input->post('phone'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $analyses = $this->input->post('analyses');
                $date = $this->input->post('date_');
                $labo = $this->input->post('labos');
                $reduction = $this->input->post('reduction');

                $patientInfo = array('first_name' => $first_name, 'last_name' => $last_name, 'age' => $age, 'phone' => $phone);
                $dossiertInfo = (object)['reduction' => $reduction, 'date' => $date,'description' => $description];


                $result = $this->bm->editDossier($analyses, $patientInfo, $patientId,$labo,$dossiertInfo,$ref);

                if ($result == true) {
                    $this->session->set_flashdata('success', 'Dossier modifier avec succès');
                } else {
                    $this->session->set_flashdata('error', 'modification du dossier a échoué');
                }

                redirect('dossier/dossierListing');
            }
        }
    }

    function deleteDossier()
    {

        $ref = $this->input->post('ref');
        $patientId = $this->input->post('patientId');

        $result = $this->bm->deleteDossier($ref,$patientId);

        if ($result > 0) {
            echo(json_encode(array('status' => TRUE)));
        } else {
            echo(json_encode(array('status' => FALSE)));
        }

    }

    public function html_clean($s, $v)
    {
        return strip_tags((string)$s);
    }

    public function generateDossierPDF()
    {
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $labo_id = $this->input->post('_labos');

        $start_date_obj = date("Y-m-d", strtotime($startDate));;
        $end_date_obj = date("Y-m-d", strtotime($endDate));;

        // Fetch data
        $dossiers = $this->bm->dossierData($start_date_obj, $end_date_obj,$labo_id);

        // Load the HTML view as a string
        $htmlContent = $this->load->view('dossier/template', ['dossiers' => $dossiers], true);

        // Load DOMPDF
        $dompdf = new Dompdf();

        // Load HTML into DOMPDF
        $dompdf->loadHtml($htmlContent);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Output the PDF for download
        $dompdf->stream("List_analyse.pdf", ["Attachment" => true]);
    }

    // Search patients
    public function search() {
        $query = $this->input->post('query');
        $patients = $this->bm->searchPatients($query);

        if (!empty($patients)) {
            foreach ($patients as $patient) {
                echo "<li class='patient-option' data-id='{$patient->id}' data-firstName='{$patient->first_name}' data-lastName='{$patient->last_name}' data-age='{$patient->age}' data-phone='{$patient->phone}'>
                        {$patient->first_name} {$patient->last_name}
                       </li>";
            }
        } else {
            echo "";
        }
    }

}

