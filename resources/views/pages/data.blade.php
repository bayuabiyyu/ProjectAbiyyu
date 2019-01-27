@extends('layout.app')

@section('content')
<div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">
                <div align="center">
                    DATA
                    
                </div>
                {{-- <a href="" title="Add Data" class="btn btn-info pull-right modal-show" style="margin-top: -8px;">Add Data</a> --}}
            </h4>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table id="datatable" class="table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="show_data">

                </tbody>
                <tfoot>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Action</th>
                </tfoot>
            </table>
          </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('layout.modal')
@endsection

@section('modal_edit')
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLaravel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title-edit" id="modal-title-edit" align="center">EDIT DATA</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="modal-body-edit">
              
                @include('pages.edit')

            </div>
            <div class="modal-footer" id="modal-footer-edit">
              <button type="button" class="btn btn-secondary" id="btnClose-edit" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
@endsection

@push('script')
    <script>
        // $('#datatable').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "{{ url('/datatable') }}",
        //         columns: [
        //             {data: 'no', name: 'no'},
        //             {data: 'nama', name: 'nama'},
        //         ]
        //     });

        //VALIDASI COMA
        validationComa();
        function validationComa(){
            $(document).on("keydown", '.input', function (e) {
                if (e.keyCode == 188) { // KeyCode For comma is 188
                    return false;
                }
            });
        }
    
        //INISIALISASI DATE TIME UNTUK TGL LAHIR
        $('#tgl_lahir').datepicker({
            format: 'yyyy-mm-dd'
        });

        //INISIALISASI HALAMAN
            show_data();
            function show_data(){
                var url = "{{ url('/datatable') }}";
                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'JSON',
                    success: function(response){
                    var html = "";
                    var no = 1;

                    for(var i= 0; i < response.length; i++ ){
                        html += '<tr>'+
                            '<td>' + no + '</td>' +
                            '<td>' + response[i].nama + '</td>' +
                            '<td>' +
                                '<a href="javascript:void;" title="Show" class="fa fa-search btn btn-info btn-sm item_show" data-id="'+response[i].nama+'"> SHOW </a>'+ ' ' +
                                '<a href="javascript:void;" title="Edit" class="fa fa-edit btn btn-warning btn-sm item_edit" data-id="'+response[i].nama+'"> EDIT </a>'+ ' ' +
                                '<a href="javascript:void;" title="Delete" class="fa fa-trash btn btn-danger btn-sm item_delete" data-id="'+response[i].nama+'"> DELETE </a>'+
                                '</td>'+
                            '</td>'+
                        '</tr>';
                        no++;
                    }

                    $('#show_data').html(html);
                    $('#datatable').DataTable();

                    },
                    error: function(error){
                        $('#show_data').html("");
                        $('#datatable').DataTable();
                    }
                });
            }

            //BTN RESET CLICK
            $('#btnReset').click(function(event){
                var me = $(this);
                $('#formku_edit').trigger('reset');
                $('#formku_edit').find('.help-block').remove();
                $('#formku_edit').find('.form-group').removeClass('has-error');
            });

            //DETAIL SHOW DATA
            $('#show_data').on('click', '.item_show', function(event){
                var form    = $(this)
                    id      = form.data('id')
                    url     = "{{ url('/form') }}" + '/' + id;
                
                $.ajax({
                    url: url,
                    dataType: 'html',
                    success: function(response){
                        $('#modal-title').text('SHOW DATA : ' + id);
                        $('#modal-body').html(response);
                    }
                });
                $('#modal').modal('show');

            });

            //DELETE DATA
            $('#show_data').on('click', '.item_delete', function(event){
                var form    = $(this)
                    id      = form.data('id')
                    url     = "{{ url('/form/destroy') }}" + '/' + id
                    token   = "{{ csrf_token() }}";
                    method  = "POST";
                
                swal({
                    title: 'Yakin ingin menghapus ? ' + id + ' ?',
                    text: 'Apakah anda yakin ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Deleted!!'
                }).then((result) => {
                     if(result.value){
                        $.ajax({
                            url: url,
                            dataType: 'JSON',
                            method: method,
                            data: {_token: token, _method: method},
                            success: function(response){
                                swal({
                                    type: 'success',
                                    title: 'Success!!',
                                    text: 'DELETE DATA SUCCESS !!'
                                });
                                show_data();
                            },
                            error: function(error){
                                alert("Error");
                            }
                        });
                    }
                }); 
            });

            //GET DATA EDIT
            $('#show_data').on('click', '.item_edit', function(event){
                var form    = $(this)
                    id      = form.data('id')
                    url     = "{{ url('/form/edit') }}" + '/' + id;
                $('#modal-title-edit').text('EDIT DATA : ' + id)
                $('#formku_edit').find('.help-block').remove();
                $('#formku_edit').find('.form-group').removeClass('has-error');
                $.ajax({
                    url: url,
                    dataType: 'JSON',
                    success: function(response){
                        $('#id').val(response.id);
                        $('#nama').val(response.nama);
                        $('#email').val(response.email);
                        $('#tgl_lahir').val(response.tgl_lahir);
                        $('#no_telp').val(response.no_telp);
                        $('#gender').val(response.gender);
                        $('#alamat').val(response.alamat);
                    }
                });

                $('#modal_edit').modal('show');

            });


        
        //FORM EDIT SUBMITED
        $('#formku_edit').submit(function(event){
            event.preventDefault();
            var me      = $(this)
                method  = me.attr('method')
                data    = me.serialize()
                id      = $('#id').val()
                url     = "{{ url('/form/update') }}" + '/' + id;

            me.find('.help-block').remove();
            me.find('.form-group').removeClass('has-error');
            swal({
                    title: 'Yakin ingin mengubah data ? ' + id + ' ?',
                    text: 'Apakah anda yakin ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Update!!'
            }).then((result) => {
            if(result.value){            
            $.ajax({
                url: url ,
                dataType: 'JSON',
                method: method,
                data: data,
                success: function(response){
                    swal({
                            type: 'success',
                            title: 'Success!!',
                            text: 'EDIT DATA SUCCESS !!'
                        });
                    me.trigger('reset');
                    $('#modal_edit').modal('hide');
                    show_data();
                },
                error: function(error){
                    me.find('.help-block').remove();
                    me.find('.form-group').removeClass('has-error');
                    var res = error.responseJSON;
                        if($.isEmptyObject(res) == false){
                            $.each(res.errors, function(key, value){
                                $('#' + key)
                                .closest('.form-group')
                                .addClass('has-error')
                                .append('<span class="help-block"><strong>'+ value +'</strong></span>')
                            });
                        }
                }
            });
           }
          }); 
        });

    </script>
@endpush