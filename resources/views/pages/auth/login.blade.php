<x-layouts::auth :title="__('Iniciar sesión')">
    <div style="background:#001F27; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px;">
        <div style="width:100%; max-width:420px; background:#ffffff; border-radius:24px; padding:34px; box-shadow:0 20px 50px rgba(0,0,0,.25);">

            <div style="text-align:center; margin-bottom:28px;">
                <div style="width:70px; height:70px; margin:0 auto 14px; border-radius:20px; background:#003A35; display:flex; align-items:center; justify-content:center; color:white; font-size:28px; font-weight:800;">
                    AG
                </div>

                <h1 style="font-size:28px; font-weight:800; color:#001F27; margin:0;">
                    AdminGym
                </h1>

                <p style="color:#719A73; margin-top:8px; font-size:15px;">
                    Control administrativo para gimnasios
                </p>
            </div>

            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" action="{{ route('login.store') }}" style="display:flex; flex-direction:column; gap:18px;">
                @csrf

                <div>
                    <label style="display:block; margin-bottom:6px; color:#001F27; font-weight:600;">
                        Correo electrónico
                    </label>
                    <input
                        name="email"
                        value="{{ old('email') }}"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="super@admingym.com"
                        style="width:100%; padding:13px 15px; border:1px solid #d1d5db; border-radius:14px; outline:none;"
                    >
                    @error('email')
                        <p style="color:#dc2626; font-size:13px; margin-top:6px;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label style="display:block; margin-bottom:6px; color:#001F27; font-weight:600;">
                        Contraseña
                    </label>
                    <input
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="12345678"
                        style="width:100%; padding:13px 15px; border:1px solid #d1d5db; border-radius:14px; outline:none;"
                    >
                    @error('password')
                        <p style="color:#dc2626; font-size:13px; margin-top:6px;">{{ $message }}</p>
                    @enderror
                </div>

                <label style="display:flex; align-items:center; gap:8px; color:#003A35; font-size:14px;">
                    <input type="checkbox" name="remember">
                    Recordarme
                </label>

                <button
                    type="submit"
                    style="width:100%; padding:14px; border:none; border-radius:14px; background:#1F73C2; color:white; font-weight:800; cursor:pointer; font-size:16px;"
                >
                    Iniciar sesión
                </button>
            </form>

        </div>
    </div>
</x-layouts::auth>