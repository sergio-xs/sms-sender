<x-auth-layout>
    <div class="auth-wrapper auth-basic">
        <div class="auth-inner my-2">
            <!-- Login basic -->
            <div class="card mb-0">
                <div class="card-body">
                    <a href="#" class="brand-logo">
                        <h2 class="brand-text text-primary ms-1">{{ config('app.name') }}</h2>
                    </a>

                    <h4 class="card-title mb-1"> {{ __('auth.login.welcome') }} {{ config('app.name') }}! 👋</h4>
                    <p class="card-text mb-2">{{ __('auth.login.message') }}</p>

                    <form class="auth-login-form mt-2" id="login-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-1">
                            <label for="email" class="form-label">{{__('auth.login.email')}}</label>
                            <input type="text" class="form-control" id="email" name="email" aria-describedby="email" tabindex="1" autofocus />
                        </div>

                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">{{__('auth.login.password')}}</label>
                                <a href="{{ route('password.request') }}">
                                    <small>{{__('auth.login.forgot_password')}}</small>
                                </a>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" class="form-control form-control-merge" id="password" name="password" tabindex="2" aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" tabindex="3" />
                                <label class="form-check-label" for="remember-me"> {{__('auth.login.remember_me')}} </label>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100" tabindex="4">{{__('auth.login.button')}}</button>
                    </form>
                </div>
            </div>
            <!-- /Login basic -->
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
                validator = $('#login-form').validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            minlength: 8
                        }
                    }
                })
            })
        </script>
        @if(count($errors->getMessages()))
            @php
                foreach ($errors->getMessages() as $name => $messages) {
                    $validationMessages[$name] = $messages[0];
                }
            @endphp
            <script>
                $(function () {
                    validationMessages = '{!! json_encode($validationMessages) !!}';
                    validationMessages = JSON.parse(validationMessages);
                    validator.showErrors(validationMessages)
                })
            </script>
        @endif
    </x-slot>

</x-auth-layout>
