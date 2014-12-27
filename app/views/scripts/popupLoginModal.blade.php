<script>
(function ($) {
    'use strict';

    $(function () {
        $('.modal-signup-form').modal({
            show: false
        }).on('shown.bs.modal', function () {
            var $this = $(this);

            $this.find('input').first().focus();
            $this.find('.link-to-login').on('click', function (e) {
                e.preventDefault();
                $this.modal('hide');
            });
        }).on('hidden.bs.modal', function () {
            $('.modal-login-form').modal('show');
        });

        $('.modal-login-form').modal().on('shown.bs.modal', function () {
            var $this = $(this);

            $this.find('input').first().focus();
            $this.find('.link-to-sign-up').on('click', function (e) {
                e.preventDefault();
                $this.modal('hide');
            });
        }).on('hidden.bs.modal', function () {
            $('.modal-signup-form').modal('show');
        });
    });

})(window.jQuery);
</script>
