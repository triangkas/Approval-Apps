<x-auth-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Username / Email Address -->
        <div class="form-group mb-2">
            <x-input-label for="identifierId" :value="__('Username')" />
            <div class="input-group">
                <x-text-input id="identifierId" class="form-control {{ $errors->get('username') ? 'is-invalid' : ($errors->get('email') ? 'is-invalid' : '') }}" type="text" name="identifierId" :value="old('identifierId')" autofocus />
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="text-danger" />
            <x-input-error :messages="$errors->get('username')" class="text-danger" />
        </div>

        <!-- Password -->
        <div class="form-group mb-2">
            <x-input-label for="password" :value="__('Password')" />
            <div class="input-group">
                <x-text-input id="password" class="form-control {{ $errors->get('password') ? 'is-invalid' : '' }}"
                    type="password"
                    name="password"
                    autocomplete="current-password" />
                <div class="input-group-append">
                    <div class="input-group-text" style="border-right: 0; cursor: pointer; display: none;" id="togglePassword">
                        <i class="fas fa-eye" id="iconTogglePassword"></i>
                    </div>
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="text-danger" />
        </div>

        <div class="row">
            <div class="col-12">
                <div class="icheck-primary">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">{{ __('Remember me') }}</label>
                </div>
            </div>
        </div>

        <x-primary-button class="btn btn-block btn-primary mt-2 mb-4">{{ __('Login') }}</x-primary-button>

        @if (Route::has('password.request'))
            <p class="mb-3">
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            </p>
        @endif
    </form>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const icon = document.getElementById('iconTogglePassword');

        let keepVisible = false;

        passwordInput.addEventListener('focus', () => {
            togglePassword.style.display = 'flex';
        });

        passwordInput.addEventListener('blur', () => {
            setTimeout(() => {
                if (!keepVisible) {
                    togglePassword.style.display = 'none';
                }
            }, 150);
        });

        togglePassword.addEventListener('mousedown', (e) => {
            e.preventDefault();
            keepVisible = true;

            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');

            setTimeout(() => keepVisible = false, 200);
        });
    </script>
</x-auth-layout>
