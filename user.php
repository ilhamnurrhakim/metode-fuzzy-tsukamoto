<div class="main-content">
    <section class="section">
        <h3>Data User</h3>
        <hr>
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#useradd">Tambah
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
                                <th>Posisi</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = $kon->query("SELECT * FROM user");
                            foreach ($query as $key) {
                                $nama = "user_del";
                                $id = $key['iduser'];
                                $data = $key['namalengkap'];
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $key['namalengkap'] ?></td>
                                    <td><?= $key['posisi'] ?></td>
                                    <td align="center">
                                        <div class="badge <?= ($key['status'] == 'Aktif') ? 'bg-success' : 'bg-danger' ?>  badge-shadow">
                                            <?= $key['status'] ?></div>
                                    </td>
                                    <td align="center">
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#useredit<?= $key['iduser'] ?>"><i data-feather="edit"></i>
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
<div class="modal fade" id="useradd" tabindex="-1" role="dialog" aria-labelledby="useraddTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="useraddTitle">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" novalidate="" action="?p=aksi&form=user_add" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" name="namalengkap" required="">
                        <div class="invalid-feedback">
                            Nama Lengkap Wajib Diisi?
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" required="">
                        <div class="invalid-feedback">
                            Username Wajib Diisi?
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required="">
                        <div class="invalid-feedback">
                            Password Wajib Diisi?
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Posisi</label>
                        <select class="form-control" name="posisi" required="">
                            <option value="">--Pilih Data--</option>
                            <?= posisi($row) ?>
                        </select>
                        <div class="invalid-feedback">
                            Posisi Wajib Diisi?
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" required="">
                            <option value="">--Pilih Data--</option>
                            <?= status($row) ?>
                        </select>
                        <div class="invalid-feedback">
                            Status Wajib Diisi?
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
    <div class="modal fade" id="useredit<?= $key['iduser'] ?>" tabindex="-1" role="dialog" aria-labelledby="useredit<?= $key['iduser'] ?>Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="useredit<?= $key['iduser'] ?>Title">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="needs-validation" novalidate="" action="?p=aksi&form=user_edit&id=<?= $key['iduser'] ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="namalengkap" value="<?= $key['namalengkap'] ?>" required="">
                            <div class="invalid-feedback">
                                Nama Lengkap Wajib Diisi?
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" value="<?= $key['username'] ?>" required="">
                            <div class="invalid-feedback">
                                Username Wajib Diisi?
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" value="<?= $key['password'] ?>" required="">
                            <div class="invalid-feedback">
                                Password Wajib Diisi?
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Posisi</label>
                            <select class="form-control" name="posisi" required="">
                                <option value="">--Pilih Data--</option>
                                <?= posisi($key['posisi']) ?>
                            </select>
                            <div class="invalid-feedback">
                                Posisi Wajib Diisi?
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" required="">
                                <option value="">--Pilih Data--</option>
                                <?= status($key['status']) ?>
                            </select>
                            <div class="invalid-feedback">
                                Status Wajib Diisi?
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