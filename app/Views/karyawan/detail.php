<?= $this->extend('layouts/main_master') ?>

<?= $this->section('isi') ?>
<!-- Small boxes (Stat box) -->
<div class="row">

    <!-- ./col -->
</div>
<!-- /.row -->
<!-- Main row -->

<div class="row">
    <!-- Left col -->
    <!-- <section class="col-lg-12 connectedSortable"> -->
    <!-- Custom tabs (Charts with tabs)-->

    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                        src="<?= base_url() ?>/assets/dist/img/user2-160x160.jpg" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?= $nonip['nama'] ?></h3>

                <p class="text-muted text-center"><?= $nonip['subunit'] ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>NIP</b> <a class="float-right"><?= $nonip['nip'] ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Group Kerja</b> <a class="float-right"><?= $nonip['grup'] ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Golongan</b> <a class="float-right"><?= $nonip['golongan'] ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Usia</b> <a class="float-right"></a>
                    </li>
                    <li class="list-group-item">
                        <b>TMT</b> <a class="float-right"><?= date('d-m-Y', strtotime($nonip['tmt']))  ?></a>
                    </li>
                    <?php $date1 = date_create() ?>
                    <?php $date2 = date_create($nonip['tmt']) ?>
                    <?php $date3 = date_diff($date2, $date1) ?>
                    <li class="list-group-item">
                        <b>Masa Kerja</b> <a class="float-right"><?= $date3->format("%y Tahun %m Bulan") ?></a>
                    </li>
                </ul>

                <!-- <a href="#" class="btn btn-primary btn-block"><b>Edit</b></a> -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#dataperson" data-toggle="tab">Data
                            Pribadi</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#dataemployee" data-toggle="tab">Data Karyawan</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#history" data-toggle="tab">Riwayat Mutasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#salary" data-toggle="tab">Penggajian</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="dataperson">
                        <!-- Post -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">About Me</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                                <p class="text-muted">
                                    B.S. in Computer Science from the University of Tennessee at Knoxville
                                </p>

                                <hr>

                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                                <p class="text-muted">Malibu, California</p>

                                <hr>

                                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                                <p class="text-muted">
                                    <span class="tag tag-danger">UI Design</span>
                                    <span class="tag tag-success">Coding</span>
                                    <span class="tag tag-info">Javascript</span>
                                    <span class="tag tag-warning">PHP</span>
                                    <span class="tag tag-primary">Node.js</span>
                                </p>

                                <hr>

                                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam
                                    fermentum enim
                                    neque.</p>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.post -->
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="dataemployee">
                        <!-- The timeline -->
                        <div class="timeline timeline-inverse">
                            <!-- timeline time label -->

                        </div>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="history">
                        <form class="form-horizontal">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputName" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName2" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="inputExperience"
                                        placeholder="Experience"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!-- /.card -->
    <!-- </section> -->
</div>

<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
const flashDataa = "<?= session()->getFlashdata('success') ?>";

$(document).ready(function() {

});

function detailkaryawana(id) {

}

$(document).ready(function() {})
</script>

<?= $this->endSection() ?>