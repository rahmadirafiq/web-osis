@extends('layouts.siswa')
@section('title','Voting')
@section('page-title','Voting')

@section('content')

@if($siswa->sudah_voting)
  <!-- SUDAH VOTING -->
  <div id="confettiContainer" class="confetti-container"></div>
  <div class="card" style="max-width:600px;margin:2rem auto">
    <div class="card-body status-page">
      <span class="status-icon">🎉</span>
      <h2>Suara Anda Telah Tercatat!</h2>
      <p>Terima kasih telah menggunakan hak pilih Anda. Suara Anda sangat berharga untuk masa depan OSIS SMAN 1 Bukittinggi.</p>
      <div style="margin-top:1.5rem">
        <a href="{{ route('siswa.hasil') }}" class="btn btn-primary">📊 Lihat Hasil Sementara</a>
      </div>
    </div>
  </div>

@elseif(!$votingOpen)
  <!-- VOTING BELUM DIBUKA -->
  <div class="card" style="max-width:600px;margin:2rem auto">
    <div class="card-body status-page">
      <span class="status-icon">🔒</span>
      <h2>Voting Belum Dibuka</h2>
      <p>Saat ini sistem voting masih ditutup. Pantau terus pengumuman dari panitia untuk informasi jadwal voting.</p>
    </div>
  </div>

@else
  <!-- FORM VOTING -->
  <div class="page-header">
    <h1>Berikan Suara Anda</h1>
    <p>Pilih satu paslon yang Anda percayai. Pilihan bersifat rahasia dan tidak dapat diubah.</p>
  </div>

  <div class="voting-grid" id="votingGrid">
    @foreach($kandidat as $k)
    <div class="voting-card" id="card-{{ $k->id }}" onclick="pilihKandidat({{ $k->id }})">
      <div class="voting-card-header">
        <div class="voting-checkmark" id="check-{{ $k->id }}">{{ $k->nomor_urut }}</div>
        <h3 style="font-size:1.1rem;margin-top:.5rem">Paslon {{ $k->nomor_urut }}</h3>
      </div>
      <div style="padding:1.25rem 0">
        <div class="kandidat-fotos" style="justify-content:center;gap:1.5rem;margin-bottom:1rem">
          <div class="foto-box">
            @if($k->foto_ketua)
              <img src="{{ asset('storage/'.$k->foto_ketua) }}" alt="" style="width:70px;height:70px;border-radius:50%;object-fit:cover;border:3px solid var(--gray-200)">
            @else
              <div class="foto-placeholder" style="width:70px;height:70px;font-size:1.5rem">👤</div>
            @endif
            <small style="color:var(--gray-600)">Ketua</small>
          </div>
          <div class="foto-box">
            @if($k->foto_wakil)
              <img src="{{ asset('storage/'.$k->foto_wakil) }}" alt="" style="width:70px;height:70px;border-radius:50%;object-fit:cover;border:3px solid var(--gray-200)">
            @else
              <div class="foto-placeholder" style="width:70px;height:70px;font-size:1.5rem">👤</div>
            @endif
            <small style="color:var(--gray-600)">Wakil</small>
          </div>
        </div>
        <h4 style="color:var(--navy);font-size:1rem;text-align:center">{{ $k->nama_ketua }}</h4>
        <p style="color:var(--gray-600);font-size:.85rem;text-align:center">& {{ $k->nama_wakil }}</p>
        <p style="color:var(--gray-600);font-size:.8rem;margin-top:.75rem;line-height:1.6">{{ Str::limit($k->visi, 80) }}</p>
        <a href="{{ route('siswa.kandidat.detail', $k->id) }}" class="btn btn-sm" style="background:var(--gray-100);color:var(--navy);width:100%;margin-top:.75rem" onclick="event.stopPropagation()">
          📖 Lihat Detail
        </a>
      </div>
    </div>
    @endforeach
  </div>

  <!-- TOMBOL VOTE -->
  <div class="vote-btn-area" id="voteBtnArea" style="display:none">
    <button class="btn btn-gold" onclick="openModal()" style="padding:1rem 3rem;font-size:1.05rem">
      ✅ Konfirmasi Pilihan Saya
    </button>
  </div>

  <!-- MODAL KONFIRMASI -->
  <div id="voteModal" style="display:none">
    <div class="modal-backdrop" onclick="closeModal()">
      <div class="modal-box" onclick="event.stopPropagation()">
        <h3>🗳️ Konfirmasi Pilihan</h3>
        <p>Apakah Anda yakin memilih <strong id="modalKandidatName">-</strong>?<br>
        <strong style="color:var(--danger)">Pilihan tidak dapat diubah setelah dikonfirmasi.</strong></p>

        <form id="voteForm" action="{{ route('siswa.voting.submit') }}" method="POST">
          @csrf
          <input type="hidden" name="kandidat_id" id="hiddenKandidatId">
          <div class="modal-actions">
            <button type="button" class="btn" style="background:var(--gray-100);color:var(--gray-800)" onclick="closeModal()">Batalkan</button>
            <button type="submit" class="btn btn-gold">✅ Ya, Saya Yakin</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endif
@endsection

@section('scripts')
<script>
let selectedId   = null;
let selectedName = null;

const kandidat = @json($kandidat->map(fn($k) => ['id'=>$k->id,'nomor'=>$k->nomor_urut,'nama'=>$k->nama_ketua.' & '.$k->nama_wakil]));

function pilihKandidat(id) {
  // reset semua
  kandidat.forEach(k => {
    document.getElementById('card-'  + k.id)?.classList.remove('selected');
    document.getElementById('check-' + k.id).textContent = k.nomor;
  });

  selectedId   = id;
  const k      = kandidat.find(x => x.id === id);
  selectedName = 'Paslon ' + k.nomor + ' (' + k.nama + ')';

  document.getElementById('card-' + id).classList.add('selected');
  document.getElementById('check-'+ id).textContent = '✓';
  document.getElementById('voteBtnArea').style.display = 'block';
  document.getElementById('voteBtnArea').scrollIntoView({behavior:'smooth', block:'nearest'});
}

function openModal() {
  if (!selectedId) return;
  document.getElementById('hiddenKandidatId').value = selectedId;
  document.getElementById('modalKandidatName').textContent = selectedName;
  document.getElementById('voteModal').style.display = 'flex';
}

function closeModal() {
  document.getElementById('voteModal').style.display = 'none';
}

// Confetti
@if($siswa->sudah_voting)
  const colors = ['#D4A843','#0B2545','#28a745','#dc3545','#17a2b8','#fff'];
  const container = document.getElementById('confettiContainer');
  for (let i = 0; i < 80; i++) {
    const p = document.createElement('div');
    p.className = 'confetti-piece confetti-' + (i % 4);
    p.style.cssText = `
      left: ${Math.random()*100}%;
      background: ${colors[Math.floor(Math.random()*colors.length)]};
      width: ${6+Math.random()*8}px;
      height: ${6+Math.random()*8}px;
      border-radius: ${Math.random()>0.5?'50%':'2px'};
      --fall-dur: ${1.5+Math.random()*2}s;
      --fall-delay: ${Math.random()*2}s;
    `;
    container.appendChild(p);
  }
@endif
</script>
@endsection