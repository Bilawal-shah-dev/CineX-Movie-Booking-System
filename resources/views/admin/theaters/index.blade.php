@extends('layouts.admin')
@section('title','Theaters')
@section('page-title','Manage Theaters')

@section('content')
<div style="display:grid;grid-template-columns:1fr 360px;gap:1.5rem;align-items:start;">

    {{-- Theater list --}}
    <div class="table-wrap">
        <table class="cx-table">
            <thead><tr><th>Name</th><th>City</th><th>Seats</th><th>Shows</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($theaters as $t)
                <tr>
                    <td style="font-weight:600;">{{ $t->name }}</td>
                    <td>{{ $t->city }}</td>
                    <td>{{ $t->total_seats }}</td>
                    <td><span class="badge badge-gray">{{ $t->shows_count }}</span></td>
                    <td><span class="badge {{ $t->is_active?'badge-green':'badge-red' }}">{{ $t->is_active?'Active':'Inactive' }}</span></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="#" onclick="editTheater({{ $t->id }},'{{ addslashes($t->name) }}','{{ addslashes($t->city) }}','{{ addslashes($t->address) }}',{{ $t->total_seats }},'{{ addslashes($t->facilities) }}')" class="btn btn-outline btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.theaters.destroy',$t->id) }}" onsubmit="return confirm('Delete theater?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background:rgba(211,47,35,.12);border:1px solid rgba(211,47,35,.3);color:var(--red);">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Add / Edit Theater form --}}
    <div style="background:var(--surface-2);border:1px solid var(--border-1);border-radius:var(--radius-md);padding:1.25rem;position:sticky;top:80px;">
        <div style="font-size:14px;font-weight:700;margin-bottom:1rem;" id="formTitle">Add Theater</div>
        <form method="POST" id="theaterForm" action="{{ route('admin.theaters.store') }}">
            @csrf
            <span id="methodSpoof"></span>
            <div class="form-group">
                <label class="form-label">Theater Name *</label>
                <input type="text" name="name" id="t_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">City *</label>
                <input type="text" name="city" id="t_city" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Address *</label>
                <input type="text" name="address" id="t_address" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Total Seats</label>
                <input type="number" name="total_seats" id="t_seats" class="form-control" value="168">
            </div>
            <div class="form-group">
                <label class="form-label">Facilities</label>
                <input type="text" name="facilities" id="t_fac" class="form-control" placeholder="IMAX, Parking...">
            </div>
            <div style="display:flex;gap:8px;">
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                <button type="button" onclick="resetForm()" class="btn btn-outline btn-sm">Reset</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function editTheater(id,name,city,address,seats,fac){
    document.getElementById('formTitle').textContent='Edit Theater';
    document.getElementById('t_name').value=name;
    document.getElementById('t_city').value=city;
    document.getElementById('t_address').value=address;
    document.getElementById('t_seats').value=seats;
    document.getElementById('t_fac').value=fac;
    document.getElementById('theaterForm').action='/admin/theaters/'+id;
    document.getElementById('methodSpoof').innerHTML='<input type="hidden" name="_method" value="PUT">';
    window.scrollTo({top:0,behavior:'smooth'});
}
function resetForm(){
    document.getElementById('formTitle').textContent='Add Theater';
    document.getElementById('theaterForm').action='{{ route('admin.theaters.store') }}';
    document.getElementById('theaterForm').reset();
    document.getElementById('methodSpoof').innerHTML='';
}
</script>
@endpush
@endsection