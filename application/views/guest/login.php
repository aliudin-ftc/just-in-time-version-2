<div class="login">
    <!-- Login -->
    <div class="l-block toggled" id="l-login">

        <div class="text-center">
            <h1 class="theme-color-1 title" data-in-effect="bounceInDown">J2V2</h1>
        </div>

        <div class="lb-lead">
            <div class="lb-header theme-bg-1">
                <i class="zmdi zmdi-account-circle"></i>
                Hi there! Please Sign in
            </div>

            <div class="lb-body">
                <form id="login-form" action="<?php echo base_url('login') ?>" method="POST" accept-charset="utf-8">
                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <input type="text" name="username" class="input-md form-control fg-input">
                            <label class="fg-label">Username</label>
                        </div>
                    </div>

                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <input type="password" name="password" class="input-md form-control fg-input">
                            <label class="fg-label">Password</label>
                        </div>
                    </div>

                    <div class="m-t-20">
                        <button type="submit" class="btn theme-bg-1">Sign in</button>
                        <a data-block="#l-forget-password" href="" class="text-normal text pull-right">Forgot password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Forgot Password -->
    <div class="l-block" id="l-forget-password">

        <div class="text-center">
            <h1 class="theme-color-1 title hidden" data-in-effect="bounceInDown">J2V2</h1>
        </div>
        <div class="lb-lead">
            <div class="lb-header theme-bg-2">
                <i class="zmdi zmdi-account-circle"></i>
                Forgot Password?
            </div>

            <div class="lb-body">
                <p class="m-b-30">J2V2 will send password reset instructions to the email address associated.</p>

                <div class="form-group fg-float">
                    <div class="fg-line">
                        <input type="text" class="input-sm form-control fg-input">
                        <label class="fg-label">Email Address</label>
                    </div>
                </div>

                <div class="m-t-20">
                    <button class="btn theme-bg-2">Reset Password</button>
                    <a data-block="#l-login" class="text-normal text d-block m-b-5 pull-right" href="">Login?</a>
                </div>
            </div>
        </div>
    </div>
</div>