<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Master User - HRIS</title>
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>
<body style="margin:0;">
<div style="display:flex;min-height:100vh;background:#f7fafc;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial;">
    @include('layouts.sidebar')
    <div class="main" style="flex:1;display:flex;flex-direction:column;">
        <div class="topbar" style="background:#fff;border-bottom:1px solid #e2e8f0;padding:16px 24px;display:flex;align-items:center;gap:16px;">
            <button onclick="window.history.back()" style="background:#e2e8f0;border:none;color:#334155;padding:6px 16px;border-radius:6px;font-size:14px;cursor:pointer;display:inline-block;">← Back</button>
            <h1 style="margin:0;font-size:20px;color:#0f172a;">Master User</h1>
        </div>
        <div style="flex:1;padding:24px;overflow-y:auto;">
            <div style="background:#fff;border:1px solid #e2e8f0;padding:24px;border-radius:8px;">
                <a href="{{ route('users.create') }}" style="background:#003e6f;color:#fff;border:none;padding:10px 12px;border-radius:6px;font-size:14px;cursor:pointer;margin-bottom:16px;display:inline-block;text-decoration:none;">Tambah User</a>
                @if(session('success'))
                    <div style="background:#d1fae5;color:#065f46;padding:12px;border-radius:6px;margin-bottom:16px;font-size:13px;">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div style="background:#fef2f2;color:#dc2626;padding:12px;border-radius:6px;margin-bottom:16px;font-size:13px;">{{ session('error') }}</div>
                @endif
                <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;margin-top:16px;">
                    <thead>
                        <tr>
                            <th style="background:#f1f5f9;color:#334155;font-weight:600;padding:12px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px;">No</th>
                            <th style="background:#f1f5f9;color:#334155;font-weight:600;padding:12px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px;">Nama</th>
                            <th style="background:#f1f5f9;color:#334155;font-weight:600;padding:12px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px;">Email</th>
                            <th style="background:#f1f5f9;color:#334155;font-weight:600;padding:12px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px;">Role</th>
                            <th style="background:#f1f5f9;color:#334155;font-weight:600;padding:12px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <td style="padding:12px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px;">{{ $index + 1 }}</td>
                            <td style="padding:12px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px;">{{ $user->name }}</td>
                            <td style="padding:12px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px;">{{ $user->email }}</td>
                            <td style="padding:12px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px;">
                                @if($user->role === 'superadmin')
                                    <span style="background:#dbeafe;color:#1e40af;padding:3px 10px;border-radius:999px;font-size:12px;font-weight:500;">Super Admin</span>
                                @elseif($user->role === 'recruitmentteam')
                                    <span style="background:#fef3c7;color:#92400e;padding:3px 10px;border-radius:999px;font-size:12px;font-weight:500;">Recruitment Team</span>
                                @elseif($user->role === 'admin_prod')
                                    <span style="background:#e0e7ff;color:#3730a3;padding:3px 10px;border-radius:999px;font-size:12px;font-weight:500;">Admin Department</span>
                                @elseif($user->role === 'top_level_management')
                                    <span style="background:#fce7f3;color:#9d174d;padding:3px 10px;border-radius:999px;font-size:12px;font-weight:500;">Top Level Management</span>
                                @else
                                    <span style="background:#f1f5f9;color:#64748b;padding:3px 10px;border-radius:999px;font-size:12px;font-weight:500;">{{ $user->role }}</span>
                                @endif
                            </td>
                            <td style="padding:12px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px;">
                                <a href="{{ route('users.edit', $user) }}" style="background:#f59e42;color:#fff;border:none;padding:10px 12px;border-radius:6px;font-size:14px;cursor:pointer;text-decoration:none;">Edit</a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:#dc2626;color:#fff;border:none;padding:10px 12px;border-radius:6px;font-size:14px;cursor:pointer;" onclick="return confirm('Yakin hapus user ini?')">Hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
