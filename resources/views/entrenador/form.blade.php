<h1>{{ $modo }} Entrenador</h1>

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
        value="{{ old('name', $entrenador->user->name ?? '') }}"
        placeholder="Ejemplo: Carlos Ramírez"
        required>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Correo electrónico</label>
    <input
        type="email"
        name="email"
        id="email"
        class="form-control"
        value="{{ old('email', $entrenador->user->email ?? '') }}"
        placeholder="entrenador@ejemplo.com"
        required>
</div>

<div class="mb-3">
    <label for="password" class="form-label">
        Contraseña

        @if($modo === 'Editar' || isset($entrenador))
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
        placeholder="{{ ($modo === 'Editar' || isset($entrenador)) ? 'Opcional al editar' : 'Mínimo 8 caracteres' }}"
        {{ ($modo === 'Editar' || isset($entrenador)) ? '' : 'required' }}>
</div>

<div class="mb-3">
    <label for="sucursal_id" class="form-label">Sucursal</label>
    <select name="sucursal_id" id="sucursal_id" class="form-control" required>
        <option value="">Seleccione una sucursal</option>

        @foreach($sucursales as $sucursal)
            <option value="{{ $sucursal->id }}"
                {{ old('sucursal_id', $entrenador->sucursal_id ?? '') == $sucursal->id ? 'selected' : '' }}>
                {{ $sucursal->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="telefono" class="form-label">Teléfono</label>
    <input
        type="text"
        name="telefono"
        id="telefono"
        class="form-control"
        value="{{ old('telefono', $entrenador->telefono ?? '') }}"
        placeholder="Ejemplo: 7151234567">
</div>

<div class="mb-3">
    <label for="especialidad" class="form-label">Especialidad</label>
    <input
        type="text"
        name="especialidad"
        id="especialidad"
        class="form-control"
        value="{{ old('especialidad', $entrenador->especialidad ?? '') }}"
        placeholder="Ejemplo: Musculación, CrossFit, Cardio, Nutrición">
</div>

<div class="mb-3 form-check">
    <input
        type="checkbox"
        name="activo"
        id="activo"
        class="form-check-input"
        {{ old('activo', $entrenador->activo ?? true) ? 'checked' : '' }}>

    <label for="activo" class="form-check-label">
        Entrenador activo
    </label>
</div>

<div class="mb-3">
    <label for="foto_perfil" class="form-label">Foto de perfil</label>

    @if(isset($entrenador->foto_perfil) && $entrenador->foto_perfil)
        <div class="mb-2">
            <img
                src="{{ asset('storage/'.$entrenador->foto_perfil) }}"
                alt="Foto actual"
                width="120"
                class="img-thumbnail">

            <br>

            <small>{{ $entrenador->foto_perfil }}</small>
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