<div class="main-content">
    <section class="section">
        <h3>Data Dataset</h3>
        <hr>
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#datasetadd">Tambah
                    Data</button>
            </div>
            <?= pesan($_GET['alert']) ?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    No
                                </th>
                                <th>Nama Lengkap</th>
                                <?php
                                $varial = $kon->query("SELECT * FROM variabel WHERE ketvariabel = 'Input' ORDER BY idvariabel");
                                foreach ($varial as $var) {
                                ?>
                                    <th><?= $var['namavariabel'] ?></th>
                                <?php } ?>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $a = "INNER JOIN variabel ON detail_dataset.idvariabel = variabel.idvariabel";
                            $query = $kon->query("SELECT * FROM dataset");
                            foreach ($query as $key) {
                                $nama = "dataset_del";
                                $id = $key['iddataset'];
                                $data = $key['namadataset'];
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $key['namadataset'] ?></td>

                                    <?php
                                    foreach ($varial as $var) {
                                        $dataset = $kon->query("SELECT * FROM detail_dataset  WHERE iddataset = '$key[iddataset]' and idvariabel = '$var[idvariabel]'");
                                        $rul = mysqli_fetch_array($dataset);
                                    ?>
                                        <td align="center">
                                            <?= $rul['nilai'] ?>
                                        </td>
                                    <?php } ?>
                                    <td align="center">
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#datasetedit<?= $key['iddataset'] ?>"><i data-feather="edit"></i>
                                        </button>
                                        <a class="btn btn-danger btn-sm" href="#" id="<?= $nama ?><?= $id ?>"><i
                                                data-feather="trash-2"></i></a>
                                    </td>
                                </tr>
                                <?= delete($nama, $id, $data) ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>


<!--Tambah Data-->
<div class="modal fade" id="datasetadd" tabindex="-1" role="dialog" aria-labelledby="datasetaddTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="datasetaddTitle">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" novalidate="" action="?p=aksi&form=dataset_add" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Dataset</label>
                        <input type="text" class="form-control" name="namadataset" required="">
                        <div class="invalid-feedback">
                            Nama Dataset Wajib Diisi?
                        </div>
                    </div>

                    <?php
                    $variabel = $kon->query("SELECT * FROM variabel WHERE ketvariabel = 'Input'");
                    foreach ($variabel as $row) {
                    ?>
                        <div class="form-group">
                            <label><?= $row['namavariabel'] ?></label>
                            <input type="hidden" class="form-control" name="idvariabel[]" value="<?= $row['idvariabel'] ?>"
                                required="">
                            <input type="number" class="form-control" name="nilai[]" required="">
                            <div class="invalid-feedback">
                                <?= $row['namavariabel'] ?> Wajib Diisi?
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php foreach ($query as $key) {  ?>
    <!--Edit Data-->
    <div class="modal fade" id="datasetedit<?= $key['iddataset'] ?>" tabindex="-1" role="dialog"
        aria-labelledby="datasetedit<?= $key['iddataset'] ?>Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="datasetedit<?= $key['iddataset'] ?>Title">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="needs-validation" novalidate="" action="?p=aksi&form=dataset_edit&id=<?= $key['iddataset'] ?>"
                    method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Dataset</label>
                            <input type="text" class="form-control" name="namadataset" value="<?= $key['namadataset'] ?>"
                                required="">
                            <div class="invalid-feedback">
                                Nama Dataset Wajib Diisi?
                            </div>
                        </div>

                        <?php
                        $a = "INNER JOIN variabel ON detail_dataset.idvariabel = variabel.idvariabel";
                        $variabel = $kon->query("SELECT * FROM detail_dataset $a WHERE iddataset = '$key[iddataset]' and  ketvariabel = 'Input'");
                        foreach ($variabel as $row) {
                        ?>
                            <div class="form-group">
                                <label><?= $row['namavariabel'] ?></label>
                                <input type="hidden" class="form-control" name="idvariabel[]" value="<?= $row['idvariabel'] ?>"
                                    required="">
                                <input type="number" class="form-control" name="nilai[]" value="<?= $row['nilai'] ?>"
                                    required="">
                                <div class="invalid-feedback">
                                    <?= $row['namavariabel'] ?> Wajib Diisi?
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php } ?>