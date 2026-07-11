<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Profil Saya</h4>
                </div>

                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error'); ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/profile/update'); ?>"
                          method="post"
                          enctype="multipart/form-data">

                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <?php if (!empty($user['foto_user'])) : ?>
                                    <img src="<?= base_url('uploads/user/' . $user['foto_user']); ?>"
                                         class="rounded-circle shadow border border-4 border-white"
                                         style="width:180px;height:180px;object-fit:cover;object-position:center top;">
                                <?php else : ?>
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['nama']); ?>&size=180"
                                         class="rounded-circle shadow border border-4 border-white">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" name="foto_user" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   value="<?= esc($user['nama']); ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text"
                                   class="form-control"
                                   value="<?= esc($user['email']); ?>"
                                   readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input type="text"
                                   class="form-control"
                                   value="<?= ucfirst($user['role']); ?>"
                                   readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Divisi</label>
                            <input type="text"
                                   class="form-control"
                                   value="<?= esc($user['nama_divisi'] ?? '-'); ?>"
                                   readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text"
                                   name="no_hp"
                                   class="form-control"
                                   value="<?= esc($user['no_hp']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat"
                                      rows="3"
                                      class="form-control"><?= esc($user['alamat']); ?></textarea>
                        </div>

                        <hr>

                        <h5 class="mb-3">Ganti Password</h5>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>

                         <div class="input-group">
                            <input type="password"
                                id="passwordBaru"
                                name="password_baru"
                                class="form-control"
                                placeholder="Kosongkan jika tidak ingin mengganti password">

                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="togglePassword('passwordBaru', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                      </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>

                            <div class="input-group">
                                <input type="password"
                                    id="konfirmasiPassword"
                                    name="konfirmasi_password"
                                    class="form-control"
                                    placeholder="Ulangi password baru">

                                <button type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="togglePassword('konfirmasiPassword', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i>
                            Simpan Profil
                        </button>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function togglePassword(id, btn)
{
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');

    if (input.type === 'password')
    {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }
    else
    {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>

<?= $this->endSection(); ?>