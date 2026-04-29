<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
  body { font-family: Arial, sans-serif; font-size: 12px; }
  h2 { color: #0B2545; text-align: center; }
  table { width: 100%; border-collapse: collapse; margin-top: 20px; }
  th { background: #0B2545; color: white; padding: 8px; }
  td { padding: 8px; border: 1px solid #ddd; }
  tr:nth-child(even) { background: #f8f8f8; }
</style>
</head>
<body>
<h2>Rekap Hasil Voting OSIS</h2>
<p style="text-align:center;color:#666">Dicetak: {{ now()->format('d F Y, H:i') }} WIB</p>
<table>
  <thead><tr><th>No</th><th>Ketua</th><th>Wakil</th><th>Suara</th><th>Persentase</th></tr></thead>
  <tbody>
    @foreach($kandidat as $k)
    @php $pct = $totalVotes > 0 ? round($k->votes_count/$totalVotes*100,2) : 0; @endphp
    <tr>
      <td>Paslon {{ $k->nomor_urut }}</td>
      <td>{{ $k->nama_ketua }}</td>
      <td>{{ $k->nama_wakil }}</td>
      <td style="text-align:center;font-weight:bold">{{ $k->votes_count }}</td>
      <td style="text-align:center">{{ $pct }}%</td>
    </tr>
    @endforeach
    <tr style="background:#f0f0f0;font-weight:bold">
      <td colspan="3" style="text-align:right">Total</td>
      <td style="text-align:center">{{ $totalVotes }}</td>
      <td style="text-align:center">100%</td>
    </tr>
  </tbody>
</table>
</body>
</html>