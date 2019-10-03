<!--
<div class="wrapper">
    <div class="panel-body">
        <h4>Create Sales Type</h4>
        <hr/>
        <div class="form">
            <form method="POST" action="<?php echo base_url(); ?>backoffice/sales_type/update_sales_type">
                <div class="row">
<?php foreach ($saltype as $row) : ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Sales Type</label>
                                    <input type="text" name="nama_sales_type" value="<?php echo $row->nama_saltype; ?>" class="form-control" required>
                                    <input type="text" style="display:none;" name="idsaltype" value="<?php echo $row->idsaltype; ?>" readonly>
                                </div>
    <?php $gg = $this->db->query("SELECT idgratuity FROM rel_salestype WHERE idsaltype='$row->idsaltype'")->result(); ?>
    <?php
        foreach ($gg as $uu) :
            $idgrat[] = $uu->idgratuity;
        endforeach;
        ?>
                                <div class="form-group">
                                    <label for="">Gratuity</label><br>
    <?php foreach ($tip as $rw) : ?>
                                            <input type="checkbox" name="tip[]" id="tip" value="<?php echo $rw->idgratuity; ?>" <?= (in_array($rw->idgratuity, $idgrat) ? 'checked="checked"' : '') ?>><?php echo $rw->nama_gratuity; ?><br>
    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
    <?php $id_business = $this->session->userdata('id_business'); ?>
    <?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
                                <div class="form-group">
                                    <label for="">Business</label>
    <?php foreach ($bus as $rw) : ?>
                                            <input type="text" class="form-control" value="<?php echo $rw->nama_business; ?>" readonly>
                                            <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $rw->idbusiness; ?>" readonly>
    <?php endforeach; ?>
                                </div>
    <?php $out = $row->idoutlet; ?>
                                <div class="form-group">
                                    <label for="">Outlet</label>
                                    <select name="outlet" id="" class="form-control">
                                        <option value="0">-- Pilih Outlet --</option>
    <?php foreach ($comout as $rw) : ?>
                                                <option value="<?php echo $rw->idoutlet; ?>" <?php if ($rw->idoutlet == $out) echo 'selected="selected"'; ?>>
        <?php echo $rw->name_outlet; ?>
                                                </option>
    <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
<?php endforeach; ?>
                </div>
                <hr/>
                <a href="<?php echo base_url(); ?>backoffice/sales_type" type="button" class="btn btn-default">Back</a>
                <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#modal-success">Submit</button>
            </form>
        </div>
    </div>
</div>
-->


<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-body">
            <h4>Edit Sales Type</h4>
        </div>
    </div>

    <div class="form">
        <form id="validationForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/sales_type/update_sales_type">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body same_height">
                            <div class="form-group">
                                <label for="">Nama Sales Type</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="fa fa-dropbox" aria-hidden="true"></i></span>
                                    <?php
                                    $readonly = '';
                                    if (trim($row->lock) == '1') {
                                        $readonly = ' readonly="" ';
                                    }
                                    ?>
                                    <input type="text" name="nama_sales_type" value="<?php echo $row->nama_saltype; ?>" <?= $readonly ?> class="form-control" required>
                                    <input type="text" style="display:none;" name="idsaltype" value="<?php echo $row->idsaltype; ?>" readonly>
                                </div>
                            </div>
                            <?php $out = $row->idoutlet; ?>
                            <div class="form-group">
                                <label for="">Outlet</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="fa fa-dropbox" aria-hidden="true"></i></span>
                                    <select name="outlet" id="" class="form-control">
                                        <option value="0">-- Pilih Outlet --</option>
                                        <?php foreach ($comout as $rw) : ?>
                                            <option value="<?php echo $rw->idoutlet; ?>" <?php if ($rw->idoutlet == $out) echo 'selected="selected"'; ?>>
                                                <?php echo $rw->name_outlet; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <?php $id_business = $this->session->userdata('id_business'); ?>
                            <?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
                            <div class="form-group">
                                <label for="">Bisnis</label>
                                <?php foreach ($bus as $rw) : ?>
                                    <input type="text" class="form-control" value="<?php echo $rw->nama_business; ?>" readonly>
                                    <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $rw->idbusiness; ?>" readonly>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $gg = $this->db->query("SELECT idgratuity FROM rel_salestype WHERE idsaltype='$row->idsaltype'")->result(); ?>
                <?php
                foreach ($gg as $uu) :
                    $idgrat[] = $uu->idgratuity;
                endforeach;
                ?>
                <div class="col-md-4 hidden">
                    <div class="panel panel-default">
                        <div class="panel-body same_height">
                            <div class="form-group">
                                <label for="">Tip</label><br>
                                <table id="tableproduk" class="table table-bordered table-condensed table-strip">
                                    <thead>
                                        <tr>
                                            <th>Check</th>
                                            <th>Nama Produk</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($tip as $rw) : ?>
                                            <tr>
                                                <td><input type="checkbox" name="tip[]" id="tip" class="list-checkbox" value="<?php echo $rw->idgratuity; ?>" <?= (in_array($rw->idgratuity, $idgrat) ? 'checked="checked"' : '') ?>></td>
                                                <td><?php echo $rw->nama_gratuity; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <em id="error-checkbox"></em>
                                <i>Centang tip anda untuk memasukan tip ke dalam sales type ini</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <a href="<?php echo base_url(); ?>backoffice/sales_type" type="button" class="btn btn-default"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
                                <button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php require_once('validate_form.php') ?>