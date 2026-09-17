 @extends('layouts.app')

 @section('content')

     {{-- <h1 class="h3 mb-2 text-gray-800">Total Pengguna</h1> --}}
     {{-- Tombol Tambah Desa --}}
     <div class="container">
         <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambahUser">
             + Tambah Users
         </button>

         <!-- Data User -->
         <div class="card shadow mb-4">
             <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
             </div>
             <div class="card-body">
                 <div class="table-responsive">
                     <table class="table display" id="dataTable" width="100%" cellspacing="0">
                         <thead>
                             <tr>
                                 <th>Nama Lengkap</th>
                                 <th>Username</th>
                                 <th>Nomer Hp</th>
                                 <th>Jabatan</th>
                                 <th>Status Akun</th>
                                 <th>Aksi</th>
                             </tr>
                         </thead>
                         <tbody>
                             @forelse ($users as $user)
                                 <tr>
                                     <td>{{ $user->nama }}</td>
                                     <td>{{ $user->username }}</td>
                                     <td>{{ $user->hp }}</td>
                                     <td>{{ $user->jabatan ? $user->jabatan->nama_jabatan : '-' }}</td>
                                     <td>{{ $user->status == 'Y' ? 'Aktif' : 'Nonaktif' }}</td>
                                     <td>
                                         <button type="button" class="btn btn-sm btn-warning btn-edit-user"
                                             data-id="{{ $user->id }}" data-nama="{{ $user->nama }}"
                                             data-username="{{ $user->username }}" data-hp="{{ $user->hp }}"
                                             data-id_jabatan="{{ $user->id_jabatan }}" data-status="{{ $user->status }}"
                                             data-is_logged_in="{{ $user->is_logged_in }}"
                                             data-alamat="{{ $user->alamat }}" data-toggle="modal"
                                             data-target="#modalEditUser">
                                             Edit
                                         </button>

                                         <form action="{{ route('userweb.destroy', $user->id) }}" method="POST"
                                             class="d-inline" onsubmit="return confirm('Hapus User ini?')">
                                             @csrf
                                             @method('DELETE')
                                             <button class="btn btn-danger btn-sm">Hapus</button>
                                         </form>
                                     </td>
                                 </tr>
                             @empty
                                 <tr>
                                     <td colspan="3">Belum ada user.</td>
                                 </tr>
                             @endforelse
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>

         {{-- Modal Tambah User --}}
         <div class="modal fade" id="modalTambahUser" tabindex="-1">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title">Tambah User</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <div class="modal-body">
                         @if ($errors->any())
                             <div class="alert alert-danger">
                                 <ul>
                                     @foreach ($errors->all() as $error)
                                         <li>{{ $error }}</li>
                                     @endforeach
                                 </ul>
                             </div>
                         @endif
                         <form action="{{ route('userweb.store') }}" method="POST" enctype="multipart/form-data">
                             {{ csrf_field() }}
                             <!-- Nama -->
                             <div class="mb-3">
                                 <label>Nama Lengkap</label>
                                 <input type="text" name="nama" class="form-control" required maxlength="100">
                             </div>
                             <!-- USERNAME -->
                             <div class="mb-3">
                                 <label>Username</label>
                                 <input type="text" name="username" class="form-control" maxlength="100">
                             </div>
                             <!-- HP -->
                             <div class="mb-3">
                                 <label>Nomer Hp</label>
                                 <input type="text" name="hp" class="form-control" maxlength="100">
                             </div>
                             {{-- ID_JABATAN --}}
                             <div class="mb-3">
                                 <label>Jabatan</label>
                                 <select name="id_jabatan" class="form-control shadow-sm">
                                     <option value="00">Admin</option>
                                     <option value="01">Suveyor Rukun Tetangga</option>
                                     <option value="02">Surveyor Keluarga</option>
                                     <option value="03">Surveyor Individu</option>
                                 </select>
                             </div>
                             {{-- Status AKUN --}}
                             <div class="mb-3">
                                 <label>Status Akun</label>
                                 <select name="status" class="form-control shadow-sm">
                                     <option value="Y">Aktif</option>
                                     <option value="N">Nonaktif</option>
                                 </select>
                             </div>
                             {{-- Foto --}}
                             <div class="mb-3">
                                 <label for="alamat" class="font-weight-bold">Alamat</label>
                                 <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="10"></textarea>
                             </div>
                             {{-- Password --}}
                             <div class="mb-3">
                                 <label>Password</label>
                                 <input type="password" name="password" class="form-control" maxlength="100">
                             </div>
                             <div class="mb-3">
                                 <label>Confirm Password</label>
                                 <input type="password" name="password_confirmation" class="form-control" maxlength="100">
                             </div>
                             <!-- Tombol Simpan -->
                             <button type="submit" class="btn btn-primary w-100">Simpan User</button>
                         </form>
                     </div>
                 </div>
             </div>
         </div>

         {{-- Modal Edit User --}}
         <div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel">
             <div class="modal-dialog modal-md">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="modalEditUserLabel">Edit User</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <div class="modal-body">
                         <div class="modal-body">
                             <form id="formEditUser" method="POST">
                                 @csrf
                                 @method('PUT')
                                 <div class="mb-3">
                                     <label>Nama User</label>
                                     <input type="text" name="nama" id="edit_nama" class="form-control" required>
                                 </div>
                                 <div class="mb-3">
                                     <label>Username</label>
                                     <input type="text" name="username" id="edit_username" class="form-control"
                                         required>
                                 </div>
                                 <div class="mb-3">
                                     <label>Nomer Hp</label>
                                     <input type="text" name="hp" id="edit_hp" class="form-control" required>
                                 </div>
                                 {{-- ID_JABATAN --}}
                                 <div class="mb-3">
                                     <label>Jabatan</label>
                                     <select name="id_jabatan" class="form-control shadow-sm" id="edit_id_jabatan">
                                         <option value="00">Admin</option>
                                         <option value="01">Suveyor Rukun Tetangga</option>
                                         <option value="02">Surveyor Keluarga</option>
                                         <option value="03">Surveyor Individu</option>
                                     </select>
                                 </div>
                                 {{-- Status AKUN --}}
                                 <div class="mb-3">
                                     <label>Status Akun</label>
                                     <select name="status" class="form-control shadow-sm" id="edit_status">
                                         <option value="Y">Aktif</option>
                                         <option value="N">Nonaktif</option>
                                     </select>
                                 </div>
                                 {{-- Status AKUN --}}
                                 <div class="mb-3">
                                     <label>Status Login</label>
                                     <select name="is_logged_in" class="form-control shadow-sm" id="edit_is_logged_in">
                                         <option value="1">Aktif</option>
                                         <option value="0">Nonaktif</option>
                                     </select>
                                 </div>
                                 {{-- Alamat --}}
                                 <label for="alamat" class="font-weight-bold">Alamat</label>
                                 <textarea name="alamat" id="edit_alamat" class="form-control" cols="30" rows="10"></textarea>
                                 {{-- Password --}}
                                 <div class="mb-3">
                                     <label>Password</label>
                                     <input type="password" name="password" class="form-control" id="edit_password"
                                         maxlength="100">
                                 </div>
                                 <div class="mb-3">
                                     <label>Confirm Password</label>
                                     <input type="password" name="password_confirmation" class="form-control"
                                         maxlength="100" placeholder="Konfirmasi Password">
                                 </div>
                                 <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                             </form>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>



 @endsection
 @push('scripts')
     <script>
         $(document).ready(function() {
             $('#modalEditUser').on('show.bs.modal', function(event) {
                 var button = $(event.relatedTarget);
                 var id = button.data('id');
                 var nama = button.data('nama');
                 var username = button.data('username');
                 var hp = button.data('hp');
                 var id_jabatan = button.data('id_jabatan');
                 var status = button.data('status');
                 var alamat = button.data('alamat');
                 var is_logged_in = button.data('is_logged_in');

                 $('#formEditUser').attr('action', '{{ url('/userweb') }}/' + id);
                 $('#edit_nama').val(nama);
                 $('#edit_username').val(username);
                 $('#edit_hp').val(hp);
                 $('#edit_id_jabatan').val(id_jabatan);
                 $('#edit_status').val(status);
                 $('#edit_alamat').val(alamat);
                 $('#edit_is_logged_in').val(is_logged_in);

                 // HAPUS pengisian password dari sini
             });
         });
     </script>

     {{-- STYLE INPUT FILE --}}
     <script>
         document.querySelector('.custom-file-input').addEventListener('change', function(e) {
             var fileName = document.getElementById("fileUpload").files[0].name;
             var nextSibling = e.target.nextElementSibling
             nextSibling.innerText = fileName
         })
     </script>
 @endpush
