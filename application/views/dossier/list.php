<div class="content-wrapper" id="dossier_container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Dossier Management
        <small>Ajouter, Modifier, Supprimer</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="col-xs-6">
                    <form  method="POST" action="<?php echo base_url() ?>dossier/generateDossierPDF">
                    <div class="col-xs-8">
                        <div class="input-group input-daterange">
                            <input type="text" id="startDate" name="startDate" class="form-control" value="">
                            <div class="input-group-addon">À</div>
                            <input type="text" id="endDate" name="endDate" class="form-control" value="">
                        </div>
                    </div>
                    <div class="col-xs-3">
                            <div class="form-group">
                                <select class="form-select form-control" aria-label="Default select example" id="_labos" name="_labos">
                                    <?php
                                    foreach ($labos as $labo){ ?>
                                        <option value="<?= $labo->id ?>"><?= $labo->labo_name ?></option>
                                    <?php   } ?>
                                </select>
                            </div>
                    </div>
                    <div class="col-xs-1 text-right">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Imprimer</button>
                        </div>
                    </div>

                    </form>
                </div>
                <div class="col-xs-6 text-right">
                    <div class="form-group">
                        <a class="btn btn-primary" href="<?php echo base_url(); ?>dossier/add"><i class="fa fa-plus"></i> Ajouter nouveau Dossier</a>
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Dossier List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>dossierListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Recherche"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>Noms et Prénoms</th>
                        <th>age</th>
                        <th>Analyses</th>
                        <th>prix</th>
                        <th>Réduction</th>
                        <th>Numéro téléphone</th>
                        <th>Observation</th>
                        <th>Date</th>
                        <th>Labo</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($records)){
                        foreach($records as $record){
                    ?>
                    <tr>
                        <td><?php echo $record->full_name ?></td>
                        <td><?php echo $record->age ?></td>
                        <td><?php echo $record->analyses_names ?></td>
                        <td><?php echo $record->price ?></td>
                        <td><?php echo $record->reduction ?></td>
                        <td><?php echo $record->phone ?></td>
                        <td><?php echo $record->description ?></td>
                        <td><?php echo $record->update_date ?></td>
                        <td><span class="badge btn-primary"><?php echo $record->labo_name ?></span></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'dossier/edit/'.$record->patient_id ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-sm btn-danger deleteDossier" href="#" data-patientid="<?php echo $record->patient_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
        </div>
      </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "dossierListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
