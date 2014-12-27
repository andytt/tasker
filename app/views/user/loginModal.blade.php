<div class="modal fade modal-login-form" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <form role="form" method="POST" action="{{ URL::to('users/login') }}">
                    <div class="form-group">
                        <label for="login-username-input">Username or Email</label>
                        <input type="text" name="username" class="form-control" id="login-username-input" placeholder="Username or Email">
                    </div>
                    <div class="form-group">
                        <label for="login-password-input">Password</label>
                        <input type="password" name="password" class="form-control" id="login-password-input" placeholder="Password">
                    </div>
                    @if (Session::get('notice'))
                        <p class="bg-info text-center">{{{ Session::get('notice') }}}</p>
                    @endif
                    <div class="row text-center">
                        <div class="col-md-6">
                            <button type="submit" class="btn">Login</button>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="btn link-to-sign-up">or Sign Up!</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
