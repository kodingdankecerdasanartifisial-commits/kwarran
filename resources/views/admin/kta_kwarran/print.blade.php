<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak KTA - {{ $kta_kwarran->nama_lengkap }}</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: white;
            }
            .no-print {
                display: none !important;
            }
            @page {
                size: portrait;
                margin: 1cm;
            }
        }
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .controls {
            margin-bottom: 30px;
            background: #fff;
            padding: 15px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .btn {
            padding: 10px 20px;
            background: #4B2C20;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn:hover { background: #3a2219; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #5a6268; }
        
        .kta-wrapper {
            /* Container to help visual rendering clearly */
            padding: 20px;
            background: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .kta-card {
            width: 8.6cm;
            height: 5.4cm;
            background-image: url("{{ asset('bg.png') }}");
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center;
            border: 1px dotted #999; /* Dotted line explicitly telling to cut here */
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
        }
        /* Gradient header */
        .kta-header {
            background: linear-gradient(90deg, #d32f2f 0%, #b71c1c 100%);
            color: white;
            text-align: center;
            padding: 8px 0;
            font-size: 9px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border-bottom: 2px solid #F2C94C;
        }
        .kta-header img {
            position: absolute;
            height: 30px;
            top: 50%;
            transform: translateY(-50%);
        }
        .kta-header .logo-left {
            left: 10px;
            filter: brightness(0); /* Black logo if using standard tunas */
        }
        .kta-header .logo-right {
            right: 10px;
        }
        
        .kta-body {
            display: flex;
            padding: 6px;
            gap: 8px;
            flex: 1;
            position: relative;
        }

        .kta-photo {
            width: 2.2cm;
            height: 3cm;
            background-color: #eee;
            border: 1px solid #bbb;
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 1px 1px 3px rgba(0,0,0,0.2);
            z-index: 2;
        }
        
        .kta-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .kta-details {
            flex: 1;
            font-size: 7px;
            line-height: 1.3;
            z-index: 2;
        }

        .kta-details table {
            width: 100%;
            border-spacing: 0;
            margin-top: 2px;
        }
        
        .kta-details td {
            vertical-align: top;
            padding: 1.5px 0;
        }

        .kta-details .label {
            width: 32%;
            font-weight: bold;
            color: #4B2C20;
        }
        
        .kta-details td:nth-child(2) {
            width: 4%;
        }

        .kta-nta {
            font-size: 11px;
            font-weight: bold;
            color: #fff;
            background: #4B2C20;
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            margin-bottom: 4px;
            margin-top: 3px;
        }

        .kta-footer {
            position: absolute;
            bottom: 1px;
            right: 8px;
            font-size: 7.5px;
            text-align: right;
            color: #001;
            z-index: 2;
            line-height: 1.1;
        }

        .kta-validity {
            position: absolute;
            bottom: 6px;
            left: 6px;
            font-size: 4.5px;
            color: #333;
            width: 2.3cm;
            font-style: italic;
            z-index: 2;
            line-height: 1.2;
            text-align: justify;
        }
        

    </style>
</head>
<body>
    <div class="controls no-print">
        <h3 style="margin-top:0;">Pratinjau Cetak KTA</h3>
        <p style="font-size:14px;color:#555;">KTA akan dicetak sesuai dengan ukuran standar (8.6 x 5.4 cm).</p>
        <button class="btn" onclick="window.print()"><i class="fas fa-print"></i> Cetak Sekarang</button>
        <a href="{{ route('admin.kta_kwarran.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="kta-wrapper">
        <div class="kta-card">
            <div class="kta-header">
                <img src="{{ asset('tunas_kelapa.png') }}" class="logo-left" alt="Tunas Kelapa Hitam">
                <div style="line-height: 1.3;">
                    KARTU TANDA ANGGOTA GERAKAN PRAMUKA<br>
                    KWARTIR RANTING BEKASI TIMUR KOTA BEKASI
                </div>
                <img src="{{ asset('wosm.png') }}" class="logo-right" alt="WOSM">
            </div>
            <div class="kta-body">
                <!-- QR Code using SVG with CSS overlay logo to avoid Imagick dependency -->
                <div class="kta-qrcode" style="position: absolute; top: 6px; right: 8px; z-index: 2; border: 1px solid #ccc; padding: 0; background: #fff; border-radius: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                    <div style="position: relative; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(32)->format('svg')->margin(0)->errorCorrection('H')->generate(route('validasi.kta', $kta_kwarran->id)) !!}
                        <img src="{{ asset('logo.png') }}" style="position: absolute; width: 30%; height: 30%; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 0.5px; border-radius: 1px;">
                    </div>
                </div>

                <div class="kta-photo">
                    @if($kta_kwarran->pas_foto)
                        <img src="{{ asset('storage/' . $kta_kwarran->pas_foto) }}" alt="Foto Anggota">
                    @else
                        <span style="font-size:8px;text-align:center;color:#999"><i class="fas fa-user mb-1"></i><br>Foto<br>3x4</span>
                    @endif
                </div>
                <div class="kta-details">
                    <div class="kta-nta">NTA: {{ $kta_kwarran->nta ?? '-' }}</div>
                    <table>
                        <tr>
                            <td class="label">Nama</td>
                            <td>:</td>
                            <td><strong>{{ strtoupper($kta_kwarran->nama_lengkap) }}</strong></td>
                        </tr>
                        <tr>
                            <td class="label">Tempat/Tgl Lahir</td>
                            <td>:</td>
                            <td>{{ $kta_kwarran->tempat_tanggal_lahir }}</td>
                        </tr>
                        <tr>
                            <td class="label">Pangkalan</td>
                            <td>:</td>
                            <td>{{ $kta_kwarran->pangkalan }}</td>
                        </tr>
                        @if($kta_kwarran->nomor_gudep)
                        <tr>
                            <td class="label">Nomor Gudep</td>
                            <td>:</td>
                            <td>{{ $kta_kwarran->nomor_gudep }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="label">Alamat Lengkap</td>
                            <td>:</td>
                            <td style="font-size: 6.5px; line-height: 1.1;">{{ $kta_kwarran->alamat_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="label">Kwarran</td>
                            <td>:</td>
                            <td>{{ $kta_kwarran->kwarran }}</td>
                        </tr>
                        <tr>
                            <td class="label">Jabatan/Gol.</td>
                            <td>:</td>
                            <td>{{ $kta_kwarran->jabatan_golongan }}</td>
                        </tr>
                        <tr>
                            <td class="label">Agama</td>
                            <td>:</td>
                            <td>{{ $kta_kwarran->agama }}</td>
                        </tr>
                        <tr>
                            <td class="label">Gol. Darah</td>
                            <td>:</td>
                            <td>{{ $kta_kwarran->golongan_darah }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="kta-validity">
                * Berlaku sampai dengan masa golongan selesai sejak diterbitkan/ setelah jabatan berakhir
            </div>

            <div class="kta-footer">
                Bekasi, {{ now()->translatedFormat('d F Y') }}<br>
                <img src="{{ asset('ttd.png') }}" style="height: 1.2cm; width: auto; display: block; margin: 0 0 0 auto;">
            </div>
        </div>
    </div>
</body>
</html>
