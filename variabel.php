<div class="main-content">
    <section class="section">
        <h3>Data Variabel</h3>
        <hr>
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#variabeladd">Tambah
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
                                <th>Nama Variabel</th>
                                <th>Keterangan Variabel</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = $kon->query("SELECT * FROM variabel");
                            foreach ($query as $key) {
                                $nama = "variabel_del";
                                $id = $key['idvariabel'];
                                $data = $key['namavariabel'];
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $key['namavariabel'] ?></td>
                                    <td><?= $key['ketvariabel'] ?></td>
                                    <td align="center">
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#variabeledit<?= $key['idvariabel'] ?>"><i data-feather="edit"></i>
                                        </button>
                                        <a class="btn btn-danger btn-sm" href="#" id="<?= $nama ?><?= $id ?>"><i data-feather="trash-2"></i></a>
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
<div class="modal fade" id="variabeladd" tabindex="-1" role="dialog" aria-labelledby="variabeladdTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="variabeladdTitle">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" novalidate="" action="?p=aksi&form=variabel_add" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Variabel</label>
                        <input type="text" class="form-control" name="namavariabel" required="">
                        <div class="invalid-feedback">
                            Nama Variabel Wajib Diisi?
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nama Variabel</label>
                        <select class="form-control" name="ketvariabel" required="">
                            <option value="">--Pilih Data--</option>
                            <?= ketvariabel($row) ?>
                        </select>
                        <div class="invalid-feedback">
                            Nama Variabel Wajib Diisi?
                        </div>
                    </div>

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
    <div class="modal fade" id="variabeledit<?= $key['idvariabel'] ?>" tabindex="-1" role="dialog" aria-labelledby="variabeledit<?= $key['idvariabel'] ?>Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="variabeledit<?= $key['idvariabel'] ?>Title">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="needs-validation" novalidate="" action="?p=aksi&form=variabel_edit&id=<?= $key['idvariabel'] ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Variabel</label>
                            <input type="text" class="form-control" name="namavariabel" value="<?= $key['namavariabel'] ?>" required="">
                            <div class="invalid-feedback">
                                Nama Variabel Wajib Diisi?
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Nama Variabel</label>
                            <select class="form-control" name="ketvariabel" required="">
                                <option value="">--Pilih Data--</option>
                                <?= ketvariabel($key['ketvariabel']) ?>
                            </select>
                            <div class="invalid-feedback">
                                Nama Variabel Wajib Diisi?
                            </div>
                        </div>

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