<h1>{{ $modo }} Rutina</h1>

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
    <label for="nombre" class="form-label">Nombre</label>
    <input
        type="text"
        name="nombre"
        id="nombre"
        class="form-control"
        value="{{ old('nombre', $rutina->nombre ?? '') }}"
        required>
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea
        name="descripcion"
        id="descripcion"
        class="form-control"
        rows="4">{{ old('descripcion', $rutina->descripcion ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="nivel" class="form-label">Nivel</label>
    <select name="nivel" id="nivel" class="form-control" required>
        <option value="">Seleccione nivel</option>
        <option value="principiante" {{ old('nivel', $rutina->nivel ?? '') == 'principiante' ? 'selected' : '' }}>
            Principiante
        </option>
        <option value="intermedio" {{ old('nivel', $rutina->nivel ?? '') == 'intermedio' ? 'selected' : '' }}>
            Intermedio
        </option>
        <option value="avanzado" {{ old('nivel', $rutina->nivel ?? '') == 'avanzado' ? 'selected' : '' }}>
            Avanzado
        </option>
    </select>
</div>

<div class="mb-3 form-check">
    <input
        type="checkbox"
        name="es_vip"
        id="es_vip"
        class="form-check-input"
        {{ old('es_vip', $rutina->es_vip ?? false) ? 'checked' : '' }}>

    <label for="es_vip" class="form-check-label">
        Rutina VIP
    </label>
</div>

<div class="mb-3 form-check">
    <input
        type="checkbox"
        name="activa"
        id="activa"
        class="form-check-input"
        {{ old('activa', $rutina->activa ?? true) ? 'checked' : '' }}>

    <label for="activa" class="form-check-label">
        Rutina activa
    </label>
</div>

<div class="mb-3">
    <label for="foto_portada" class="form-label">Foto de portada</label>

    @if(isset($rutina) && $rutina->foto_portada)
        <div class="mb-2">
            <img
                src="{{ asset('storage/'.$rutina->foto_portada) }}"
                alt="Foto portada"
                class="img-thumbnail"
                style="max-width: 180px;">
        </div>
    @endif

    <input
        type="file"
        name="foto_portada"
        id="foto_portada"
        class="form-control"
        accept="image/*">
</div>

<button type="submit" class="btn btn-primary">
    {{ $modo }}
</button>