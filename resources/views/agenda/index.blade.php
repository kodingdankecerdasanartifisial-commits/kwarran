@extends('layouts.public')

@section('title', 'Agenda Kegiatan - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 offset-lg-2 text-center">
            <h1 class="fw-bold mb-3 display-5">Agenda Kegiatan</h1>
            <p class="lead text-muted">Jadwal lengkap kegiatan Kwarran Bekasi Timur. Klik pada agenda untuk melihat detail.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 bg-light text-white" id="modalHeader">
                <h5 class="modal-title fw-bold" id="modalTitle"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <i class="far fa-clock text-muted me-2" style="width: 20px; text-align: center;"></i>
                    <span id="modalTime" class="fw-bold"></span>
                </div>
                <div class="mb-3" id="modalLocationContainer">
                    <i class="fas fa-map-marker-alt text-muted me-2" style="width: 20px; text-align: center;"></i>
                    <span id="modalLocation"></span>
                </div>
                <div class="mt-4 pt-3 border-top" id="modalDescriptionContainer">
                    <h6 class="fw-bold mb-2 small text-uppercase text-muted">Deskripsi</h6>
                    <p id="modalDescription" class="text-muted mb-0" style="white-space: pre-line;"></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
    .fc-event {
        cursor: pointer;
        border: none;
        padding: 2px 4px;
        font-size: 0.9rem;
    }
    .fc-daygrid-event {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .fc-toolbar-title {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 1.25rem !important;
    }
    .fc-button-primary {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
    }
    .fc-button-primary:hover {
        background-color: var(--secondary-color) !important;
        border-color: var(--secondary-color) !important;
        color: var(--primary-color) !important;
    }
    .fc-day-today {
        background-color: rgba(242, 201, 76, 0.1) !important;
    }
</style>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth'
            },
            events: '{{ route("agenda.feed") }}',
            eventClick: function(info) {
                var event = info.event;
                var props = event.extendedProps;
                
                document.getElementById('modalTitle').innerText = event.title;
                
                // Format Time
                var timeString = '';
                if (event.allDay) {
                    timeString = 'Seharian';
                } else {
                    timeString = event.start.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    if (event.end) {
                        timeString += ' - ' + event.end.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    }
                }
                document.getElementById('modalTime').innerText = event.start.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + ' • ' + timeString;
                
                // Location
                if (props.location) {
                    document.getElementById('modalLocation').innerText = props.location;
                    document.getElementById('modalLocationContainer').style.display = 'block';
                } else {
                    document.getElementById('modalLocationContainer').style.display = 'none';
                }

                // Description
                if (props.description) {
                    document.getElementById('modalDescription').innerText = props.description;
                    document.getElementById('modalDescriptionContainer').style.display = 'block';
                } else {
                    document.getElementById('modalDescriptionContainer').style.display = 'none';
                }

                // Style Modal Header
                var headerColor = event.backgroundColor;
                document.getElementById('modalHeader').style.backgroundColor = headerColor;

                var modal = new bootstrap.Modal(document.getElementById('eventModal'));
                modal.show();
            },
            eventTimeFormat: { 
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false
            }
        });
        calendar.render();
    });
</script>
@endsection
