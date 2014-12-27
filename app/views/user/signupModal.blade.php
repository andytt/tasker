<div class="modal fade modal-signup-form" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <form role="form" method="POST" action="{{ URL::to('users') }}">
                    <div class="form-group">
                        <label for="signup-username-input">Username</label>
                        <input type="text" name="username" class="form-control" id="signup-username-input" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="signup-email-input">Email</label>
                        <input type="text" name="email" class="form-control" id="signup-email-input" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="signup-password-input">Password</label>
                        <input type="password" name="password" class="form-control" id="login-password-input" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="signup-password-confirmation-input">Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="signup-password-confirmation-input" placeholder="Password Confirmation">
                    </div>
                    <div class="row text-center">
                        <div class="col-md-6">
                            <button type="submit" class="btn">Sign UP</button>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="btn link-to-login">or Login.</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
