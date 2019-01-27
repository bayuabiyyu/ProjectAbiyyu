<div class="table-responsive">
    <table id="datatable" class="table table-hover">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Tgl Lahir</th>
                <th>No. Telp</th>
                <th>Gender</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <tr>  
                <td>{{ $collection['nama'] }}</td>
                <td>{{ $collection['email'] }}</td>
                <td>{{ $collection['tgl_lahir'] }}</td>
                <td>{{ $collection['no_telp'] }}</td>
                <td>{{ $collection['gender'] }}</td>
                <td>{{ $collection['alamat'] }}</td>
            </tr>
        </tbody>
    </table>
</div>