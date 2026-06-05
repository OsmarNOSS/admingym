<h1>{{ $modo }} Cliente</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Corrige los siguientes errores:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="name" class="form-label">Nombre completo</label>
    <input
        type="text"
        name="name"
        id="name"
        class="form-control"
        value="{{ old('name', $cliente->user->name ?? '') }}"
        placeholder="Ejemplo: Juan Pérez"
        required>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Correo electrónico</label>
    <input
        type="email"
        name="email"
        id="email"
        class="form-control"
        value="{{ old('email', $cliente->user->email ?? '') }}"
        placeholder="correo@ejemplo.com"
        required>
</div>

<div class="mb-3">
    <label for="password" class="form-label">
        Contraseña

        @if($modo === 'Editar' || isset($cliente))
            <small class="text-muted">(déjala vacía si no quieres cambiarla)</small>
        @else
            <small class="text-muted">(mínimo 8 caracteres)</small>
        @endif
    </label>

    <input
        type="password"
        name="password"
        id="password"
        class="form-control"
        placeholder="{{ ($modo === 'Editar' || isset($cliente)) ? 'Opcional al editar' : 'Mínimo 8 caracteres' }}"
        {{ ($modo === 'Editar' || isset($cliente)) ? '' : 'required' }}>
</div>

<div class="mb-3">
    <label for="sucursal_id" class="form-label">Sucursal</label>
    <select name="sucursal_id" id="sucursal_id" class="form-control" required>
        <option value="">Seleccione una sucursal</option>

        @foreach($sucursales as $sucursal)
            <option value="{{ $sucursal->id }}"
                {{ old('sucursal_id', $cliente->sucursal_id ?? '') == $sucursal->id ? 'selected' : '' }}>
                {{ $sucursal->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="peso" class="form-label">Peso (kg)</label>
    <input
        type="number"
        step="0.01"
        min="1"
        max="300"
        name="peso"
        id="peso"
        class="form-control"
        value="{{ old('peso', $cliente->peso ?? '') }}"
        placeholder="Ejemplo: 75.50">
</div>

<div class="mb-3">
    <label for="altura" class="form-label">Altura (m)</label>
    <input
        type="number"
        step="0.01"
        min="0.50"
        max="2.50"
        name="altura"
        id="altura"
        class="form-control"
        value="{{ old('altura', $cliente->altura ?? '') }}"
        placeholder="Ejemplo: 1.75">
</div>

<div class="mb-3">
    <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
    <input
        type="date"
        name="fecha_nacimiento"
        id="fecha_nacimiento"
        class="form-control"
        value="{{ old('fecha_nacimiento', $cliente->fecha_nacimiento ?? '') }}">
</div>

<div class="mb-3 form-check">
    <input
        type="checkbox"
        name="activo"
        id="activo"
        class="form-check-input"
        {{ old('activo', $cliente->activo ?? true) ? 'checked' : '' }}>

    <label for="activo" class="form-check-label">
        Cliente activo
    </label>
</div>

<div class="mb-3">
    <label for="foto_perfil" class="form-label">Foto de perfil</label>

    @if(isset($cliente->foto_perfil) && $cliente->foto_perfil)
        <div class="mb-2">
            <img
                src="{{ asset('storage/'.$cliente->foto_perfil) }}"
                alt="Foto actual"
                width="120"
                class="img-thumbnail">

            <br>

            <small>{{ $cliente->foto_perfil }}</small>
        </div>
    @endif

    <input
        type="file"
        name="foto_perfil"
        id="foto_perfil"
        class="form-control"
        accept="image/*">
</div>

<input type="submit" value="{{ $modo }}" class="btn btn-primary">