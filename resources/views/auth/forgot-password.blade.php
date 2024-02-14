<x-auth-layout>
    <div class="auth-wrapper auth-basic px-2">
        <div class="auth-inner my-2">
            <!-- Forgot Password basic -->
            <div class="card mb-0">
                <div class="card-body">
                    <a href="#" class="brand-logo">
                        <h2 class="brand-text text-primary ms-1">{{ config('app.name') }}</h2>
                    </a>

                    <h4 class="card-title mb-1">{{__('auth.forgot_password.title')}} 🔒</h4>
                    <p class="card-text mb-2">
                        {{ __('auth.forgot_password.message') }}
                    </p>

                    <form class="auth-forgot-password-form mt-2" id="forgot-password-form" action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-1">
                            <label for="email" class="form-label">{{ __('auth.forgot_password.email') }}</label>
                            <input type="text" class="form-control" id="email"
                                   name="email" aria-describedby="email" tabindex="1" autofocus/>
                        </div>
                        <button class="btn btn-primary w-100"
                                tabindex="2">{{ __('auth.forgot_password.button') }}</button>
                    </form>

                    <p class="text-center mt-2">
                        <a href="{{route('login')}}"> <i data-feather="chevron-left"></i> {{__('auth.forgot_password.login')}} </a>
                    </p>
                </div>
            </div>
            <!-- /Forgot Password basic -->
        </div>
    </div>

    <x-slot name="styles">
        <!--jQuery Validation-->
        <link href="{{ Vite::asset('resources/theme/plugins/forms/form-validation.css') }}" rel="stylesheet">
        <link href="{{ Vite::asset('resources/theme/pages/css/authentication.css') }}" rel="stylesheet">
    </x-slot>

    <x-slot name="scripts">
        <!--jQuery Validation-->
        <script src="{{ Vite::asset('resources/theme/plugins/forms/validation/jquery.validate.min.js') }}"></script>
        <script>
            let validator;
            $(function (){
                validator = $('#forgot-password-form').validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        }
                    }
                })
            })
        </script>
    </x-slot>
</x-auth-layout>
