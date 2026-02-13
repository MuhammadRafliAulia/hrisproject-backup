<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Surat Peringatan {{ $letter->sp_label }} - {{ $letter->nama }}</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #1a1a1a; line-height: 1.6; }
    .page { padding: 30px 50px; max-width: 800px; margin: 0 auto; }

    .header { text-align: center; border-bottom: 3px double #003e6f; padding-bottom: 14px; margin-bottom: 24px; }
    .header .company { font-size: 18pt; font-weight: bold; color: #003e6f; letter-spacing: 1px; }
    .header .address { font-size: 9pt; color: #64748b; margin-top: 4px; }

    .title { text-align: center; margin: 20px 0 6px 0; }
    .title h1 { font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase; }
    .nomor-surat { text-align: center; font-size: 11pt; margin-bottom: 20px; }

    .body-text { font-size: 11pt; text-align: justify; margin-bottom: 14px; }
    .body-text p { margin-bottom: 10px; text-indent: 40px; }

    .recipient { margin-bottom: 16px; margin-left: 40px; }
    .recipient table { border-collapse: collapse; }
    .recipient td { padding: 2px 8px 2px 0; font-size: 11pt; vertical-align: top; }
    .recipient .label { font-weight: bold; width: 120px; }

    .sig-table { width: 100%; margin-top: 30px; border-collapse: collapse; }
    .sig-table td { text-align: center; vertical-align: top; padding: 0 8px; width: 50%; }
    .sig-block { margin-bottom: 20px; }
    .sig-block .sig-title { font-size: 10pt; font-weight: bold; margin-bottom: 4px; }
    .sig-block .sig-jabatan { font-size: 9pt; color: #475569; margin-bottom: 6px; }
    .sig-block .sig-img { height: 60px; display: flex; align-items: center; justify-content: center; margin: 4px auto; }
    .sig-block .sig-img img { max-width: 150px; max-height: 55px; }
    .sig-block .sig-name { font-size: 10pt; font-weight: bold; border-top: 1px solid #1a1a1a; display: inline-block; padding-top: 3px; min-width: 150px; }

    .sig-full { text-align: center; margin-top: 10px; }

    .closing { margin-top: 20px; font-size: 11pt; text-align: justify; }
    .closing p { margin-bottom: 10px; text-indent: 40px; }

    .footer { text-align: center; font-size: 8pt; color: #94a3b8; margin-top: 30px; padding-top: 10px; border-top: 1px solid #e2e8f0; }

    @media print { .page { padding: 20px 40px; } }
  </style>
</head>
<body>
  <div class="page">

    {{-- Header Perusahaan --}}
    <div class="header">
      <div class="company">PT. SHINDENGEN INDONESIA</div>
      <div class="address">Jl. Irian Blok NN No.1, Bekasi International Industrial Estate, Lippo Cikarang, Bekasi 17550</div>
    </div>

    {{-- Judul Surat --}}
    <div class="title">
      <h1>Surat Peringatan</h1>
    </div>
    <div class="nomor-surat">
      @if($letter->nomor_surat)
        Nomor: {{ $letter->nomor_surat }}
      @else
        Nomor: ...................
      @endif
    </div>

    {{-- Paragraf Pembuka --}}
    <div class="body-text">
      <p>Surat peringatan ini dibuat oleh pimpinan kerja dan ditujukan kepada:</p>
    </div>

    {{-- Data Penerima --}}
    <div class="recipient">
      <table>
        <tr>
          <td class="label">Nama</td>
          <td>: {{ $letter->nama }}</td>
        </tr>
        @if($letter->nik)
        <tr>
          <td class="label">NIK</td>
          <td>: {{ $letter->nik }}</td>
        </tr>
        @endif
        <tr>
          <td class="label">Jabatan</td>
          <td>: {{ $letter->jabatan }}</td>
        </tr>
        <tr>
          <td class="label">Departemen</td>
          <td>: {{ $letter->departemen }}</td>
        </tr>
      </table>
    </div>

    {{-- Paragraf Alasan --}}
    <div class="body-text">
      <p>Surat peringatan ini diterbitkan oleh pimpinan kerja berdasarkan atas {{ $letter->alasan }}</p>
    </div>

    {{-- Paragraf Kedua (opsional) --}}
    @if($letter->paragraf_kedua)
    <div class="body-text">
      <p>{{ $letter->paragraf_kedua }}</p>
    </div>
    @endif

    {{-- Paragraf Penutup --}}
    <div class="closing">
      <p>Oleh karena itu, selaku pimpinan kerja memberikan <strong>{{ $letter->sp_label }}</strong>. Hal ini bertujuan untuk mengingatkan kepada operator didalam bekerja agar tidak terjadi kelalaian dikemudian hari. Surat peringatan ini berlaku selama 6 (enam) bulan terhitung dari tanggal dikeluarkannya surat peringatan ini.</p>
    </div>

    {{-- Tempat & Tanggal --}}
    <div style="text-align: right; margin-top: 20px; font-size: 11pt;">
      Bekasi, {{ $letter->tanggal_surat ? $letter->tanggal_surat->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
    </div>

    {{-- ===== TANDA TANGAN 5 LAYER ===== --}}

    {{-- Baris 1: 2 Penandatangan Utama --}}
    <table class="sig-table">
      <tr>
        {{-- Utama 1 - Pimpinan Kerja --}}
        <td>
          <div class="sig-block">
            <div class="sig-title">Pimpinan Kerja</div>
            @if($letter->signer_jabatan_1)
              <div class="sig-jabatan">{{ $letter->signer_jabatan_1 }}</div>
            @endif
            <div class="sig-img">
              @if($letter->signature_1)
                <img src="{{ $letter->signature_1 }}" alt="TTD 1">
              @endif
            </div>
            <div class="sig-name">
              @if($letter->signer_name_1)
                {{ $letter->signer_name_1 }}
              @else
                (.................................)
              @endif
            </div>
          </div>
        </td>

        {{-- Utama 2 - Atasan --}}
        <td>
          <div class="sig-block">
            <div class="sig-title">Atasan</div>
            @if($letter->signer_jabatan_2)
              <div class="sig-jabatan">{{ $letter->signer_jabatan_2 }}</div>
            @endif
            <div class="sig-img">
              @if($letter->signature_2)
                <img src="{{ $letter->signature_2 }}" alt="TTD 2">
              @endif
            </div>
            <div class="sig-name">
              @if($letter->signer_name_2)
                {{ $letter->signer_name_2 }}
              @else
                (.................................)
              @endif
            </div>
          </div>
        </td>
      </tr>
    </table>

    {{-- Baris 2: 2 Saksi --}}
    <table class="sig-table">
      <tr>
        {{-- Saksi 1 --}}
        <td>
          <div class="sig-block">
            <div class="sig-title">Saksi 1</div>
            @if($letter->signer_jabatan_3)
              <div class="sig-jabatan">{{ $letter->signer_jabatan_3 }}</div>
            @endif
            <div class="sig-img">
              @if($letter->signature_3)
                <img src="{{ $letter->signature_3 }}" alt="TTD 3">
              @endif
            </div>
            <div class="sig-name">
              @if($letter->signer_name_3)
                {{ $letter->signer_name_3 }}
              @else
                (.................................)
              @endif
            </div>
          </div>
        </td>

        {{-- Saksi 2 --}}
        <td>
          <div class="sig-block">
            <div class="sig-title">Saksi 2</div>
            @if($letter->signer_jabatan_4)
              <div class="sig-jabatan">{{ $letter->signer_jabatan_4 }}</div>
            @endif
            <div class="sig-img">
              @if($letter->signature_4)
                <img src="{{ $letter->signature_4 }}" alt="TTD 4">
              @endif
            </div>
            <div class="sig-name">
              @if($letter->signer_name_4)
                {{ $letter->signer_name_4 }}
              @else
                (.................................)
              @endif
            </div>
          </div>
        </td>
      </tr>
    </table>

    {{-- Baris 3: HR (tengah) --}}
    <table class="sig-table">
      <tr>
        <td colspan="2">
          <div class="sig-block sig-full">
            <div class="sig-title">Mengetahui, HR</div>
            @if($letter->signer_jabatan_5)
              <div class="sig-jabatan">{{ $letter->signer_jabatan_5 }}</div>
            @endif
            <div class="sig-img">
              @if($letter->signature_5)
                <img src="{{ $letter->signature_5 }}" alt="TTD HR">
              @endif
            </div>
            <div class="sig-name">
              @if($letter->signer_name_5)
                {{ $letter->signer_name_5 }}
              @else
                (.................................)
              @endif
            </div>
          </div>
        </td>
      </tr>
    </table>

    @if($letter->isApproved())
    <div style="text-align:center;margin-top:12px;padding:6px;border:1px solid #d1fae5;background:#ecfdf5;border-radius:4px;">
      <span style="font-size:9pt;color:#065f46;font-weight:bold;">✅ Ditandatangani pada {{ $letter->approved_at ? $letter->approved_at->translatedFormat('d F Y, H:i') : '-' }}
      @if($letter->approver)
        oleh {{ $letter->approver->name }}
      @endif
      </span>
    </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
      Dokumen ini dicetak secara otomatis oleh Sistem HR - PT. Shindengen Indonesia
    </div>

  </div>
</body>
</html>
