@extends('layouts.admin')

@section('htmlheader_title') Expert @endsection
@section('contentheader_title') Expert @endsection
@section('contentheader_description') All Expert @endsection
@section('main-content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer ></script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"  /> -->
<style type="text/css">
  .content-wrapper.mainContent {
    max-width: 100%;
    width: 100%;
    margin: 0 auto;
}
</style>

 <div class="content-wrapper mainContent">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Expert Data</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li><a href="{{url('admin/expert/create')}}" class="button btn btn-primary">Create New Expert</a></li>

            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
     <div class="flash-message">
      @foreach ([ 'success'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
      @endif
      @endforeach
    </div>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th>Id</th>
        <th>First Name</th>
        <th>Email</th>
        <th>Created Date</th>
        <th>User Type</th>
       
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
     @foreach ($expertAll as $key => $user)
      <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->created_at }}</td>
        <td>{{ $user->role }}</td>
       
        <td><a class="btn btn-primary" href="edituser/{{ $user->id }}"><i class="fa fa-edit"></i></a>
        <a class="btn btn-danger delete-confirm" data-id="{{$user->id}}" href="{{url('admin/expert/delete')}}/{{ $user->id }}"><i class="fa fa-trash-o"></i></a></td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th>Id</th>
        <th>First Name</th>
        <th>Email</th>
        <th>Created Date</th>
        <th>User Type</th>
      
        <th>Action</th>
      </tr>
    </tfoot>
  </table>

  </div>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
 $('.delete-confirm').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    swal({
        title: 'Are you sure?',
        text: 'This record and it`s details will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
    }).then(function(value) {
        if (value) {
            window.location.href = "{{url('admin/expert/delete')}}/{{ $user->id }}";
        }
    });
});
</script>
@endsection