<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; margin:0; display:flex; height:100vh; }
    .sidebar { width:280px; background:#fff; border-right:1px solid #e2e8f0; padding:20px; box-sizing:border-box; overflow-y:auto; }
    .sidebar h2 { font-size:16px; color:#0f172a; margin:0 0 16px 0; font-weight:600; }
    .sidebar-menu { list-style:none; margin:0; padding:0; }
    .sidebar-menu li { margin-bottom:8px; }
    .sidebar-menu a { display:block; padding:10px 12px; color:#334155; text-decoration:none; border-radius:6px; font-size:14px; transition:all 0.2s; }
    .sidebar-menu a:hover { background:#f1f5f9; color:#0f172a; }
    .sidebar-menu a.active { background:#e0f2fe; color:#003e6f; font-weight:500; }
    .main { flex:1; display:flex; flex-direction:column; }
    .topbar { background:#fff; border-bottom:1px solid #e2e8f0; padding:16px 24px; display:flex; justify-content:space-between; align-items:center; }
    .topbar h1 { margin:0; font-size:20px; color:#0f172a; }
    .content { flex:1; padding:24px; overflow-y:auto; }
    .card { background:#fff; border:1px solid #e2e8f0; padding:24px; border-radius:8px; box-shadow:0 1px 3px rgba(16,24,40,0.04); margin-bottom:24px; }
    .btn { background:#003e6f; color:#fff; border:none; padding:8px 14px; border-radius:6px; font-size:14px; cursor:pointer; text-decoration:none; display:inline-block; }
    .btn:hover { background:#002a4f; }
    .btn-danger { background:#dc2626; }
    .copyright { font-size:12px; color:#64748b; text-align:center; margin-top:20px; }
    .user-section { border-top:1px solid #e2e8f0; padding-top:16px; }
    .user-name { font-size:13px; color:#475569; margin-bottom:12px; }
    .charts-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-top:24px; }
    .chart-card { background:#fff; border:1px solid #e2e8f0; padding:20px; border-radius:8px; }
    .chart-card h3 { margin:0 0 16px 0; font-size:16px; color:#0f172a; }
    .chart-container { position:relative; height:300px; }
    .stat-box { background:#f8fafc; padding:16px; border-radius:8px; text-align:center; }
    .stat-number { font-size:28px; font-weight:700; color:#003e6f; }
    .stat-label { font-size:13px; color:#64748b; margin-top:4px; }
    @media (max-width:1200px) {
      .charts-grid { grid-template-columns:1fr; }
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Menu</h2>
    

    <ul class="sidebar-menu">
      <li><a href="{{ route('dashboard') }}" class="active">Dashboard</a></li>
      <li><a href="{{ route('banks.index') }}">📋 Psikotest Online</a></li>
      <li><a href="{{ route('employees.index') }}">👥 Database Karyawan</a></li>
    </ul>

    <div class="user-section">
      <div class="user-name">👤 {{ auth()->user()->name }}</div>
      <form method="POST" action="{{ route('logout') }}" style="margin:0;">
        @csrf
        <button type="submit" class="btn" style="width:100%; text-align:center; background:#003e6f; color:#fff;">Logout</button>
      </form>
    </div>
  </div>

  <div class="main">
    <div class="topbar">
      <h1>Dashboard</h1>
    </div>
    
    <div class="content">
      <div class="card">
        <h2>Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p style="color:#475569; margin-top:12px;">Pilih menu di samping untuk mengelola Psikotest Online atau Database Karyawan.</p>
        
        <div style="margin-top:24px; padding:16px; background:#f0fdf4; border-radius:6px; border-left:3px solid #10b981;">
          <strong style="color:#065f46;">💡 Fitur Tersedia:</strong>
          <ul style="margin:8px 0 0 0; color:#065f46; font-size:14px;">
            <li>📋 Kelola bank soal psikotest</li>
            <li>🔗 Generate link tes untuk peserta</li>
            <li>📊 Lihat hasil tes peserta</li>
            <li>👥 Kelola database karyawan</li>
            <li>📥 Import data karyawan dari CSV</li>
          </ul>
        </div>
        <div style="margin-top:18px; display:flex; gap:10px;">
          <a href="https://hrmsystemapp.com/login" target="_blank" class="btn" style="flex:1; background:#0ea5ad;">🔒 HRMS</a>
          <a href="https://idfileshare.example.com" target="_blank" class="btn" style="flex:1; background:#0ea5ad;">📁 IDFileshare</a>
          <a href="https://assessment.example.com" target="_blank" class="btn" style="flex:1; background:#7c3aed;">🧾 Assessment</a>
        </div>

        <div class="copyright">
          copyright @2026 Shindengen HR Internal Team
        </div>
      </div>

      <div class="card">
        <div class="stat-box">
          <div class="stat-number">{{ $totalEmployees }}</div>
          <div class="stat-label">Total Karyawan</div>
        </div>
      </div>

      <div class="charts-grid">
        <div class="chart-card">
          <h3>📊 Distribusi Karyawan per Departemen</h3>
          <div class="chart-container">
            <canvas id="deptChart"></canvas>
          </div>
        </div>

        <div class="chart-card">
          <h3>📈 Status Karyawan</h3>
          <div class="chart-container">
            <canvas id="statusChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Colors for charts
    const colors = ['#667eea', '#764ba2', '#f093fb', '#4facfe', '#00f2fe', '#43e97b', '#fa709a', '#fee140'];

    // Departemen Chart
    const deptCtx = document.getElementById('deptChart').getContext('2d');
    new Chart(deptCtx, {
      type: 'bar',
      data: {
        labels: {!! json_encode($deptLabels) !!},
        datasets: [{
          label: 'Jumlah Karyawan',
          data: {!! json_encode($deptData) !!},
          backgroundColor: colors.slice(0, {!! json_encode($deptLabels) !!}.length),
          borderColor: '#e2e8f0',
          borderWidth: 1,
          borderRadius: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y',
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            ticks: { stepSize: 1 }
          }
        }
      }
    });

    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
      type: 'pie',
      data: {
        labels: {!! json_encode($statusLabels) !!},
        datasets: [{
          data: {!! json_encode($statusData) !!},
          backgroundColor: ['#10b981', '#f59e0b'],
          borderColor: '#fff',
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { font: { size: 13 }, padding: 15 }
          }
        }
      }
    });
  </script>
</body>
</html>

