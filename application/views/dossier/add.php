<div class="content-wrapper" id="dossier_container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Gestion des dossiers
        <small>Ajouter / Modifier dossier</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Entrez les détails du dossier</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addDossier" action="<?php echo base_url() ?>dossier/addNewDossier" method="post" role="form">
                       <input type="hidden" name="patientId" id="patientId">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="first_name">Nom</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('first_name'); ?>" id="first_name" name="first_name" maxlength="256" />
                                        <ul class="styled-list" id="patientList"></ul>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Prénom</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('last_name'); ?>" id="last_name" name="last_name" maxlength="256" />
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="age">Age</label>
                                        <input type="number" min="1" class="form-control required" value="<?php echo set_value('age'); ?>" id="age" name="age" maxlength="256" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dossier_name">Téléphone</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('phone'); ?>" id="phone" name="phone" maxlength="256" />
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dossier_price">Analyses</label>
                                            <select class="required" multiple="multiple" style="width: 100%;" id="analyses" name="analyses[]" >
                                                <?php
                                                foreach ($analyses as $analyse){ ?>
                                                    <option value="<?= $analyse->id ?>"><?= $analyse->analyse_name ?></option>
                                                <?php   } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dossier_price">Labos</label>
                                            <select class="required" style="width: 100%;" id="labos" name="labos" >
                                                <?php
                                                foreach ($labos as $labo){ ?>
                                                    <option <?= $labo->id == 1 ? 'selected' : '' ?> value="<?= $labo->id ?>"><?= $labo->labo_name ?></option>
                                                <?php   } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Observation</label>
                                        <textarea class="form-control required" id="description" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('date'); ?>" id="date" name="date" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="reduction">Réduction</label>
                                    <div class="input-group">
                                        <input type="number" min="0" class="form-control" id="reduction" name="reduction" value="<?php echo set_value('reduction'); ?>">
                                        <span class="input-group-addon">DH</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
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
    </section>
    
</div>