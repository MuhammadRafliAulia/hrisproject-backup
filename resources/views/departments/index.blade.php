<div style="display:flex;min-height:100vh;background:#f7fafc;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial;">
    @include('layouts.sidebar')
    <div style="flex:1;display:flex;flex-direction:column;">
        <div style="background:#fff;border-bottom:1px solid #e2e8f0;padding:16px 24px;display:flex;align-items:center;gap:16px;">
            <button onclick="window.history.back()" style="background:#e2e8f0;border:none;color:#334155;padding:6px 16px;border-radius:6px;font-size:14px;cursor:pointer;display:inline-block;">← Back</button>
            <h1 style="margin:0;font-size:20px;color:#0f172a;">Master Departemen</h1>
        </div>
        <div style="flex:1;padding:24px;overflow-y:auto;">
            <div style="background:#fff;border:1px solid #e2e8f0;padding:24px;border-radius:8px;max-width:600px;">
                <a href="{{ route('departments.create') }}" style="background:#003e6f;color:#fff;border:none;padding:10px 12px;border-radius:6px;font-size:14px;cursor:pointer;margin-bottom:16px;display:inline-block;text-decoration:none;">Tambah Departemen</a>
                @if(session('success'))
                    <div style="background:#d1fae5;color:#065f46;padding:12px;border-radius:6px;margin-bottom:16px;font-size:13px;">{{ session('success') }}</div>
                @endif
                <table style="width:100%;border-collapse:collapse;margin-top:16px;">
                    <thead>
                        <tr>
                            <th style="background:#f1f5f9;color:#334155;font-weight:600;padding:12px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px;">Nama Departemen</th>
                            <th style="background:#f1f5f9;color:#334155;font-weight:600;padding:12px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departments as $department)
                        <tr>
                            <td style="padding:12px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px;">{{ $department->name }}</td>
                            <td style="padding:12px;text-align:left;border-bottom:1px solid #e2e8f0;font-size:14px;">
                                <a href="{{ route('departments.edit', $department) }}" style="background:#f59e42;color:#fff;border:none;padding:10px 12px;border-radius:6px;font-size:14px;cursor:pointer;text-decoration:none;">Edit</a>
                                <form action="{{ route('departments.destroy', $department) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:#dc2626;color:#fff;border:none;padding:10px 12px;border-radius:6px;font-size:14px;cursor:pointer;" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
