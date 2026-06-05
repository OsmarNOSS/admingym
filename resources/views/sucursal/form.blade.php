<h1>{{$modo}} Sucursal</h1>

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre del gimnasio</label>
    <input type="text" name="nombre" id="nombre" class="form-control" value="{{isset($sucursal->nombre) ? $sucursal->nombre : ''}}" placeholder="Ejemplo: GymAdmin Zitácuaro" required>
</div>

<div class="mb-3">
    <label for="direccion" class="form-label">Dirección</label>
    <textarea name="direccion" id="direccion" class="form-control" rows="3" placeholder="Ingresa la dirección" required>{{isset($sucursal->direccion) ? $sucursal->direccion : ''}}</textarea>
</div>

<div class="mb-3">
    <label for="telefono" class="form-label">Teléfono</label>
    <input type="text" name="telefono" id="telefono" class="form-control" value="{{isset($sucursal->telefono) ? $sucursal->telefono : ''}}" placeholder="7151234567" required>
</div>

<div class="mb-3">
    <label for="capacidad" class="form-label">Capacidad</label>
    <input type="number" name="capacidad" id="capacidad" class="form-control" min="1" value="{{isset($sucursal->capacidad) ? $sucursal->capacidad : ''}}" placeholder="Ejemplo: 150" required>
</div>

<div class="mb-3">
    <label class="form-label">Horario</label>

    <div style="display: flex; gap: 10px; align-items: center;">
        <input type="time" name="hora_apertura" class="form-control" value="{{isset($sucursal->hora_apertura) ? $sucursal->hora_apertura : ''}}" required>

        <span>-</span>

        <input type="time" name="hora_cierre" class="form-control" value="{{isset($sucursal->hora_cierre) ? $sucursal->hora_cierre : ''}}" required>
    </div>
</div>

<div class="mb-3 form-check">
    <input type="checkbox" name="activa" id="activa" class="form-check-input" {{isset($sucursal->activa) && $sucursal->activa ? 'checked' : ''}}>

    <label for="activa" class="form-check-label">
        Sucursal activa
    </label>
</div>

<div class="mb-3">
    <label for="foto_portada" class="form-label">
        Foto de portada
    </label>
    @if(isset($sucursal->foto_portada) && $sucursal->foto_portada)
    <div class="mb-2">
        <small>Archivo actual: {{$sucursal->foto_portada}}</small>
    </div>
    @endif
    <input type="file" name="foto_portada" id="foto_portada" class="form-control" accept="image/*">
</div>

<input type="submit" value="{{$modo}}" class="btn btn-primary">