<div class="main-content">
    <section class="section">
        <h3>Data himpunan</h3>
        <hr>
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#himpunanadd">Tambah
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
                                <th>Nama Himpunan</th>
                                <th>Nilai</th>
                                <th>Keterangan Himpunan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $a = "INNER JOIN variabel ON himpunan.idvariabel = variabel.idvariabel";
                            $query = $kon->query("SELECT * FROM himpunan $a");
                            foreach ($query as $key) {
                                $nama = "himpunan_del";
                                $id = $key['idhimpunan'];
                                $data = $key['namahimpunan'];
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $key['namavariabel'] ?></td>
                                    <td><?= $key['namahimpunan'] ?></td>
                                    <td><?= $key['nilai'] ?></td>
                                    <td><?= $key['kethimpunan'] ?></td>
                                    <td align="center">
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#himpunanedit<?= $key['idhimpunan'] ?>"><i data-feather="edit"></i>
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
<div class="modal fade" id="himpunanadd" tabindex="-1" role="dialog" aria-labelledby="himpunanaddTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="himpunanaddTitle">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" novalidate="" action="?p=aksi&form=himpunan_add" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Variabel</label>
                        <select class="form-control" name="idvariabel" required="">
                            <option value="">--Pilih Data--</option>
                            <?= variabel($row) ?>
                        </select>
                        <div class="invalid-feedback">
                            Nama Variabel Wajib Diisi?
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Himpunan</label>
                        <input type="text" class="form-control" name="namahimpunan" required="">
                        <div class="invalid-feedback">
                            Nama Himpunan Wajib Diisi?
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ket Himpunan</label>
                        <input type="text" class="form-control" name="kethimpunan" required="">
                        <div class="invalid-feedback">
                            Ket Himpunan Wajib Diisi?
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nilai Himpunan</label>
                        <input type="text" class="form-control" name="nilai" required="">
                        <div class="invalid-feedback">
                            Nilai Wajib Diisi?
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
    <div class="modal fade" id="himpunanedit<?= $key['idhimpunan'] ?>" tabindex="-1" role="dialog" aria-labelledby="himpunanedit<?= $key['idhimpunan'] ?>Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="himpunanedit<?= $key['idhimpunan'] ?>Title">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="needs-validation" novalidate="" action="?p=aksi&form=himpunan_edit&id=<?= $key['idhimpunan'] ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Variabel</label>
                            <select class="form-control" name="idvariabel" required="">
                                <option value="">--Pilih Data--</option>
                                <?= variabel($key['idvariabel']) ?>
                            </select>
                            <div class="invalid-feedback">
                                Nama Variabel Wajib Diisi?
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Himpunan</label>
                            <input type="text" class="form-control" name="namahimpunan" value="<?= $key['namahimpunan'] ?>" required="">
                            <div class="invalid-feedback">
                                Nama Himpunan Wajib Diisi?
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Ket Himpunan</label>
                            <input type="text" class="form-control" name="kethimpunan" value="<?= $key['kethimpunan'] ?>" required="">
                            <div class="invalid-feedback">
                                Ket Himpunan Wajib Diisi?
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nilai Himpunan</label>
                            <input type="text" class="form-control" name="nilai" value="<?= $key['nilai'] ?>" required="">
                            <div class="invalid-feedback">
                                Nilai Wajib Diisi?
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