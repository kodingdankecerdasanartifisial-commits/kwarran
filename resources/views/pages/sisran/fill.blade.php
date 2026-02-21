<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Input Data: {{ $form->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .form-container { max-width: 650px; margin: 40px auto; }
        .form-header { 
            background: linear-gradient(135deg, #4B2C20 0%, #6d4130 100%); 
            color: white; 
            border-top-left-radius: 12px; 
            border-top-right-radius: 12px;
            padding: 30px;
            border-bottom: 5px solid #F2C94C;
        }
        .form-card { background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .form-body { padding: 30px; }
        .field-group { margin-bottom: 25px; }
        .form-label { font-weight: 600; color: #333; }
        .btn-submit { background-color: #4B2C20; color: white; padding: 12px 30px; border-radius: 8px; font-weight: 600; }
        .btn-submit:hover { background-color: #5d3728; color: white; }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2 class="mb-2">{{ $form->title }}</h2>
                <p class="mb-0 opacity-75">{{ $form->description }}</p>
            </div>
            <div class="form-body">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('sisran.public.store', $form->slug) }}" method="POST">
                    @csrf
                    
                    <div class="bg-light p-3 rounded-3 mb-4">
                        <h6 class="fw-bold mb-3 border-bottom pb-2">Informasi Pelapor / Unit</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small">Nama Lengkap Operator</label>
                                <input type="text" name="operator_name" class="form-control" placeholder="Contoh: Kak Ahmad" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Utusan / Unit / Gugus Depan</label>
                                <input type="text" name="operator_unit" class="form-control" placeholder="Contoh: Sanggar Bakti 01.001" required>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3 border-bottom pb-2">Data Isian Statistik</h6>
                    
                    @foreach($form->fields as $field)
                    <div class="field-group">
                        <label class="form-label">{{ $field->label }} @if($field->is_required)<span class="text-danger">*</span>@endif</label>
                        
                        @if($field->type === 'number')
                            <input type="number" name="values[{{ $field->id }}]" class="form-control" placeholder="Masukkan angka..." {{ $field->is_required ? 'required' : '' }}>
                        @elseif($field->type === 'select')
                            <select name="values[{{ $field->id }}]" class="form-select" {{ $field->is_required ? 'required' : '' }}>
                                <option value="">Pilih opsi...</option>
                                @foreach(explode(',', $field->options) as $option)
                                    <option value="{{ trim($option) }}">{{ trim($option) }}</option>
                                @endforeach
                            </select>
                        @elseif($field->type === 'radio')
                            <div class="mt-2">
                                @foreach(explode(',', $field->options) as $option)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="values[{{ $field->id }}]" id="opt_{{ $field->id }}_{{ $loop->index }}" value="{{ trim($option) }}" {{ $field->is_required ? 'required' : '' }}>
                                    <label class="form-check-label" for="opt_{{ $field->id }}_{{ $loop->index }}">
                                        {{ trim($option) }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        @elseif($field->type === 'checkbox')
                            <div class="mt-2">
                                @foreach(explode(',', $field->options) as $option)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="values[{{ $field->id }}][]" id="opt_{{ $field->id }}_{{ $loop->index }}" value="{{ trim($option) }}">
                                    <label class="form-check-label" for="opt_{{ $field->id }}_{{ $loop->index }}">
                                        {{ trim($option) }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <input type="text" name="values[{{ $field->id }}]" class="form-control" placeholder="Masukkan teks..." {{ $field->is_required ? 'required' : '' }}>
                        @endif
                    </div>
                    @endforeach

                    <div class="text-center mt-4 pt-3">
                        <button type="submit" class="btn btn-submit shadow-sm w-100">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Laporan Data
                        </button>
                        <p class="small text-muted mt-3">Sistem Informasi Statistik Kwarran Bekasi Timur</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
