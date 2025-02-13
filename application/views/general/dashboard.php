<div class="content-wrapper" id="dashboard_container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Tableau de bord
        <small>Panneau de contrôle</small>
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3><?= $dossiers ?></h3>
                                <p>Dossiers</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-folder"></i>
                            </div>
                            <a href="<?= base_url(); ?>Dossier" class="small-box-footer">Nouveau dossier <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3><?= $analyses ?></h3>
                                <p>Analyses</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="<?= base_url(); ?>Analyse" class="small-box-footer">Nouveau analyse <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <div class="form-group">
                            <label for="dossier_price">Analyses</label>
                            <select class="required" multiple="multiple" style="width: 100%;" id="analyses" name="analyses[]" >

                                <?php
                                foreach ($data as $dt){ ?>
                                    <option value="<?= $dt->id ?>" data-price="<?= $dt->analyse_price ?>" ><?= $dt->analyse_name ?></option>
                                <?php   } ?>

                            </select>

                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-fuchsia">
                            <div class="inner">
                                <h3 id="total-price">0</h3>
                                <p>Prix Total</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-money"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--<div class="col-lg-3 col-xs-6">
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>1</h3>
                  <p>User</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php /*echo base_url(); */?>userListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>-->
            <!--<div class="col-lg-3 col-xs-6">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>65</h3>
                  <p>Reopened Issue</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>-->

          </div>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
        </div>
      </div>
    </section>
</div>