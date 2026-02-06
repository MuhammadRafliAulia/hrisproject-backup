@props(['selected' => null])
@php($departments = \App\Models\Department::orderBy('name')->get())
<select name="dept" id="dept" {{ $attributes }}>
    <option value="">-- Pilih Departemen --</option>
    @foreach($departments as $department)
        <option value="{{ $department->name }}" {{ $selected == $department->name ? 'selected' : '' }}>{{ $department->name }}</option>
    @endforeach
</select>
