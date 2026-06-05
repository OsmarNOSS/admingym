<x-layouts::app title="Dashboard">
    <style>
        .dashboard-shell {
            background: linear-gradient(135deg, #f4f8f5 0%, #eef5f7 100%);
            min-height: 100vh;
            padding: 28px;
            border-radius: 18px;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #001F27 0%, #003A35 100%);
            color: white;
            border-radius: 22px;
            padding: 30px;
            margin-bottom: 24px;
            box-shadow: 0 12px 30px rgba(0, 31, 39, 0.18);
        }

        .dashboard-header h1 {
            font-size: 2.3rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .dashboard-header p {
            margin: 0;
            color: #d7e8df;
        }

        .metric-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 24px rgba(0, 31, 39, 0.10);
            height: 100%;
        }

        .metric-card .card-body {
            padding: 24px;
        }

        .metric-label {
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #51615d;
            margin-bottom: 10px;
        }

        .metric-value {
            font-size: 2.4rem;
            font-weight: 900;
            color: #001F27;
            line-height: 1;
        }

        .metric-accent {
            height: 7px;
            width: 100%;
        }

        .accent-sage {
            background: #719A73;
        }

        .accent-evergreen {
            background: #003A35;
        }

        .accent-ink {
            background: #001F27;
        }

        .accent-marine {
            background: #1F73C2;
        }

        .dashboard-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 24px rgba(0, 31, 39, 0.09);
            overflow: hidden;
        }

        .dashboard-card .card-header {
            background: #003A35;
            color: white;
            font-weight: 800;
            border: none;
            padding: 16px 20px;
        }

        .dashboard-card .card-body {
            padding: 20px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f2f6f4;
            color: #001F27;
            font-weight: 800;
            border-bottom: 2px solid #dce8e1;
        }

        .badge-sage {
            background: #719A73;
            color: white;
        }

        .badge-evergreen {
            background: #003A35;
            color: white;
        }

        .badge-ink {
            background: #001F27;
            color: white;
        }

        .badge-marine {
            background: #1F73C2;
            color: white;
        }

        .section-title {
            font-weight: 900;
            color: #001F27;
            margin-bottom: 16px;
        }

        @media (max-width: 768px) {
            .dashboard-shell {
                padding: 16px;
            }

            .dashboard-header {
                padding: 22px;
            }

            .dashboard-header h1 {
                font-size: 1.8rem;
            }
        }
    </style>

    <div class="dashboard-shell">
        <div class="dashboard-header">
            <h1>Panel principal - AdminGym</h1>
            <p>Bienvenido, {{ auth()->user()->name }}</p>
            <p>Rol: {{ auth()->user()->rol }}</p>
        </div>

        @role('super_admin')
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card metric-card">
                        <div class="metric-accent accent-sage"></div>
                        <div class="card-body">
                            <div class="metric-label">Total de clientes</div>
                            <div class="metric-value">{{ $totalClientes }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card metric-card">
                        <div class="metric-accent accent-evergreen"></div>
                        <div class="card-body">
                            <div class="metric-label">Total membresías</div>
                            <div class="metric-value">{{ $totalMembresias }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card metric-card">
                        <div class="metric-accent accent-marine"></div>
                        <div class="card-body">
                            <div class="metric-label">Membresías activas</div>
                            <div class="metric-value">{{ $membresiasActivas }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card metric-card">
                        <div class="metric-accent accent-ink"></div>
                        <div class="card-body">
                            <div class="metric-label">Próximas a vencer</div>
                            <div class="metric-value">{{ $membresiasProximasVencer->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-header">
                            Membresías próximas a vencer
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Sucursal</th>
                                        <th>Vence</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($membresiasProximasVencer as $membresia)
                                        <tr>
                                            <td>{{ $membresia->cliente->user->name ?? 'Sin cliente' }}</td>

                                            <td>
                                                @if($membresia->tipo === 'vip')
                                                    <span class="badge badge-ink text-uppercase">VIP</span>
                                                @elseif($membresia->tipo === 'premium')
                                                    <span class="badge badge-marine text-uppercase">Premium</span>
                                                @else
                                                    <span class="badge badge-sage text-uppercase">Basic</span>
                                                @endif
                                            </td>

                                            <td>{{ $membresia->sucursal->nombre ?? 'Sin sucursal' }}</td>

                                            <td>
                                                {{ $membresia->fecha_fin ? $membresia->fecha_fin->format('d/m/Y') : 'N/A' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                No hay membresías próximas a vencer.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-header">
                            Clientes con más asistencias
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Asistencias</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($clientesConMasAsistencias as $cliente)
                                        <tr>
                                            <td>{{ $cliente->user->name ?? 'Sin nombre' }}</td>
                                            <td>
                                                <span class="badge badge-sage">
                                                    {{ $cliente->asistencias_count }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                No hay asistencias registradas.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card dashboard-card mb-4">
                <div class="card-header">
                    Entrenadores con más alumnos
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Entrenador</th>
                                <th>Sucursal</th>
                                <th>Especialidad</th>
                                <th>Alumnos asignados</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($entrenadoresConMasAlumnos as $entrenador)
                                <tr>
                                    <td>{{ $entrenador->user->name ?? 'Sin nombre' }}</td>
                                    <td>{{ $entrenador->sucursal->nombre ?? 'Sin sucursal' }}</td>
                                    <td>{{ $entrenador->especialidad ?? 'No registrada' }}</td>
                                    <td>
                                        <span class="badge badge-marine">
                                            {{ $entrenador->alumnos_count }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        No hay entrenadores con alumnos asignados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                Tu panel está disponible desde las opciones del menú lateral.
            </div>
        @endrole
    </div>
</x-layouts::app>