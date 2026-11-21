<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6">
            <div class="card">
                <div class="card-body">

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?= e($success) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= e($error) ?></div>
                    <?php endif; ?>

                    <div class="app-brand justify-content-center mb-6">
                        <a href="/admin/login" class="app-brand-link">
                            <img src="<?= asset('img/logo.png') ?>" alt="logo">
                        </a>
                    </div>
                    <h4 class="mb-1 text-center">Welcome to Weneura Website</h4>
                    <p class="mb-6 text-center">Please sign-in to your account</p>

                    <form method="POST" action="/admin/login" class="mb-4">
                        <?= csrf_field() ?>
                        <div class="mb-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= e($oldEmail) ?>" placeholder="Enter your email" required autofocus>
                        </div>
                        <div class="mb-6 form-password-toggle">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="············" required>
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>