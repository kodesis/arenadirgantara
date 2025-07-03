<div class="head-login">
    <h3>Sign in</h3>
    <p>Sign in with your email and password</p>
    <form action="<?= base_url('auth') ?>" method="post" autocomplete="off" novalidate>
        <div class="form-login">
            <div class="form-group">
                <input type="text" name="username" id="username" class="form-control account" placeholder="Your username" autocomplete="off" value="<?= set_value('username') ?>" autofocus>
                <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Your password" autocomplete="off">
                <span class="view-password" id="toggle-password" style="cursor:pointer;"></span>
                <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-login">Sign In</button>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('toggle-password').addEventListener('click', function(e) {
        e.preventDefault();
        const passwordField = document.getElementById('password');
        const passwordFieldType = passwordField.getAttribute('type');

        if (passwordFieldType === 'password') {
            passwordField.setAttribute('type', 'text');
        } else {
            passwordField.setAttribute('type', 'password');
        }
    });
</script>