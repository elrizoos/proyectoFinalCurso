<div class="notification-list">
    @forelse ($cambiosAlumnos as $notification)
        <div class="alert alert-info" role="alert">
            <p> {{ $notification->nombre }}</p>
            <p> {{ $notification->apellidos }}</p>
            <span>{{ $notification->updated_at->diffForHumans() }}</span>
        </div>
    @empty
        <div class="alert alert-info">
            No hay nuevas notificaciones.
        </div>
    @endforelse
</div>
<div class="notification-list">
    @forelse ($cambiosEmpleados as $notification)
       <div class="alert alert-info" role="alert">
            <p> {{ $notification->nombre }}</p>
            <p> {{ $notification->apellidos }}</p>
            <span>{{ $notification->updated_at->diffForHumans() }}</span>
        </div>
    @empty
        <div class="alert alert-info">
            No hay nuevas notificaciones.
        </div>
    @endforelse
</div>
<style>
.notification-list {
    margin: 0;
    padding: 0;
    list-style: none;
}

.notification-item {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
    padding: 10px;
    transition: background-color 0.3s ease;
}

.notification-item:hover {
    background-color: #f0f0f0;
}

.notification-item p {
    margin: 0;
    font-size: 1rem;
    color: #333;
}

.notification-item span {
    display: block;
    margin-top: 5px;
    font-size: 0.8rem;
    color: #666;
}

/* Puedes personalizar aún más según tus preferencias */

</style>