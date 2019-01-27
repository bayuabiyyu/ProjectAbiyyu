<form name="formku_edit" id="formku_edit" action="" method="POST">
    <input type="hidden" name="id" id="id">
    {{ csrf_field() }}
    <div class="form-group row">
        <label for="Nama" class="col-sm-2 col-form-label">Nama <span style="color: red">*</span> </label> 
            <div class="col-sm-10">
                <input type="text" class="form-control input" id="nama" name="nama" placeholder="Masukkan Nama">
            </div>
    </div>
    <div class="form-group row">
            <label for="Email" class="col-sm-2 col-form-label">Email <span style="color: red">*</span> </label>
            <div class="col-sm-10">
                <input type="email" class="form-control input" id="email" name="email" placeholder="Masukkan Email. Contoh : abi@mail.com">
            </div>
    </div>
    <div class="form-group row">
            <label for="DateofBirth" class="col-sm-2 col-form-label">Tgl Lahir <span style="color: red">*</span> </label> 
            <div class="col-sm-10">
                    <div class="input-append date input" id="dp" data-date="" data-date-format="yyyy-mm-dd">
                            <input id="tgl_lahir" name="tgl_lahir" class="form-control span2" size="16" type="text" placeholder="yyyy-mm-dd"  />
                    </div>
                {{-- <input data-provide="datepicker" type="text" class="form-control"  placeholder="Masukkan Tgl Lahir"> --}}
            </div>
    </div>
    <div class="form-group row">
            <label for="NoTelp" class="col-sm-2 col-form-label">No. Telp <span style="color: red">*</span> </label>
            <div class="col-sm-10">
                <input type="number" class="form-control input" id="no_telp" name="no_telp" placeholder="Masukkan NoTelp">
            </div>
    </div>
    <div class="form-group row">
            <label for="Gender" class="col-sm-2 col-form-label">Gender <span style="color: red">*</span> </label> 
                <div class="col-sm-10">
                    <select class="form-control input" name="gender" id="gender">
                        <option value=""></option>
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
                </div>
    </div>
    <div class="form-group row">
            <label for="Alamat" class="col-sm-2 col-form-label">Alamat <span style="color: red">*</span> </label> 
                <div class="col-sm-10">
                    <textarea class="form-control input" name="alamat" id="alamat" cols="5" rows="4"></textarea>
                </div>
    </div>
    <div class="form-group row">
        <div align="center">
            <button type="button" class="btn btn-danger" id="btnReset" name="btnReset">Reset</button>
            <button type="submit" class="btn btn-primary" id="btnSubmit" name="btnSubmit">Update</button>
        </div>
    </div>
</form>