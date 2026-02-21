@extends('layouts.admin')

@section('page_title', 'Kalender Arus Kas')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Riwayat Keuangan Bulanan</h5>
        <a href="{{ route('admin.finances.index') }}" class="btn btn-secondary btn-sm rounded-pill">
            <i class="fas fa-list me-1"></i> Lihat Tabel
        </a>
    </div>
    <div class="card-body">
        <div id="calendar" style="min-height: 600px;"></div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            events: {!! json_encode($events) !!},
            eventClick: function(info) {
                alert('Keterangan: ' + info.event.extendedProps.description + '\n' + info.event.title);
            }
        });
        calendar.render();
    });
</script>
<style>
    .fc-event {
        cursor: pointer;
        padding: 2px 5px;
        border-radius: 4px;
        font-size: 0.85em;
    }
    .fc-toolbar-title {
        font-weight: bold;
        text-transform: capitalize;
    }
</style>
@endsection
