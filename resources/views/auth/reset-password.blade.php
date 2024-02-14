<x-auth-layout>
<div class="auth-wrapper auth-basic px-2">
    <div class="auth-inner my-2">
        <!-- Reset Password basic -->
        <div class="card mb-0">
            <div class="card-body">
                <a href="#" class="brand-logo">
                    <h2 class="brand-text text-primary ms-1">{{ config('app.name') }}</h2>
                </a>

                <h4 class="card-title mb-1">{{__('auth.reset_password.title')}} 🔒</h4>
                <p class="card-text mb-2">{{__('auth.reset_password.message')}}</p>

                <form class="auth-reset-password-form mt-2" id="reset-password-form" method="POST">
                    @csrf

                    <div class="mb-1">
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <input type="hidden" name="email" value="{{ $request->email }}">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">{{__('auth.reset_password.new_password')}}</label>
                        </div>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" class="form-control form-control-merge" id="password" name="password" aria-describedby="password" tabindex="1" autofocus />
                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password_confirmation">{{__('auth.reset_password.password_confirmation')}}</label>
                        </div>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" class="form-control form-control-merge" id="password_confirmation" name="password_confirmation" aria-describedby="password_confirmation" tabindex="2" />
                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100" tabindex="3">{{ __('auth.reset_password.button') }}</button>
                </form>

                <p class="text-center mt-2">
                    <a href="{{ route('login') }}"> <i data-feather="chevron-left"></i> {{__('auth.reset_password.login')}} </a>
                </p>
            </div>
        </div>
        <!-- /Reset Password basic -->
    </div>
</div>

    <x-slot name="styles">
        <!--jQuery Validation-->
        <link href="{{ Vite::asset('resources/theme/plugins/forms/form-validation.css') }}" rel="stylesheet">
        <link href="{{ Vite::asset('resources/theme/pages/css/authentication.css') }}" rel="stylesheet">
        <!-- Toastr -->
        <link rel="stylesheet" type="text/css"
              href="{{ Vite::asset('resources/theme/plugins/toastr/toastr.min.css') }}">
        <link rel="stylesheet" type="text/css"
              href="{{ Vite::asset('resources/theme/plugins/toastr/ext-component-toastr.css') }}">
    </x-slot>

    <x-slot name="scripts">
        <!--jQuery Validation-->
        <script src="{{ Vite::asset('resources/theme/plugins/forms/validation/jquery.validate.min.js') }}"></script>
        <!-- Toastr -->
        <script src="{{ Vite::asset('resources/theme/plugins/toastr/toastr.min.js') }}"></script>
        <script type="text/javascript">
            let validator;
            $(function () {
                validator = $('#reset-password-form').validate({
                    lang: '{{ app()->getLocale() }}',
                    rules: {
                        password: {
                            required: true,
                            minlength:8,
                        },
                        password_confirmation: {
                            required: true,
                            equalTo: password,
                        }
                    },
                    submitHandler: function (form, e) {
                        e.preventDefault();
                        let data = new FormData(form);
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('password.update') }}',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                        }).then(function (response) {
                            toastr.success(response.message);
                            setTimeout(function () {
                                window.location.replace(response.url)
                            }, 300);
                        }).catch(function (response) {
                            if (response.status == 422) {
                                validator.showErrors(response.responseJSON.errors);
                            } else {
                                toastr.error(response.statusText);
                            }
                        })
                    }
                });
            });
        </script>
    </x-slot>
</x-auth-layout>
