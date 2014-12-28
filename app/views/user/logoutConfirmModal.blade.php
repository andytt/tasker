<div class="modal fade modal-logout-confirm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <p>Are you sure to logout?</p>
                <button class="btn btn-default">Cancel</button>
                <a href="{{ URL::to('users/logout') }}" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>
