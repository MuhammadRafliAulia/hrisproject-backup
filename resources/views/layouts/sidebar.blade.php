<div class="sidebar" style="width:280px;background:#fff;border-right:1px solid #e2e8f0;padding:20px;box-sizing:border-box;overflow-y:auto;display:flex;flex-direction:column;min-height:100vh;">
  <div style="flex:1;display:flex;flex-direction:column;">
    <h2 style="font-size:16px;color:#0f172a;margin:0 0 16px 0;font-weight:600;">Menu</h2>
    <ul class="sidebar-menu" style="list-style:none;margin:0;padding:0;">
      <li style="margin-bottom:8px;"><a href="{{ route('dashboard') }}" style="display:block;padding:10px 12px;color:#334155;text-decoration:none;border-radius:6px;font-size:14px;">Dashboard</a></li>
      <li style="margin-bottom:8px;"><a href="{{ route('banks.index') }}" style="display:block;padding:10px 12px;color:#334155;text-decoration:none;border-radius:6px;font-size:14px;">📋 Psikotest Online</a></li>
      <li style="margin-bottom:8px;"><a href="{{ route('employees.index') }}" style="display:block;padding:10px 12px;color:#334155;text-decoration:none;border-radius:6px;font-size:14px;">👥 Database Karyawan</a></li>
    </ul>
    <div style="border-top:1px solid #e2e8f0;padding-top:16px;margin-top:16px;">
      <div style="font-size:15px;color:#64748b;font-weight:600;margin-bottom:8px;cursor:pointer;" onclick="document.getElementById('setting-dropdown').classList.toggle('show');">
        ⚙️ Setting <span style="float:right;">&#9660;</span>
      </div>
      <ul id="setting-dropdown" class="setting-dropdown" style="display:none;list-style:none;padding:0;margin:0;">
        <li><a href="{{ route('departments.index') }}" style="display:block;padding:10px 12px;color:#334155;text-decoration:none;border-radius:6px;font-size:14px;">🏢 Master Departemen</a></li>
      </ul>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var settingTitle = document.querySelector('.sidebar div[onclick]');
        var dropdown = document.getElementById('setting-dropdown');
        if(settingTitle && dropdown) {
          settingTitle.addEventListener('click', function() {
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
          });
        }
      });
    </script>
  </div>
  <div class="user-section" style="border-top:1px solid #e2e8f0; padding-top:16px; margin-top:16px;">
    <div class="user-name">👤 {{ auth()->user()->name }}</div>
    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
      @csrf
      <button type="submit" class="btn btn-danger btn-logout" style="width:100%;text-align:center;background:#003e6f;">Logout</button>
    </form>
  </div>
</div>
