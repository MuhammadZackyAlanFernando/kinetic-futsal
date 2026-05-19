@extends('layouts.user')

@section('title', 'Booking — ' . $lapangan->nama_lapangan)

@push('styles')
<style>
    :root { --dark-green:#1a3c2e; --medium-green:#2d6a4f; --light-green:#52b788; }

    .booking-wrapper { max-width: 860px; margin: 0 auto; padding: 2rem 1.5rem 3rem; }

    /* ── Step Progress ── */
    .step-progress { display: flex; align-items: center; margin-bottom: 2rem; }
    .step-item { display: flex; align-items: center; flex: 1; }
    .step-circle {
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: .82rem; font-weight: 700; flex-shrink: 0;
        transition: all .3s;
    }
    .step-circle.active { background: var(--medium-green); color: #fff; box-shadow: 0 4px 12px rgba(45,106,79,.35); }
    .step-circle.done   { background: var(--light-green);  color: #fff; }
    .step-circle.idle   { background: #e5e7eb; color: #9ca3af; }
    .step-label { font-size: .78rem; font-weight: 600; margin-top: .35rem; }
    .step-label.active { color: var(--medium-green); }
    .step-label.idle   { color: #9ca3af; }
    .step-connector { flex: 1; height: 2px; background: #e5e7eb; margin: 0 .5rem; transition: background .3s; }
    .step-connector.done { background: var(--light-green); }

    /* ── Lapangan Info Card ── */
    .court-info-card {
        background: #fff; border-radius: 18px;
        box-shadow: 0 4px 24px rgba(0,0,0,.08);
        overflow: hidden; margin-bottom: 1.5rem;
    }
    .court-info-img { width: 100%; height: 200px; object-fit: cover; }
    .court-info-placeholder {
        height: 200px; background: linear-gradient(135deg, #0d2318, var(--dark-green));
        display: flex; align-items: center; justify-content: center;
        font-size: 4rem; color: rgba(82,183,136,.5);
    }
    .court-info-body { padding: 1.25rem 1.5rem; }
    .court-info-name { font-size: 1.1rem; font-weight: 700; color: #1f2937; margin-bottom: .3rem; }
    .court-info-desc { font-size: .85rem; color: #6b7280; margin-bottom: .75rem; }
    .court-price-tag {
        display: inline-flex; align-items: center; gap: .4rem;
        background: linear-gradient(135deg, var(--medium-green), var(--dark-green));
        color: #fff; padding: .4rem 1rem; border-radius: 20px;
        font-size: .875rem; font-weight: 700;
    }

    /* ── Multi-step Form Cards ── */
    .form-step { display: none; }
    .form-step.active { display: block; animation: fadeIn .25s ease; }
    @keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }

    .booking-card {
        background: #fff; border-radius: 18px;
        box-shadow: 0 4px 24px rgba(0,0,0,.08);
        padding: 2rem;
    }
    .booking-card-title {
        font-size: 1rem; font-weight: 700; color: #1f2937;
        margin-bottom: 1.5rem; display: flex; align-items: center; gap: .6rem;
    }
    .booking-card-title i { color: var(--light-green); }

    .form-label-modern { font-size: .875rem; font-weight: 600; color: #374151; margin-bottom: .4rem; }
    .form-control-modern {
        border: 2px solid #e8eae8; border-radius: 12px;
        padding: .75rem 1rem; font-size: .9rem; height: auto;
        transition: border-color .2s, box-shadow .2s;
    }
    .form-control-modern:focus {
        border-color: var(--light-green);
        box-shadow: 0 0 0 4px rgba(82,183,136,.12); outline: none;
    }
    .form-control-modern:disabled { background: #f8faf8; color: #9ca3af; }

    /* Time selector */
    .time-selector-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .time-input-wrap { position: relative; }
    .time-input-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--light-green); font-size: .85rem; }
    .time-input-wrap .form-control-modern { padding-left: 2.6rem; }

    /* Estimasi harga animado */
    .price-estimator {
        background: linear-gradient(135deg, #e8f5ee, #d1fae5);
        border: 2px solid #a7f3d0;
        border-radius: 14px; padding: 1.25rem 1.5rem;
        margin-top: 1.25rem; display: none;
        animation: fadeIn .3s ease;
    }
    .price-estimator.show { display: block; }
    .price-label { font-size: .8rem; color: #065f46; font-weight: 500; margin-bottom: .25rem; }
    .price-value { font-size: 1.6rem; font-weight: 800; color: var(--medium-green); }
    .price-breakdown { font-size: .78rem; color: #6b7280; margin-top: .3rem; }

    /* Confirmation summary */
    .summary-card {
        background: #f8faf8; border-radius: 14px;
        border: 2px solid #e8eae8; padding: 1.25rem;
        margin-bottom: 1.25rem;
    }
    .summary-row { display: flex; justify-content: space-between; align-items: center; padding: .5rem 0; border-bottom: 1px solid #f3f4f6; font-size: .875rem; }
    .summary-row:last-child { border-bottom: none; }
    .summary-row .label { color: #6b7280; font-weight: 500; }
    .summary-row .value { color: #1f2937; font-weight: 600; }
    .summary-total { background: var(--dark-green); border-radius: 10px; padding: .75rem 1rem; display: flex; justify-content: space-between; align-items: center; }
    .summary-total .label { color: rgba(255,255,255,.75); font-size: .875rem; }
    .summary-total .value { color: #fff; font-size: 1.2rem; font-weight: 800; }

    /* Buttons */
    .btn-next {
        background: linear-gradient(135deg, var(--medium-green), var(--dark-green));
        border: none; color: #fff; font-weight: 600;
        padding: .85rem 2rem; border-radius: 12px;
        transition: all .2s; box-shadow: 0 4px 15px rgba(45,106,79,.3);
    }
    .btn-next:hover { opacity:.92; transform:translateY(-1px); box-shadow:0 8px 25px rgba(45,106,79,.4); color:#fff; }
    .btn-back {
        background: #f3f4f6; border: none; color: #374151; font-weight: 600;
        padding: .85rem 1.5rem; border-radius: 12px; transition: all .2s;
    }
    .btn-back:hover { background: #e5e7eb; }
    .btn-confirm {
        background: linear-gradient(135deg, var(--light-green), var(--medium-green));
        border: none; color: #fff; font-weight: 700;
        padding: .9rem 2rem; border-radius: 12px;
        box-shadow: 0 4px 15px rgba(82,183,136,.35);
        transition: all .2s;
    }
    .btn-confirm:hover { transform:translateY(-2px); box-shadow:0 10px 30px rgba(82,183,136,.45); color:#fff; }

    .alert { border-radius: 12px; border: none; }
    .alert-danger { background: #fee2e2; color: #991b1b; }
</style>
@endpush

@section('content')
<div class="booking-wrapper">

    {{-- ── Step Progress ── --}}
    <div class="step-progress mb-4">
        <div style="text-align:center;">
            <div class="step-circle active" id="sc1">1</div>
            <div class="step-label active" id="sl1">Pilih Waktu</div>
        </div>
        <div class="step-connector" id="con1"></div>
        <div style="text-align:center;">
            <div class="step-circle idle" id="sc2">2</div>
            <div class="step-label idle" id="sl2">Konfirmasi</div>
        </div>
    </div>

    {{-- ── Lapangan Info ── --}}
    <div class="court-info-card">
        <div class="row g-0">
            @if($lapangan->gambar)
                <div class="col-md-4">
                    <img src="{{ asset('storage/' . $lapangan->gambar) }}"
                         class="court-info-img" alt="{{ $lapangan->nama_lapangan }}">
                </div>
            @endif
            <div class="col-md-{{ $lapangan->gambar ? '8' : '12' }}">
                <div class="court-info-body">
                    <div class="court-info-name"><i class="fas fa-futbol me-2" style="color:var(--light-green);"></i>{{ $lapangan->nama_lapangan }}</div>
                    <div class="court-info-desc">{{ $lapangan->deskripsi ?? 'Lapangan futsal berkualitas untuk pengalaman bermain terbaik.' }}</div>
                    <div class="court-price-tag">
                        <i class="fas fa-tag"></i>
                        Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}/jam
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── FORM ── --}}
    <form action="{{ route('user.booking.store') }}" method="POST" id="bookingForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">

        {{-- Error --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-3">
                <i class="fas fa-exclamation-circle me-2"></i>
                @foreach($errors->all() as $error){{ $error }}<br>@endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ── STEP 1: Pilih Waktu ── --}}
        <div class="form-step active" id="step1">
            <div class="booking-card">
                <div class="booking-card-title"><i class="fas fa-calendar-days"></i> Pilih Tanggal & Waktu</div>

                <div class="mb-4">
                    <label class="form-label-modern">Tanggal Booking <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_booking" id="tanggal_booking"
                           class="form-control form-control-modern"
                           min="{{ date('Y-m-d') }}"
                           value="{{ old('tanggal_booking') }}" required>
                </div>

                <div class="time-selector-grid mb-3">
                    <div>
                        <label class="form-label-modern">Jam Mulai <span class="text-danger">*</span></label>
                        <div class="time-input-wrap">
                            <i class="fas fa-clock"></i>
                            <input type="time" name="jam_mulai" id="jam_mulai"
                                   class="form-control form-control-modern"
                                   value="{{ old('jam_mulai') }}" required>
                        </div>
                    </div>
                    <div>
                        <label class="form-label-modern">Jam Selesai <span class="text-danger">*</span></label>
                        <div class="time-input-wrap">
                            <i class="fas fa-clock"></i>
                            <input type="time" name="jam_selesai" id="jam_selesai"
                                   class="form-control form-control-modern"
                                   value="{{ old('jam_selesai') }}" required>
                        </div>
                    </div>
                </div>

                {{-- Estimasi Harga ── --}}
                <div class="price-estimator" id="estimasiBox">
                    <div class="price-label"><i class="fas fa-calculator me-1"></i> Estimasi Biaya</div>
                    <div class="price-value" id="estimasiHarga">Rp 0</div>
                    <div class="price-breakdown" id="estimasiBreakdown"></div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="button" class="btn btn-next" onclick="goToStep2()">
                        Lanjut ke Konfirmasi <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- ── STEP 2: Konfirmasi ── --}}
        <div class="form-step" id="step2">
            <div class="booking-card">
                <div class="booking-card-title"><i class="fas fa-clipboard-check"></i> Konfirmasi Booking</div>

                <div class="summary-card">
                    <div class="summary-row">
                        <span class="label"><i class="fas fa-door-open me-2"></i>Lapangan</span>
                        <span class="value">{{ $lapangan->nama_lapangan }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="label"><i class="fas fa-calendar me-2"></i>Tanggal</span>
                        <span class="value" id="sumTanggal">—</span>
                    </div>
                    <div class="summary-row">
                        <span class="label"><i class="fas fa-clock me-2"></i>Waktu</span>
                        <span class="value" id="sumWaktu">—</span>
                    </div>
                    <div class="summary-row">
                        <span class="label"><i class="fas fa-hourglass me-2"></i>Durasi</span>
                        <span class="value" id="sumDurasi">—</span>
                    </div>
                </div>

                <div class="summary-total">
                    <span class="label">Total Estimasi Biaya</span>
                    <span class="value" id="sumTotal">Rp 0</span>
                </div>

                <div class="mt-4 mb-4">
                    <h6 class="mb-3" style="font-weight: 700; color: #1f2937;"><i class="fas fa-money-bill-wave me-2" style="color:var(--medium-green);"></i>Informasi Pembayaran</h6>
                    <div class="alert alert-info" style="background:#e0f2fe; color:#0369a1; border-radius:12px; font-size:.85rem; border: none;">
                        <i class="fas fa-wallet me-2"></i> Silakan transfer ke rekening <strong>BCA 1234567890 a.n. Kinetic Futsal</strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern">Nama Rekening Pengirim <span class="text-danger">*</span></label>
                        <input type="text" name="nama_rekening" class="form-control form-control-modern" value="{{ old('nama_rekening') }}" placeholder="Contoh: Budi Santoso" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label-modern">Nomor Rekening Pengirim <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_rekening" class="form-control form-control-modern" value="{{ old('nomor_rekening') }}" placeholder="Contoh: 0987654321" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label-modern">Bukti Pembayaran <span class="text-danger">*</span></label>
                        <input type="file" name="bukti_pembayaran" class="form-control form-control-modern" accept="image/*" required style="padding: .5rem 1rem;">
                        <div class="mt-1" style="font-size: 0.75rem; color: #6b7280;">Format: JPG, JPEG, PNG. Max: 2MB.</div>
                    </div>
                </div>

                <div class="alert mt-3" style="background:#fef3c7; color:#92400e; border-radius:12px; font-size:.85rem;">
                    <i class="fas fa-info-circle me-2"></i>
                    Booking akan diproses setelah disetujui oleh admin. Status akan diperbarui segera.
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button type="button" class="btn btn-back" onclick="goToStep1()">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </button>
                    <button type="submit" class="btn btn-confirm">
                        <i class="fas fa-check me-2"></i>Konfirmasi Booking
                    </button>
                </div>
            </div>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
    const hargaPerJam = parseInt('{{ $lapangan->harga_per_jam }}');
    const jamMulaiEl   = document.getElementById('jam_mulai');
    const jamSelesaiEl = document.getElementById('jam_selesai');

    function hitungEstimasi() {
        const mulai   = jamMulaiEl.value;
        const selesai = jamSelesaiEl.value;
        const box     = document.getElementById('estimasiBox');

        if (mulai && selesai) {
            const [h1,m1] = mulai.split(':').map(Number);
            const [h2,m2] = selesai.split(':').map(Number);
            const menit = (h2*60+m2) - (h1*60+m1);
            if (menit > 0) {
                const jam   = menit / 60;
                const total = jam * hargaPerJam;
                document.getElementById('estimasiHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
                document.getElementById('estimasiBreakdown').textContent = `${jam % 1 === 0 ? jam : jam.toFixed(1)} jam × Rp ${hargaPerJam.toLocaleString('id-ID')}`;
                box.classList.add('show');
                return { menit, jam, total };
            }
        }
        box.classList.remove('show');
        return null;
    }

    jamMulaiEl.addEventListener('change', hitungEstimasi);
    jamSelesaiEl.addEventListener('change', hitungEstimasi);

    function goToStep2() {
        const tanggal = document.getElementById('tanggal_booking').value;
        const mulai   = jamMulaiEl.value;
        const selesai = jamSelesaiEl.value;

        if (!tanggal || !mulai || !selesai) {
            alert('Lengkapi tanggal dan waktu booking terlebih dahulu.');
            return;
        }
        const data = hitungEstimasi();
        if (!data) { alert('Jam selesai harus setelah jam mulai.'); return; }

        // Fill summary
        const d = new Date(tanggal + 'T00:00:00');
        const opts = { day:'numeric', month:'long', year:'numeric' };
        document.getElementById('sumTanggal').textContent = d.toLocaleDateString('id-ID', opts);
        document.getElementById('sumWaktu').textContent   = mulai + ' – ' + selesai;
        document.getElementById('sumDurasi').textContent  = (data.jam % 1 === 0 ? data.jam : data.jam.toFixed(1)) + ' jam';
        document.getElementById('sumTotal').textContent   = 'Rp ' + data.total.toLocaleString('id-ID');

        // Step progress
        document.getElementById('step1').classList.remove('active');
        document.getElementById('step2').classList.add('active');

        document.getElementById('sc1').classList.replace('active','done');
        document.getElementById('sl1').classList.replace('active','idle');
        document.getElementById('con1').classList.add('done');
        document.getElementById('sc2').classList.replace('idle','active');
        document.getElementById('sl2').classList.replace('idle','active');
    }

    function goToStep1() {
        document.getElementById('step2').classList.remove('active');
        document.getElementById('step1').classList.add('active');

        document.getElementById('sc1').classList.replace('done','active');
        document.getElementById('sl1').classList.replace('idle','active');
        document.getElementById('con1').classList.remove('done');
        document.getElementById('sc2').classList.replace('active','idle');
        document.getElementById('sl2').classList.replace('active','idle');
    }
</script>
@endpush