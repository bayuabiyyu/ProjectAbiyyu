@extends('layout.app')

@section('content')
<div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">
                <div align="center">
                    FORM INPUT DATA
                </div>
            </h4>
        </div>
        <div class="panel-body">
            <form name="formku" id="formku" action="{{ url('/form') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="Nama" class="col-sm-2 col-form-label">Nama <span style="color: red">*</span> </label> 
                        <div class="col-sm-6">
                            <input type="text" class="form-control input" id="nama" name="nama" placeholder="Masukkan Nama">
                        </div>
                </div>
                <div class="form-group row">
                        <label for="Email" class="col-sm-2 col-form-label">Email <span style="color: red">*</span> </label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control input" id="email" name="email" placeholder="Masukkan Email. Contoh : abi@mail.com ">
                        </div>
                </div>
                <div class="form-group row">
                        <label for="DateofBirth" class="col-sm-2 col-form-label">Tgl Lahir <span style="color: red">*</span> </label> 
                        <div class="col-sm-6">
                                <div class="input-append date input" id="dp" data-date="" data-date-format="yyyy-mm-dd">
                                        <input id="tgl_lahir" name="tgl_lahir" class="form-control span2" size="16" type="text" placeholder="yyyy-mm-dd"  />
                                </div>
                            {{-- <input data-provide="datepicker" type="text" class="form-control"  placeholder="Masukkan Tgl Lahir"> --}}
                        </div>
                </div>
                <div class="form-group row">
                        <label for="NoTelp" class="col-sm-2 col-form-label">No. Telp <span style="color: red">*</span> </label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control input" id="no_telp" name="no_telp" placeholder="Masukkan NoTelp ">
                        </div>
                </div>
                <div class="form-group row">
                        <label for="Gender" class="col-sm-2 col-form-label">Gender <span style="color: red">*</span> </label> 
                            <div class="col-sm-3">
                                <select class="form-control input" name="gender" id="gender">
                                    <option value=""></option>
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>
                                </select>
                            </div>
                </div>
                <div class="form-group row">
                        <label for="Alamat" class="col-sm-2 col-form-label">Alamat <span style="color: red">*</span> </label> 
                            <div class="col-sm-6">
                                <textarea class="form-control input" name="alamat" id="alamat" cols="5" rows="4"></textarea>
                            </div>
                </div>
                <div class="form-group row">
                    <div align="center">
                        <button type="button" class="btn btn-danger" id="btnReset" name="btnReset">Reset</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmit" name="btnSubmit">Save</button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>

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

        //BTN RESET CLICK
        $('#btnReset').click(function(event){
            var me = $(this);
            $('#formku').trigger('reset');
            $('#formku').find('.help-block').remove();
            $('#formku').find('.form-group').removeClass('has-error');
        });

        //FORM SUBMITED
        $('#formku').submit(function(event){
            event.preventDefault();
            var me = $(this)
                url = me.attr('action')
                method = me.attr('method')
                data = me.serialize();

            swal({
                    title: 'SUBMIT DATA',
                    text: 'Apakah anda yakin ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Submit!!'
            }).then((result) => {
            if(result.value){   
            me.find('.help-block').remove();
            me.find('.form-group').removeClass('has-error');
            $.ajax({
                url: url ,
                dataType: 'JSON',
                method: method,
                data: data,
                success: function(response){
                    swal({
                            type: 'success',
                            title: 'Success!!',
                            text: 'Terima Kasih Telah Mengisi Form !!'
                        });
                    me.trigger('reset');
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