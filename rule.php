<div class="main-content">
    <section class="section">
        <h3>Data Rule</h3>
        <hr>
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ruleadd">Tambah
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
                                <th>Nama Rule</th>
                                <th>Aturan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $a = "INNER JOIN variabel ON detail_rule.idvariabel = variabel.idvariabel";
                            $b = "INNER JOIN himpunan ON detail_rule.idhimpunan = himpunan.idhimpunan";
                            $no = 1;
                            $query = $kon->query("SELECT * FROM rule");
                            foreach ($query as $key) {
                                $nama = "rule_del";
                                $id = $key['idrule'];
                                $data = $key['namarule'];
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $key['namarule'] ?></td>
                                    <td> IF
                                        <?php
                                        $rule = $kon->query("SELECT * FROM detail_rule $a $b WHERE idrule = '$key[idrule]' AND ketvariabel='Input'");
                                        $rulesArray = [];
                                        foreach ($rule as $rul) {
                                            $rulesArray[] = "{$rul['namavariabel']} is <b>{$rul['namahimpunan']}</b>";
                                        }
                                        $rulesString = implode(' And ', $rulesArray);
                                        echo $rulesString;
                                        ?>

                                        <?php
                                        $rule = $kon->query("SELECT * FROM detail_rule $a $b WHERE idrule = '$key[idrule]' AND ketvariabel='Output'");
                                        foreach ($rule as $rul) {
                                        ?>
                                            Then <?= $rul['namavariabel'] ?> <b><?= $rul['namahimpunan'] ?></b>
                                        <?php } ?>
                                    </td>
                                    <td align="center">
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ruleedit<?= $key['idrule'] ?>"><i data-feather="edit"></i>
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
<div class="modal fade" id="ruleadd" tabindex="-1" role="dialog" aria-labelledby="ruleaddTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ruleaddTitle">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" novalidate="" action="?p=aksi&form=rule_add" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Rule</label>
                        <input type="text" class="form-control" name="namarule" required="">
                        <div class="invalid-feedback">
                            Nama Rule Wajib Diisi?
                        </div>
                    </div>

                    <?php
                    $variabel = $kon->query("SELECT * FROM variabel WHERE ketvariabel = 'Input'");
                    foreach ($variabel as $row) {
                    ?>
                        <div class="form-group">
                            <label>IF <?= $row['namavariabel'] ?></label>
                            <input type="hidden" class="form-control" name="idvariabel[]" value="<?= $row['idvariabel'] ?>" required="">
                            <select class="form-control" name="idhimpunan[]" required="">
                                <option value="">--Pilih Data--</option>
                                <?= himpunan($row, $row['idvariabel']) ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $row['namavariabel'] ?> Wajib Diisi?
                            </div>
                        </div>
                    <?php } ?>

                    <?php
                    $variabel = $kon->query("SELECT * FROM variabel WHERE ketvariabel = 'Output'");
                    foreach ($variabel as $row) {
                    ?>
                        <div class="form-group">
                            <label>Then <?= $row['namavariabel'] ?></label>
                            <input type="hidden" class="form-control" name="idvariabel[]" value="<?= $row['idvariabel'] ?>" required="">
                            <select class="form-control" name="idhimpunan[]" required="">
                                <option value="">--Pilih Data--</option>
                                <?= himpunann($row, $row['idvariabel']) ?>
                            </select>
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
    <div class="modal fade" id="ruleedit<?= $key['idrule'] ?>" tabindex="-1" role="dialog" aria-labelledby="ruleedit<?= $key['idrule'] ?>Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ruleedit<?= $key['idrule'] ?>Title">Eidt Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="needs-validation" novalidate="" action="?p=aksi&form=rule_edit&id=<?= $key['idrule'] ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Rule</label>
                            <input type="text" class="form-control" name="namarule" value="<?= $key['namarule'] ?>" required="">
                            <div class="invalid-feedback">
                                Nama Rule Wajib Diisi?
                            </div>
                        </div>

                        <?php
                        $variabel = $kon->query("SELECT * FROM detail_rule $a $b WHERE idrule = '$key[idrule]' AND ketvariabel='Input'");
                        foreach ($variabel as $row) {
                        ?>
                            <div class="form-group">
                                <label>IF <?= $row['namavariabel'] ?></label>
                                <input type="hidden" class="form-control" name="idvariabel[]" value="<?= $row['idvariabel'] ?>" required="">
                                <select class="form-control" name="idhimpunan[]" required="">
                                    <option value="">--Pilih Data--</option>
                                    <?= himpunan($row['idhimpunan'], $row['idvariabel']) ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $row['namavariabel'] ?> Wajib Diisi?
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                        $variabel = $kon->query("SELECT * FROM detail_rule $a $b WHERE idrule = '$key[idrule]' AND ketvariabel='Output'");
                        foreach ($variabel as $row) {
                        ?>
                            <div class="form-group">
                                <label>Then <?= $row['namavariabel'] ?></label>
                                <input type="hidden" class="form-control" name="idvariabel[]" value="<?= $row['idvariabel'] ?>" required="">
                                <select class="form-control" name="idhimpunan[]" required="">
                                    <option value="">--Pilih Data--</option>
                                    <?= himpunann($row['idhimpunan'], $row['idvariabel']) ?>
                                </select>
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