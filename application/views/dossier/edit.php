<?php
$dossierId = $dossierInfo->id;
$ref = $dossierInfo->ref;
$first_name = $dossierInfo->first_name;
$last_name = $dossierInfo->last_name;
$age = $dossierInfo->age;
$date = $dossierInfo->date_update;
$phone = $dossierInfo->phone;
$description = $dossierInfo->description;
$patientId = $dossierInfo->patient_id;
$laboId = $dossierInfo->labo_id;
$reduction = $dossierInfo->reduction;

?>

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

                    <form role="form" action="<?php echo base_url() ?>dossier/editDossier" method="post" id="editAnalyse" role="form">
                        <input type="hidden" id="ref" name="ref" value="<?= $ref ?>">
                        <input type="hidden" id="dossierId" name="dossierId" value="<?= $dossierId ?>">
                        <input type="hidden" id="patientId" name="patientId" value="<?= $patientId ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">Nom</label>
                                        <input type="text" class="form-control required" value="<?= $first_name ?>" id="first_name" name="first_name" maxlength="256" />
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Prénom</label>
                                        <input type="text" class="form-control required" value="<?= $last_name ?>" id="last_name" name="last_name" maxlength="256" />
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="age">Age</label>
                                        <input type="number" class="form-control required" value="<?= $age ?>" id="age" name="age" maxlength="256" />
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dossier_name">Téléphone</label>
                                        <input type="text" class="form-control required" value="<?= $phone ?>" id="phone" name="phone" maxlength="256" />
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dossier_price">Analyses</label>
                                            <select class="required" multiple="multiple" style="width: 100%;" id="analyses" name="analyses[]" >
                                                <?php foreach ($analyses as $analyse): ?>
                                                    <option value="<?= $analyse->id ?>"
                                                        <?= in_array($analyse->id, $selected_analyses_ids) ? 'selected' : '' ?>>
                                                        <?= $analyse->analyse_name ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dossier_price">Labos</label>
                                            <select class="required" style="width: 100%;" id="labos" name="labos" >
                                                <?php
                                                foreach ($labos as $labo){ ?>
                                                    <option <?= $labo->id == $laboId ? 'selected' : '' ?> value="<?= $labo->id ?>"><?= $labo->labo_name ?></option>
                                                <?php   } ?>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Observation</label>
                                        <textarea class="form-control required" id="description" name="description"><?= $description ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="age">Date</label>
                                        <input type="text" class="form-control required" value="<?= $date ?>" id="date_" name="date_"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="reduction">Réduction</label>
                                    <div class="input-group">
                                        <input type="number" min="0" class="form-control" id="reduction" name="reduction" value="<?= $reduction ?>">
                                        <span class="input-group-addon">DH</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                           <!-- <input type="reset" class="btn btn-default" value="Reset" />-->
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