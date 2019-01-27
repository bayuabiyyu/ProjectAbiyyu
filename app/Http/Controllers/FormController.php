<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use DataTables;

class FormController extends Controller
{
    //
    public function index(){
        return view('pages.form');
    }

    public function data(){
        return view('pages.data');
    }

    public function dataTable(){

        //MENGAMBIL FILE DARI FOLDER TXT
        $folder = "assets/txt";
        $bukafolder = opendir($folder);
        $no = 1;

        //EXTRACT KE DALAM VARIABEL DATA
        if ($open = $bukafolder) {
            while ( ($file = readdir($open)) !== FALSE ) {
                if ($file == '.' || $file == '..' ) {
                    
                }else{
                    
                    $data[] = [
                        'no' => $no,
                        'nama' => $file,
                    ];

                    $no++;

                }
            }
            closedir($open);
        }

        //HASIL ARRAY DATA DI TARUH DI COLLECTION LARAVEL
        $collection = collect($data);
        return response()->json($collection);

        //OPSI 1
        // return Datatables::collection($collection)
        //         ->addColumn('action', function($collection){
        //             return view('pages.action', [
        //                 'model' => $collection,
        //                 'url_show' => url('/form/'.$collection[]['nama'])
        //             ]);  
        //         })
        //         ->toJson(true);
    }

    public function create(){
        return view('form');
    }

    public function store(Request $request){

        //VALIDASI SERVER SIDE
        $this->validate($request, [
            'nama' => 'required|string',
            'email' => 'required|string|email',
            'tgl_lahir' => 'required|string',
            'no_telp' => 'required|string',
            'gender' => 'required|string',
            'alamat' => 'required|string',
        ],
        [
            'nama.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'tgl_lahir.required' => 'Tgl Lahir tidak boleh kosong',
            'no_telp.required' => 'No. Telp tidak boleh kosong',
            'gender.required' => 'Gender tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            
        ]);
        
        //INISIALISASI WAKTU
        date_default_timezone_set('Asia/Jakarta');
        $dt = new \DateTime();

        //UBAH FORMAT WAKTU SESUAI KEINGINAN
        $result = $dt->format('dmYhis');
        $namaFile = $request->nama.'-'.$result.'.txt';
        
        //SAVE KE TXT SESUAI INPUT 
        $nama = $request->nama;
        $email = $request->email;
        $tgl_lahir = $request->tgl_lahir;
        $no_telp = $request->no_telp;
        $gender = $request->gender;
        $alamat = $request->alamat;
        $file = fopen("assets/txt/".$namaFile, "w");
        fwrite($file, $nama.','.$email.','.$tgl_lahir.','.$no_telp.','.$gender.','.$alamat);  
        fclose($file);
        
        //IF SUCCESS MAKA MENGIRIM JSON SUCCESS
        $data = [
            'success' => true
        ];

        return response()->json($data);
    }

    public function show($id){

        $url = 'assets/txt/'.$id;
        $fileContent = file_get_contents($url);
        $data = explode(',', $fileContent);
        $collection['id'] = $id;
        $collection['nama'] = $data[0];
        $collection['email'] = $data[1];
        $collection['tgl_lahir'] = $data[2];
        $collection['no_telp'] = $data[3];
        $collection['gender'] = $data[4];
        $collection['alamat'] = $data[5];
        return view('pages.show', compact('collection'));

    }

    public function edit($id){

        $url = 'assets/txt/'.$id;
        $fileContent = file_get_contents($url);
        $data = explode(',', $fileContent);
        $collection['id'] = $id;
        $collection['nama'] = $data[0];
        $collection['email'] = $data[1];
        $collection['tgl_lahir'] = $data[2];
        $collection['no_telp'] = $data[3];
        $collection['gender'] = $data[4];
        $collection['alamat'] = $data[5];
        json_encode($collection);
        return response()->json($collection);

    }

    public function update(Request $request, $id){

        //VALIDASI SERVER SIDE
        $this->validate($request, [
            'nama' => 'required|string',
            'email' => 'required|string|email',
            'tgl_lahir' => 'required|string',
            'no_telp' => 'required|string',
            'gender' => 'required|string',
            'alamat' => 'required|string',
        ],
        [
            'nama.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'tgl_lahir.required' => 'Tgl Lahir tidak boleh kosong',
            'no_telp.required' => 'No. Telp tidak boleh kosong',
            'gender.required' => 'Gender tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            
        ]);
        
        //DELETE FILE
        unlink('assets/txt/'.$id);
        $explode = explode('-', $id);
        $time = $explode[1];
        $namaFile = $request->nama.'-'.$time;


        //UPDATE/SAVE KE TXT SESUAI INPUT 
        $nama = $request->nama;
        $email = $request->email;
        $tgl_lahir = $request->tgl_lahir;
        $no_telp = $request->no_telp;
        $gender = $request->gender;
        $alamat = $request->alamat;
        $file = fopen("assets/txt/".$namaFile, "w");
        fwrite($file, $nama.','.$email.','.$tgl_lahir.','.$no_telp.','.$gender.','.$alamat);  
        fclose($file);
        
        //IF SUCCESS MAKA MENGIRIM JSON SUCCESS
        $data = [
            'success' => true
        ];
        
        return response()->json($data);

    }

    public function destroy($id){
        
        if(unlink('assets/txt/'.$id)){
            $data = [
                'success' => true
            ];
        }

        return response()->json($data);
        
    }

}
