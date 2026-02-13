<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Weekly Planner - HRIS</title>
<link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
<style>
*{box-sizing:border-box;margin:0;padding:0;}

/* Compact Header */
.wp-header{background:#fff;border-bottom:1px solid #e2e8f0;padding:8px 16px;display:flex;align-items:center;gap:8px;flex-wrap:wrap;}
.wp-title{font-size:16px;font-weight:600;color:#0f172a;}
.wp-nav{display:flex;align-items:center;gap:4px;margin-left:auto;}
.wp-nav-btn{padding:5px 10px;border:1px solid #e2e8f0;background:#fff;border-radius:5px;font-size:11px;cursor:pointer;color:#475569;font-weight:500;font-family:inherit;transition:all .15s;}
.wp-nav-btn:hover{background:#f1f5f9;border-color:#cbd5e1;}
.wp-nav-btn.today{background:#003e6f;color:#fff;border-color:#003e6f;}
.wp-nav-btn.today:hover{background:#002a4f;}
.wp-week-label{font-size:12px;font-weight:500;color:#334155;min-width:120px;text-align:center;}
.wp-add-btn{padding:6px 12px;background:#003e6f;color:#fff;border:none;border-radius:5px;font-size:12px;cursor:pointer;font-weight:500;font-family:inherit;}
.wp-add-btn:hover{background:#002a4f;}
.wp-filter{padding:5px 8px;border:1px solid #cbd5e1;border-radius:5px;font-size:11px;background:#fff;font-family:inherit;cursor:pointer;}

/* Compact Calendar Grid */
.wp-calendar{flex:1;display:flex;flex-direction:column;overflow:hidden;}
.wp-days-header{display:grid;grid-template-columns:40px repeat(7,1fr);background:#fff;border-bottom:1px solid #e2e8f0;position:sticky;top:0;z-index:10;}
.wp-day-label{padding:6px 4px;text-align:center;border-left:1px solid #e2e8f0;font-size:10px;color:#64748b;font-weight:500;text-transform:uppercase;}
.wp-day-label .day-num{font-size:14px;font-weight:700;color:#0f172a;display:block;line-height:1.2;}
.wp-day-label.today{background:#eff6ff;}
.wp-day-label.today .day-num{color:#003e6f;background:#dbeafe;width:24px;height:24px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin:2px auto;}
.wp-corner{padding:6px 4px;background:#fff;display:flex;align-items:flex-end;justify-content:center;font-size:8px;color:#94a3b8;text-transform:uppercase;}

.wp-grid-scroll{flex:1;overflow-y:auto;overflow-x:hidden;position:relative;}
.wp-grid{display:grid;grid-template-columns:40px repeat(7,1fr);position:relative;}
.wp-time-label{padding:0 4px;height:32px;display:flex;align-items:flex-start;justify-content:flex-end;font-size:9px;color:#94a3b8;font-weight:400;padding-top:1px;border-right:1px solid #e2e8f0;background:#fff;position:sticky;left:0;z-index:2;}
.wp-cell{height:32px;border-bottom:1px solid #f1f5f9;border-left:1px solid #e2e8f0;position:relative;cursor:pointer;transition:background .1s;}
.wp-cell:hover{background:#f8fafc;}
.wp-cell.today{background:#fafbff;}

/* Current time indicator */
.wp-now-line{position:absolute;left:40px;right:0;height:2px;background:#dc2626;z-index:5;pointer-events:none;}
.wp-now-line::before{content:'';position:absolute;left:-5px;top:-4px;width:8px;height:8px;border-radius:50%;background:#dc2626;}

/* Task Block */
.wp-task{position:absolute;left:2px;right:2px;border-radius:4px;padding:3px 6px;font-size:10px;cursor:pointer;z-index:3;overflow:hidden;border-left:3px solid;transition:box-shadow .15s,transform .15s;min-height:16px;}
.wp-task:hover{box-shadow:0 1px 4px rgba(0,0,0,.10);transform:scale(1.01);z-index:6;}
.wp-task-title{font-weight:500;color:#fff;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.wp-task-time{font-size:8px;color:rgba(255,255,255,.8);margin-top:1px;}
.wp-task-assignee{position:absolute;right:2px;top:2px;width:14px;height:14px;border-radius:50%;background:rgba(255,255,255,.3);display:flex;align-items:center;justify-content:center;font-size:7px;font-weight:700;color:#fff;}
.wp-task.done{opacity:.5;}
.wp-task.done .wp-task-title{text-decoration:line-through;}

/* Priority colors */
.wp-task.priority-urgent{background:#dc2626;border-left-color:#991b1b;}
.wp-task.priority-high{background:#f59e0b;border-left-color:#b45309;}
.wp-task.priority-medium{background:#3b82f6;border-left-color:#1d4ed8;}
.wp-task.priority-low{background:#6b7280;border-left-color:#374151;}

/* Detail Panel */
.detail-overlay{position:fixed;inset:0;background:rgba(15,23,42,.4);z-index:1000;display:none;justify-content:flex-end;}
.detail-overlay.open{display:flex;}
.detail-panel{width:520px;max-width:100%;background:#fff;height:100%;overflow-y:auto;box-shadow:-4px 0 20px rgba(0,0,0,.1);display:flex;flex-direction:column;}
.detail-header{padding:20px 24px;border-bottom:1px solid #e2e8f0;display:flex;align-items:flex-start;justify-content:space-between;gap:12px;}
.detail-close{background:none;border:none;cursor:pointer;color:#94a3b8;font-size:20px;padding:4px;}
.detail-close:hover{color:#475569;}
.detail-body{flex:1;padding:20px 24px;overflow-y:auto;}
.detail-section{margin-bottom:24px;}
.detail-section-title{font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;}
.detail-meta{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:20px;}
.detail-meta-item label{font-size:11px;color:#94a3b8;display:block;margin-bottom:3px;}
.detail-meta-item select,.detail-meta-item input{padding:6px 8px;border:1px solid #e2e8f0;border-radius:4px;width:100%;font-family:inherit;font-size:12px;background:#fff;color:#0f172a;}
.d-btn{padding:6px 12px;border:none;border-radius:5px;font-size:12px;cursor:pointer;font-weight:500;font-family:inherit;transition:all .15s;}
.d-btn-primary{background:#003e6f;color:#fff;}
.d-btn-primary:hover{background:#002a4f;}
.d-btn-danger{background:#dc2626;color:#fff;}
.d-btn-danger:hover{background:#b91c1c;}
.d-btn-ghost{background:transparent;color:#64748b;border:1px solid #e2e8f0;}
.d-btn-ghost:hover{background:#f1f5f9;}
.d-btn-sm{padding:4px 8px;font-size:11px;}

/* Checklist */
.ck-item{display:flex;align-items:center;gap:8px;padding:5px 0;border-bottom:1px solid #f1f5f9;}
.ck-item input[type=checkbox]{width:15px;height:15px;cursor:pointer;accent-color:#003e6f;}
.ck-item span{flex:1;font-size:12px;color:#334155;}
.ck-item span.done{text-decoration:line-through;color:#94a3b8;}
.ck-item .del{background:none;border:none;color:#cbd5e1;cursor:pointer;font-size:13px;}.ck-item .del:hover{color:#dc2626;}
.ck-add{display:flex;gap:5px;margin-top:6px;}
.ck-add input{flex:1;padding:5px 8px;border:1px solid #e2e8f0;border-radius:4px;font-size:12px;font-family:inherit;}

/* Comments */
.cm-item{display:flex;gap:8px;padding:8px 0;border-bottom:1px solid #f1f5f9;}
.cm-avatar{width:26px;height:26px;border-radius:50%;background:#e2e8f0;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#475569;flex-shrink:0;}
.cm-body{flex:1;min-width:0;}
.cm-name{font-size:11px;font-weight:600;color:#0f172a;}
.cm-time{font-size:9px;color:#94a3b8;margin-left:4px;}
.cm-text{font-size:12px;color:#334155;margin-top:2px;line-height:1.4;}
.cm-add{display:flex;gap:5px;margin-top:8px;}
.cm-add textarea{flex:1;padding:6px 8px;border:1px solid #e2e8f0;border-radius:5px;font-size:12px;font-family:inherit;resize:vertical;min-height:34px;}

/* Attachments */
.at-item{display:flex;align-items:center;gap:6px;padding:6px 8px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:5px;margin-bottom:4px;font-size:11px;}
.at-name{flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#334155;font-weight:500;}

/* Modal */
.modal-overlay{position:fixed;inset:0;background:rgba(15,23,42,.5);z-index:1100;display:none;align-items:center;justify-content:center;}
.modal-overlay.open{display:flex;}
.modal-box{background:#fff;border-radius:10px;padding:24px;width:460px;max-width:95%;max-height:90vh;overflow-y:auto;box-shadow:0 10px 40px rgba(0,0,0,.15);}
.modal-title{font-size:17px;font-weight:700;color:#0f172a;margin-bottom:18px;}
.fg{margin-bottom:12px;}
.fg label{display:block;font-size:11px;color:#475569;margin-bottom:4px;font-weight:500;}
.fg input,.fg select,.fg textarea{width:100%;padding:8px 10px;border:1px solid #cbd5e1;border-radius:6px;font-size:13px;font-family:inherit;color:#0f172a;background:#fff;}
.fg textarea{resize:vertical;min-height:60px;}
.fg-row{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
.fg-row3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;}
.form-actions{display:flex;gap:8px;justify-content:flex-end;margin-top:18px;}

/* Footer */
.wp-footer{background:#fff;border-top:1px solid #e2e8f0;padding:10px 24px;display:flex;align-items:center;gap:20px;font-size:12px;color:#64748b;}
.wp-stat{display:flex;align-items:center;gap:4px;}
.wp-stat b{color:#0f172a;}
.wp-stat.done b{color:#16a34a;}
.wp-stat.overdue b{color:#dc2626;}

/* Status badge */
.status-dot{width:8px;height:8px;border-radius:50%;display:inline-block;margin-right:4px;}
.status-dot.todo{background:#94a3b8;}
.status-dot.in_progress{background:#f59e0b;}
.status-dot.done{background:#22c55e;}

@media(max-width:768px){
  .wp-header{flex-direction:column;align-items:stretch;gap:8px;}
  .wp-nav{margin-left:0;flex-wrap:wrap;}
  .wp-calendar{overflow-x:auto;}
  .wp-days-header,.wp-grid{grid-template-columns:50px repeat(7,minmax(120px,1fr));}
  .detail-panel{width:100%;}
  .modal-box{width:95%;padding:18px;}
}
</style>
</head>
<body style="margin:0;">
<div style="display:flex;min-height:100vh;background:#f7fafc;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial;">
@include('layouts.sidebar')
<div class="main" style="flex:1;display:flex;flex-direction:column;min-width:0;">
  <div style="display:flex;justify-content:center;align-items:flex-start;padding:32px 0 0 0;width:100%;min-height:0;">
    <div class="wp-card-calendar" style="background:#fff;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,0.08);padding:18px 18px 12px 18px;max-width:1100px;width:100%;">
      {{-- HEADER --}}
      <div class="wp-header">
        <span class="wp-title">Weekly Planner</span>
        <select class="wp-filter" id="filterPriority" onchange="applyFilters()">
          <option value="">Semua Prioritas</option>
          <option value="low">Low</option>
          <option value="medium">Medium</option>
          <option value="high">High</option>
          <option value="urgent">Urgent</option>
        </select>
        <select class="wp-filter" id="filterAssignee" onchange="applyFilters()">
          <option value="">Semua Assignee</option>
          @foreach($users as $u)
            <option value="{{ $u->id }}">{{ $u->name }}</option>
          @endforeach
        </select>
        <div class="wp-nav">
          <button class="wp-nav-btn" onclick="navWeek(-1)">← Sebelumnya</button>
          <button class="wp-nav-btn today" onclick="navWeek(0)">Hari Ini</button>
          <button class="wp-nav-btn" onclick="navWeek(1)">Selanjutnya →</button>
        </div>
        <span class="wp-week-label" id="weekLabel">{{ $weekStart->translatedFormat('d M') }} – {{ $weekEnd->translatedFormat('d M Y') }}</span>
        <button class="wp-add-btn" onclick="openAddModal()">＋ Tambah Task</button>
      </div>

      {{-- CALENDAR --}}
      <div class="wp-calendar">
        {{-- Day headers --}}
        <div class="wp-days-header">
          <div class="wp-corner">Waktu</div>
          @php
            $days = ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
            $todayStr = now()->format('Y-m-d');
          @endphp
          @for($i = 0; $i < 7; $i++)
            @php $d = $weekStart->copy()->addDays($i); $isToday = $d->format('Y-m-d') === $todayStr; @endphp
            <div class="wp-day-label {{ $isToday ? 'today' : '' }}" data-date="{{ $d->format('Y-m-d') }}">
              {{ $days[$i] }}
              <span class="day-num">{{ $d->format('d') }}</span>
              {{ $d->translatedFormat('M') }}
            </div>
          @endfor
        </div>

        {{-- Time grid --}}
        <div class="wp-grid-scroll" id="gridScroll">
          <div class="wp-grid" id="calendarGrid">
            @for($h = 6; $h <= 23; $h++)
              <div class="wp-time-label">{{ sprintf('%02d:00', $h) }}</div>
              @for($i = 0; $i < 7; $i++)
                @php $d = $weekStart->copy()->addDays($i); $isToday = $d->format('Y-m-d') === $todayStr; @endphp
                <div class="wp-cell {{ $isToday ? 'today' : '' }}" data-date="{{ $d->format('Y-m-d') }}" data-hour="{{ $h }}" onclick="clickCell('{{ $d->format('Y-m-d') }}', {{ $h }})"></div>
              @endfor
            @endfor
          </div>
          {{-- Now line --}}
          <div class="wp-now-line" id="nowLine" style="display:none;"></div>

          {{-- Task blocks will be rendered by JS --}}
          <div id="taskBlocksContainer" style="position:absolute;top:0;left:0;right:0;bottom:0;pointer-events:none;">
          </div>
        </div>
      </div>

      {{-- FOOTER --}}
      <div class="wp-footer">
        <div class="wp-stat">📊 Minggu Ini: <b>{{ $totalWeek }}</b></div>
        <div class="wp-stat done">✅ Selesai: <b>{{ $totalDone }}</b></div>
        <div class="wp-stat overdue">⚠️ Overdue: <b>{{ $totalOverdue }}</b></div>
        <div class="wp-stat">📌 Hari Ini: <b>{{ $totalToday }}</b></div>
      </div>
    </div>
  </div>
</div>
</div>

{{-- ADD MODAL --}}
<div class="modal-overlay" id="addModal">
  <div class="modal-box">
    <div class="modal-title" id="modalTitle">Tambah Task</div>
    <form id="taskForm" onsubmit="submitTask(event)">
      <input type="hidden" id="editTaskId" value="">
      <div class="fg">
        <label>Judul Task *</label>
        <input type="text" id="fTitle" required placeholder="Judul task...">
      </div>
      <div class="fg-row">
        <div class="fg">
          <label>Tanggal *</label>
          <input type="date" id="fDate" required>
        </div>
        <div class="fg">
          <label>Prioritas *</label>
          <select id="fPriority" required>
            <option value="low">Low</option>
            <option value="medium" selected>Medium</option>
            <option value="high">High</option>
            <option value="urgent">Urgent</option>
          </select>
        </div>
      </div>
      <div class="fg-row">
        <div class="fg">
          <label>Jam Mulai *</label>
          <input type="time" id="fStartTime" required value="09:00">
        </div>
        <div class="fg">
          <label>Jam Selesai *</label>
          <input type="time" id="fEndTime" required value="10:00">
        </div>
      </div>
      <div class="fg-row">
        <div class="fg">
          <label>Assignee</label>
          <select id="fAssignee">
            <option value="">-- Belum ditentukan --</option>
            @foreach($users as $u)
              <option value="{{ $u->id }}">{{ $u->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="fg">
          <label>Status</label>
          <select id="fStatus">
            <option value="todo">To Do</option>
            <option value="in_progress">In Progress</option>
            <option value="done">Done</option>
          </select>
        </div>
      </div>
      <div class="fg">
        <label>Deskripsi</label>
        <textarea id="fDesc" placeholder="Deskripsi opsional..."></textarea>
      </div>
      <div class="form-actions">
        <button type="button" class="d-btn d-btn-ghost" onclick="closeAddModal()">Batal</button>
        <button type="submit" class="d-btn d-btn-primary" id="modalSubmitBtn">Simpan</button>
      </div>
    </form>
  </div>
</div>

{{-- DETAIL PANEL --}}
<div class="detail-overlay" id="detailOverlay" onclick="if(event.target===this)closeDetail()">
  <div class="detail-panel">
    <div class="detail-header">
      <div style="flex:1;min-width:0;">
        <h2 style="margin:0;font-size:17px;color:#0f172a;" id="detailTitle"></h2>
        <div style="font-size:11px;color:#94a3b8;margin-top:3px;" id="detailCreator"></div>
      </div>
      <div style="display:flex;gap:5px;align-items:center;">
        <button class="d-btn d-btn-sm d-btn-ghost" onclick="editFromDetail()">✏️</button>
        <button class="d-btn d-btn-sm d-btn-danger" onclick="deleteFromDetail()">🗑️</button>
        <button class="detail-close" onclick="closeDetail()">✕</button>
      </div>
    </div>
    <div class="detail-body">
      <div class="detail-meta">
        <div class="detail-meta-item">
          <label>Status</label>
          <select id="detailStatus" onchange="updateField('status',this.value)">
            <option value="todo">To Do</option>
            <option value="in_progress">In Progress</option>
            <option value="done">Done</option>
          </select>
        </div>
        <div class="detail-meta-item">
          <label>Prioritas</label>
          <select id="detailPriority" onchange="updateField('priority',this.value)">
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
            <option value="urgent">Urgent</option>
          </select>
        </div>
        <div class="detail-meta-item">
          <label>Tanggal</label>
          <input type="date" id="detailDate" onchange="updateField('task_date',this.value)">
        </div>
        <div class="detail-meta-item">
          <label>Assignee</label>
          <select id="detailAssignee" onchange="updateField('assigned_to',this.value)">
            <option value="">Belum ditentukan</option>
            @foreach($users as $u)
              <option value="{{ $u->id }}">{{ $u->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="detail-meta-item">
          <label>Jam Mulai</label>
          <input type="time" id="detailStart" onchange="updateField('start_time',this.value)">
        </div>
        <div class="detail-meta-item">
          <label>Jam Selesai</label>
          <input type="time" id="detailEnd" onchange="updateField('end_time',this.value)">
        </div>
      </div>

      <div class="detail-section">
        <div class="detail-section-title">📄 Deskripsi</div>
        <div id="detailDesc" style="font-size:12px;color:#475569;line-height:1.5;white-space:pre-wrap;"></div>
      </div>

      <div class="detail-section">
        <div class="detail-section-title">☑️ Subtask <span id="ckProgress" style="font-size:11px;color:#64748b;font-weight:400;"></span></div>
        <div id="ckContainer"></div>
        <div class="ck-add">
          <input type="text" id="ckInput" placeholder="Tambah subtask..." onkeydown="if(event.key==='Enter'){event.preventDefault();addChecklist();}">
          <button class="d-btn d-btn-sm d-btn-primary" onclick="addChecklist()">＋</button>
        </div>
      </div>

      <div class="detail-section">
        <div class="detail-section-title">📎 Lampiran</div>
        <div id="atContainer"></div>
        <div style="margin-top:6px;">
          <input type="file" id="atInput" style="display:none;" onchange="uploadAttachment()">
          <button class="d-btn d-btn-sm d-btn-ghost" onclick="document.getElementById('atInput').click()">📁 Upload</button>
        </div>
      </div>

      <div class="detail-section">
        <div class="detail-section-title">💬 Komentar</div>
        <div id="cmContainer"></div>
        <div class="cm-add">
          <textarea id="cmInput" placeholder="Tulis komentar..." rows="2"></textarea>
          <button class="d-btn d-btn-sm d-btn-primary" style="align-self:flex-end;" onclick="addComment()">Kirim</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const BASE = '{{ url("hrissdi") }}';
const STORAGE = '{{ asset("storage") }}';
const CSRF = document.querySelector('meta[name=csrf-token]').content;
let currentTaskId = null;

// Week data
const weekStartStr = '{{ $weekStart->format("Y-m-d") }}';
const weekStart = new Date(weekStartStr + 'T00:00:00');

// All tasks from server
let tasksData = @json($tasksByDate);

// ============ RENDER TASKS ON CALENDAR ============
function renderTasks() {
  const container = document.getElementById('taskBlocksContainer');
  container.innerHTML = '';
  const grid = document.getElementById('calendarGrid');
  const gridRect = grid.getBoundingClientRect();
  const scrollEl = document.getElementById('gridScroll');

  const filterP = document.getElementById('filterPriority').value;
  const filterA = document.getElementById('filterAssignee').value;

  // Get column positions from cells
  const firstRow = grid.querySelectorAll('.wp-cell');
  const colPositions = [];
  for (let i = 0; i < 7; i++) {
    const cell = firstRow[i];
    if (cell) {
      const r = cell.getBoundingClientRect();
      colPositions.push({ left: r.left - gridRect.left, width: r.width });
    }
  }

  const hourHeight = 32; // each hour = 32px (match .wp-time-label and .wp-cell)
  const startHour = 6;

  Object.keys(tasksData).forEach(date => {
    const dayIndex = Math.round((new Date(date + 'T00:00:00') - weekStart) / 86400000);
    if (dayIndex < 0 || dayIndex > 6 || !colPositions[dayIndex]) return;

    tasksData[date].forEach(task => {
      // Apply filters
      if (filterP && task.priority !== filterP) return;
      if (filterA && String(task.assigned_to) !== filterA) return;

      if (!task.start_time || !task.end_time) return;

      const [sh, sm] = task.start_time.split(':').map(Number);
      const [eh, em] = task.end_time.split(':').map(Number);

      const topOffset = (sh - startHour + sm / 60) * hourHeight;
      const height = Math.max(((eh - sh) + (em - sm) / 60) * hourHeight, 16);

      const col = colPositions[dayIndex];

      const el = document.createElement('div');
      el.className = `wp-task priority-${task.priority} ${task.status === 'done' ? 'done' : ''}`;
      el.style.cssText = `position:absolute;top:${topOffset}px;left:${col.left + 3}px;width:${col.width - 6}px;height:${height}px;pointer-events:auto;`;
      el.onclick = () => openDetail(task.id);

      let inner = `<div class="wp-task-title">${esc(task.title)}</div>`;
      if (height > 30) {
        inner += `<div class="wp-task-time">${task.start_time.substring(0,5)} - ${task.end_time.substring(0,5)}</div>`;
      }
      if (task.assignee_initial) {
        inner += `<div class="wp-task-assignee">${task.assignee_initial}</div>`;
      }
      el.innerHTML = inner;

      container.appendChild(el);
    });
  });
}

// ============ NOW LINE ============
function updateNowLine() {
  const now = new Date();
  const todayStr = now.toISOString().substring(0, 10);
  const dayIndex = Math.round((new Date(todayStr + 'T00:00:00') - weekStart) / 86400000);

  const line = document.getElementById('nowLine');
  if (dayIndex < 0 || dayIndex > 6) { line.style.display = 'none'; return; }

  const hour = now.getHours();
  const min = now.getMinutes();
  if (hour < 6 || hour > 23) { line.style.display = 'none'; return; }

  const topOffset = (hour - 6 + min / 60) * 60;
    // Cell height is 32px per hour
    const cellHeight = 32;
    const offset = (hour - 6 + min / 60) * cellHeight;
    line.style.display = 'block';
    line.style.top = offset + 'px';
}

// ============ NAVIGATION ============
function localDateStr(d) {
  const y = d.getFullYear();
  const m = String(d.getMonth() + 1).padStart(2, '0');
  const day = String(d.getDate()).padStart(2, '0');
  return y + '-' + m + '-' + day;
}

function navWeek(dir) {
  const ws = new Date(weekStartStr + 'T00:00:00');
  if (dir === 0) {
    const now = new Date();
    const dow = now.getDay();
    const mon = new Date(now);
    mon.setDate(now.getDate() - (dow === 0 ? 6 : dow - 1));
    location.href = BASE + '/tasks?week=' + localDateStr(mon);
  } else {
    ws.setDate(ws.getDate() + dir * 7);
    location.href = BASE + '/tasks?week=' + localDateStr(ws);
  }
}

// ============ FILTERS ============
function applyFilters() { renderTasks(); }

// ============ CLICK CELL ============
function clickCell(date, hour) {
  document.getElementById('editTaskId').value = '';
  document.getElementById('modalTitle').textContent = 'Tambah Task';
  document.getElementById('modalSubmitBtn').textContent = 'Simpan';
  document.getElementById('fTitle').value = '';
  document.getElementById('fDesc').value = '';
  document.getElementById('fPriority').value = 'medium';
  document.getElementById('fDate').value = date;
  document.getElementById('fStartTime').value = String(hour).padStart(2, '0') + ':00';
  document.getElementById('fEndTime').value = String(hour + 1).padStart(2, '0') + ':00';
  document.getElementById('fAssignee').value = '';
  document.getElementById('fStatus').value = 'todo';
  document.getElementById('addModal').classList.add('open');
}

// ============ ADD/EDIT MODAL ============
function openAddModal() {
  document.getElementById('editTaskId').value = '';
  document.getElementById('modalTitle').textContent = 'Tambah Task';
  document.getElementById('modalSubmitBtn').textContent = 'Simpan';
  document.getElementById('fTitle').value = '';
  document.getElementById('fDesc').value = '';
  document.getElementById('fPriority').value = 'medium';
  document.getElementById('fDate').value = new Date().toISOString().substring(0, 10);
  document.getElementById('fStartTime').value = '09:00';
  document.getElementById('fEndTime').value = '10:00';
  document.getElementById('fAssignee').value = '';
  document.getElementById('fStatus').value = 'todo';
  document.getElementById('addModal').classList.add('open');
}

function openEditModal(task) {
  document.getElementById('editTaskId').value = task.id;
  document.getElementById('modalTitle').textContent = 'Edit Task';
  document.getElementById('modalSubmitBtn').textContent = 'Update';
  document.getElementById('fTitle').value = task.title;
  document.getElementById('fDesc').value = task.description || '';
  document.getElementById('fPriority').value = task.priority;
  document.getElementById('fDate').value = task.task_date ? task.task_date.substring(0, 10) : '';
  document.getElementById('fStartTime').value = task.start_time ? task.start_time.substring(0, 5) : '09:00';
  document.getElementById('fEndTime').value = task.end_time ? task.end_time.substring(0, 5) : '10:00';
  document.getElementById('fAssignee').value = task.assigned_to || '';
  document.getElementById('fStatus').value = task.status;
  document.getElementById('addModal').classList.add('open');
}

function closeAddModal() { document.getElementById('addModal').classList.remove('open'); }

function submitTask(e) {
  e.preventDefault();
  const id = document.getElementById('editTaskId').value;
  const data = {
    title: document.getElementById('fTitle').value,
    description: document.getElementById('fDesc').value || null,
    priority: document.getElementById('fPriority').value,
    task_date: document.getElementById('fDate').value,
    start_time: document.getElementById('fStartTime').value,
    end_time: document.getElementById('fEndTime').value,
    assigned_to: document.getElementById('fAssignee').value || null,
    status: document.getElementById('fStatus').value,
  };

  const url = id ? BASE + '/tasks/' + id : BASE + '/tasks';
  const method = id ? 'PUT' : 'POST';

  fetch(url, {
    method,
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
    body: JSON.stringify(data)
  })
  .then(r => r.json())
  .then(res => {
    if (res.success) { closeAddModal(); location.reload(); }
    else { alert('Gagal menyimpan. Periksa input.'); }
  })
  .catch(() => alert('Terjadi kesalahan.'));
}

// ============ DETAIL ============
function openDetail(taskId) {
  currentTaskId = taskId;
  fetch(BASE + '/tasks/' + taskId)
    .then(r => r.json())
    .then(task => {
      document.getElementById('detailTitle').textContent = task.title;
      document.getElementById('detailCreator').textContent = 'Dibuat oleh ' + (task.creator ? task.creator.name : '-') + ' • ' + fmtDate(task.created_at);
      document.getElementById('detailStatus').value = task.status;
      document.getElementById('detailPriority').value = task.priority;
      document.getElementById('detailAssignee').value = task.assigned_to || '';
      document.getElementById('detailDate').value = task.task_date ? task.task_date.substring(0, 10) : '';
      document.getElementById('detailStart').value = task.start_time ? task.start_time.substring(0, 5) : '';
      document.getElementById('detailEnd').value = task.end_time ? task.end_time.substring(0, 5) : '';
      document.getElementById('detailDesc').textContent = task.description || 'Tidak ada deskripsi.';

      renderChecklists(task.checklists || []);
      renderComments(task.comments || []);
      renderAttachments(task.attachments || []);

      document.getElementById('detailOverlay').classList.add('open');
    });
}

function closeDetail() { document.getElementById('detailOverlay').classList.remove('open'); currentTaskId = null; }

function updateField(field, value) {
  if (!currentTaskId) return;
  const data = {}; data[field] = value || null;
  fetch(BASE + '/tasks/' + currentTaskId, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
    body: JSON.stringify(data)
  }).then(r => r.json()).then(res => { if (res.success) location.reload(); });
}

function editFromDetail() {
  fetch(BASE + '/tasks/' + currentTaskId).then(r => r.json()).then(task => { closeDetail(); openEditModal(task); });
}

function deleteFromDetail() {
  if (!confirm('Yakin hapus task ini?')) return;
  fetch(BASE + '/tasks/' + currentTaskId, {
    method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF }
  }).then(r => r.json()).then(res => { if (res.success) { closeDetail(); location.reload(); } });
}

// ============ CHECKLISTS ============
function renderChecklists(items) {
  const c = document.getElementById('ckContainer');
  const done = items.filter(i => i.is_completed).length;
  document.getElementById('ckProgress').textContent = items.length ? `(${done}/${items.length})` : '';
  c.innerHTML = items.map(i => `
    <div class="ck-item">
      <input type="checkbox" ${i.is_completed ? 'checked' : ''} onchange="toggleCk(${i.id})">
      <span class="${i.is_completed ? 'done' : ''}">${esc(i.title)}</span>
      <button class="del" onclick="delCk(${i.id})">✕</button>
    </div>
  `).join('');
}
function addChecklist() {
  const inp = document.getElementById('ckInput');
  if (!inp.value.trim()) return;
  fetch(BASE + '/tasks/' + currentTaskId + '/checklists', {
    method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
    body: JSON.stringify({ title: inp.value.trim() })
  }).then(r => r.json()).then(res => { if (res.success) { inp.value = ''; openDetail(currentTaskId); } });
}
function toggleCk(id) {
  fetch(BASE + '/checklists/' + id + '/toggle', { method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF } })
    .then(r => r.json()).then(res => { if (res.success) openDetail(currentTaskId); });
}
function delCk(id) {
  fetch(BASE + '/checklists/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF } })
    .then(r => r.json()).then(res => { if (res.success) openDetail(currentTaskId); });
}

// ============ COMMENTS ============
function renderComments(items) {
  const c = document.getElementById('cmContainer');
  c.innerHTML = items.map(i => `
    <div class="cm-item">
      <div class="cm-avatar">${i.user ? i.user.name.charAt(0).toUpperCase() : '?'}</div>
      <div class="cm-body">
        <span class="cm-name">${esc(i.user ? i.user.name : 'Unknown')}</span>
        <span class="cm-time">${timeAgo(i.created_at)}</span>
        <div class="cm-text">${esc(i.content)}</div>
      </div>
    </div>
  `).join('') || '<div style="font-size:11px;color:#94a3b8;">Belum ada komentar.</div>';
}
function addComment() {
  const inp = document.getElementById('cmInput');
  if (!inp.value.trim()) return;
  fetch(BASE + '/tasks/' + currentTaskId + '/comments', {
    method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
    body: JSON.stringify({ content: inp.value.trim() })
  }).then(r => r.json()).then(res => { if (res.success) { inp.value = ''; openDetail(currentTaskId); } });
}

// ============ ATTACHMENTS ============
function renderAttachments(items) {
  const c = document.getElementById('atContainer');
  c.innerHTML = items.map(a => `
    <div class="at-item">
      <span>${fileIcon(a.file_type)}</span>
      <span class="at-name">${esc(a.file_name)}</span>
      <a href="${STORAGE}/${a.file_path}" target="_blank" class="d-btn d-btn-sm d-btn-ghost">📥</a>
      <button class="d-btn d-btn-sm d-btn-danger" style="padding:2px 5px;" onclick="delAt(${a.id})">✕</button>
    </div>
  `).join('') || '<div style="font-size:11px;color:#94a3b8;">Belum ada lampiran.</div>';
}
function uploadAttachment() {
  const inp = document.getElementById('atInput');
  if (!inp.files.length) return;
  const fd = new FormData(); fd.append('file', inp.files[0]);
  fetch(BASE + '/tasks/' + currentTaskId + '/attachments', {
    method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF }, body: fd
  }).then(r => r.json()).then(res => { if (res.success) { inp.value = ''; openDetail(currentTaskId); } });
}
function delAt(id) {
  if (!confirm('Hapus lampiran?')) return;
  fetch(BASE + '/attachments/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF } })
    .then(r => r.json()).then(res => { if (res.success) openDetail(currentTaskId); });
}

// ============ HELPERS ============
function esc(s) { const d = document.createElement('div'); d.textContent = s; return d.innerHTML; }
function fmtDate(d) { if (!d) return '-'; return new Date(d).toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' }); }
function timeAgo(d) {
  if (!d) return '';
  const diff = (Date.now() - new Date(d).getTime()) / 1000;
  if (diff < 60) return 'baru saja';
  if (diff < 3600) return Math.floor(diff / 60) + 'm lalu';
  if (diff < 86400) return Math.floor(diff / 3600) + 'j lalu';
  return Math.floor(diff / 86400) + 'h lalu';
}
function fileIcon(t) {
  if (!t) return '📄';
  if (t.includes('image')) return '🖼️';
  if (t.includes('pdf')) return '📕';
  if (t.includes('word') || t.includes('document')) return '📘';
  if (t.includes('sheet') || t.includes('excel')) return '📗';
  return '📄';
}

// ============ INIT ============
document.addEventListener('DOMContentLoaded', function() {
  renderTasks();
  updateNowLine();
  setInterval(updateNowLine, 10000); // update every 10 seconds

  // Scroll to 8am by default
  const scroll = document.getElementById('gridScroll');
  scroll.scrollTop = (8 - 6) * 32; // adjust for new cell height

  // Re-render on resize and scroll
  window.addEventListener('resize', () => { renderTasks(); updateNowLine(); });
  scroll.addEventListener('scroll', updateNowLine);
});
</script>
</body>
</html>
