<?php

namespace App\Controllers;
use Codeigniter\Controller;
use App\Models\Gudang;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
date_default_timezone_set('Asia/Jakarta');
class Home extends BaseController
{








public function lockscreen()
{
    if (session()->get('id_level') > 0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where);
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting', $where);

        $this->log_activity('User membuka Lock Screen');

        echo view('header', $data);
        echo view('lockscreen', $data); // Kirim data ke view
    } else {
        return redirect()->to('Home/login');
    }
}

public function validatePassword()
{
    $password = $this->request->getPost('password');
    $model = new Gudang();
    $where = array(
        'id_user' => session()->get('id_user'),
        'password' => md5($password)
    );

    $user = $model->getWhere('tb_user', $where);

    if ($user) {
        // Password is correct, set flash message and proceed to dashboard
        session()->setFlashdata('success', 'Password correct');
        return redirect()->to('Home/lockscreen');
    } else {
        // Password is incorrect, set flash message and reload lockscreen
        session()->setFlashdata('error', 'Incorrect password');
        return redirect()->to('Home/lockscreen');
    }
}


	public function login()
{
    $model = new Gudang;
    $where = array('id_setting' => 1);
    $data['setting'] = $model->getWhere('tb_setting',$where);
	echo view('header',$data);
	echo view('login');

}
public function logout()
{

 $this->log_activity('User melakukan logout');
session()->destroy();
return redirect()->to('Home/login');

}
public function aksilogin()
{
    $u = $this->request->getPost('username');
    $p = $this->request->getPost('password');
    $captchaAnswer = $this->request->getPost('captcha_answer');

    
    $model = new Gudang();
    $where = array(
        'username' => $u,
        'password' => md5($p)
    );

    $cek = $model->getWhere('tb_user', $where);

    // Offline CAPTCHA answer (should match the one generated in the view)
    if (!$this->isOnline() && !empty($captchaAnswer)) {
        $correctAnswer = $this->request->getPost('correct_captcha_answer');
        if ($captchaAnswer != $correctAnswer) {
            return redirect()->to('Home/login')->with('error', 'Incorrect offline CAPTCHA.');
        }
    }

    if ($cek > 0) {
        session()->set('id_user', $cek->id_user);
        session()->set('username', $cek->username);
        session()->set('email', $cek->email);
        session()->set('id_level', $cek->id_level);

        return redirect()->to('Home/dashboard');
    } else {
        return redirect()->to('Home/login')->with('error', 'Invalid username or password.');
    }
}

private function isOnline()
{
    return @fopen("http://www.google.com:80/", "r");
}
    public function setting()
    {
        if (session()->get('id_level') == '1' || session()->get('id_level') == '2') {
        $model=new Gudang;
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka halaman Setting');
        echo view('header',$data);
        echo view('menu',$data);
        echo view('setting',$data);
        echo view('footer');
        // print_r($data);
    }else{
        return redirect()->to('home/error404');
    }
    }
        public function resetpassword($id){
        $model = new Gudang;
        $this->log_activity('User melakukan Reset Password');
        $where = array('id_user' =>$id );
        $table = 'tb_user'; // Nama tabel
        $kolom = 'id_user';
        $data = array(
        
            'password' => md5('123'),
        );
    
        $model->resetpassword($table, $kolom, $where, $data);
        return redirect()->to('Home/user');
    }
        public function aksi_e_setting()
{
    $model = new Gudang();
    $a = $this->request->getPost('nama_web');
    $icon = $this->request->getFile('logo_tab');
    $dash = $this->request->getFile('logo_dashboard');
    $login = $this->request->getFile('logo_login');

    $this->log_activity('User melakukan Setting');

    // Debugging: Log received data
    log_message('debug', 'Website Name: ' . $a);
    log_message('debug', 'Tab Icon: ' . ($icon ? $icon->getName() : 'None'));
    log_message('debug', 'Dashboard Icon: ' . ($dash ? $dash->getName() : 'None'));
    log_message('debug', 'Login Icon: ' . ($login ? $login->getName() : 'None'));

    $data = ['nama_web' => $a];

    if ($icon && $icon->isValid() && !$icon->hasMoved()) {
        $icon->move(ROOTPATH . 'public/images/img/', $icon->getName());
        $data['logo_tab'] = $icon->getName();
    }

    if ($dash && $dash->isValid() && !$dash->hasMoved()) {
        $dash->move(ROOTPATH . 'public/images/img/', $dash->getName());
        $data['logo_dashboard'] = $dash->getName();
    }

    if ($login && $login->isValid() && !$login->hasMoved()) {
        $login->move(ROOTPATH . 'public/images/img/', $login->getName());
        $data['logo_login'] = $login->getName();
    }

    $where = ['id_setting' => 1];
    $model->edit('tb_setting', $data, $where);

    return redirect()->to('Home/setting');
}
    private function log_activity($activity)
    {
        $model = new Gudang();
        $data = [
            'id_user'    => session()->get('id_user'),
            'activity'   => $activity,
            'timestamp' => date('Y-m-d H:i:s')
           
        ];

        $model->tambah('tb_activity', $data);
    }
        public function activity()
    {
       if (session()->get('id_level') == '1' || session()->get('id_level') == '2') {
            $model = new Gudang();
            $where = array('id_user' => session()->get('id_user'));
            $data['dennis'] = $model->getwhere('tb_user', $where); 
            $where = array('id_setting' => 1);
            $data['setting'] = $model->getWhere('tb_setting',$where);
            $where=array('id_user'=>session()->get('id_user'));
            $data['user']=$model->getWhere('tb_user', $where);
            
            $this->log_activity('User membuka Log Activity');
            $data['erwin'] = $model->join('tb_activity', 'tb_user',
            'tb_activity.id_user = tb_user.id_user',$where);

        echo view('header',$data);
        echo view('menu',$data);
        echo view('activity',$data);
        echo view('footer');
    
        }else{
            return redirect()->to('Home/error404');
        }
    }
    public function hapus_activity($id){
    $model = new Gudang();
    
    $where = array('id_activity'=>$id);
    $model->hapus('tb_activity',$where);
    $this->log_activity('User melakukan Penghapusan activity');
    
    return redirect()->to('Home/activity');
}
   public function clear_all_activities() {
    $model = new Gudang(); // Pastikan model sudah terdefinisi dengan benar
    
    // Panggil method untuk menghapus semua data dari tabel
    $model->clear_table('tb_activity');
    
    // Log aktivitas
    $this->log_activity('User melakukan Penghapusan seluruh data activity');
    
    // Redirect ke halaman activity setelah penghapusan
    return redirect()->to('Home/activity');
}
 public function user()
    {
        // if (session()->get('id_level')>0) {
            if (session()->get('id_level') == '1' || session()->get('id_level') == '2') {
        $model = new Gudang();
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka view User');
        $data['kelas'] = $model->tampil('tb_kelas');
        $where=array('id_user'=>session()->get('id_user'));
        $data['syp'] = $model->join('tb_user', 'tb_kelas',
            'tb_user.id_kelas = tb_kelas.id_kelas',$where);
        echo view('header',$data);
        echo view('menu',$data);
        echo view('user',$data);
        echo view('footer');
    
        }else{
            return redirect()->to('Home/error404');
        }
    }
            public function t_user()
    {
        if (session()->get('id_level')>0) {
        $model = new Gudang();
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka Form Penambahan Data User');
       $data['kelas'] = $model->tampil('tb_kelas');
        echo view ('header',$data);
        echo view('menu',$data);
        echo view('t_user');
        echo view('footer');
    }else{
        return redirect()->to('Home/login');
    }
    }
 public function aksi_t_user()
    {
        $model = new Gudang();
        $this->log_activity('User melakukan Penambahan Data User');
        $a = $this->request->getPost('username');
        $b = $this->request->getPost('password');
        $c = $this->request->getPost('email');
        $wa = $this->request->getPost('wa');
        $d = $this->request->getPost('level');
        $kelas = $this->request->getPost('kelas');
        $isi = array(

                    'username' => $a,
                    'password' =>md5 ($b),
                    'email' => $c,
                    'no_wa' => $wa,
                    'id_level' => $d,
                    'id_kelas' => $kelas,
                    'create_at' => date('Y-m-d H:i:s')  // Set current datetime for create_at
                    
                    
        );
        
        $model->tambah('tb_user', $isi);
        return redirect()->to('Home/user');

    }

        public function t_alumni()
    {
        if (session()->get('id_level')>0) {
        $model = new Gudang();
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka Form Penambahan Data alumni');
       
        echo view ('header',$data);
        echo view('menu',$data);
        echo view('t_alumni');
        echo view('footer');
    }else{
        return redirect()->to('Home/login');
    }
    }
            public function aksi_e_user()
{
    $model = new Gudang();
    $this->log_activity('User melakukan Pengeditan Data User');
    $id_user = $this->request->getPost('id_user');
    $username = $this->request->getPost('username');
    $kelas = $this->request->getPost('kelas');
    $email = $this->request->getPost('email');
    $wa = $this->request->getPost('wa');
    $id_level = $this->request->getPost('id_level');

    $where = array('id_user' => $id_user);
    $data = array(
        'username' => $username,
        'email' => $email,
        'no_wa' => $wa,
        'id_level' => $id_level,
        'id_kelas' => $kelas,
        'update_at' => date('Y-m-d H:i:s')
    );

    $model->edit('tb_user', $data, $where);
    return redirect()->to('Home/user');
}
public function hapus_user($id){
    $model = new Gudang();
    
    // Log aktivitas penghapusan
    $this->log_activity('User melakukan Penghapusan Data User');

    // Hapus aktivitas terkait user yang dihapus
    $where_activity = array('id_user' => $id);
    $model->hapus('tb_activity', $where_activity);

    // Hapus user dari tb_user
    $where_user = array('id_user' => $id);
    $model->hapus('tb_user', $where_user);
   
    // Redirect setelah penghapusan
    return redirect()->to('Home/user');
}

public function profile()
    {
        if (session()->get('id_level') > 0) {
            $model = new GUdang();
            
            $this->log_activity('User masuk ke profile');
            $where = array('id_user' => session()->get('id_user'));
            $data['dennis'] = $model->getwhere('tb_user', $where);
            $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);

            echo view('header', $data);
            echo view('menu', $data);
            echo view('profile', $data);
            echo view('footer');
        } else {
            return redirect()->to('Home/login');
        }
    }
    public function deletefoto()
{
    $model = new Gudang(); // Pastikan model ini menangani tabel tb_user
    $this->log_activity('Menghapus Foto Profil');

    // Ambil ID user dari form
    $userId = $this->request->getPost('id');

    // Ambil data user dari database
    $userData = $model->getById($userId);

    // Pastikan userData valid
    if ($userData && $userData->foto_profile) {
        // Hapus file gambar dari file system
        $filePath = ROOTPATH . 'public/images/img/' . $userData->foto_profile;
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Update database untuk menghapus nama file gambar
        $userDataUpdate = ['foto_profile' => null];
        $model->edit('tb_user', $userDataUpdate, ['id_user' => $userId]);
    }

    return redirect()->to(base_url('Home/profile'))->with('status', 'Foto profil berhasil dihapus');
}

public function editfoto()
{
    $model = new Gudang(); // Pastikan model ini menangani tabel tb_user
    $this->log_activity('Mengedit Foto');
    
    // Ambil user saat ini dari session
    $userId = session()->get('id_user');
    $userData = $model->getById($userId); // Pastikan ini mengambil data user dengan benar

    // Cek apakah file di-upload
    if ($file = $this->request->getFile('foto')) {
        if ($file->isValid() && !$file->hasMoved()) {
            // Generate nama file baru
            $newFileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/images/img/', $newFileName); // Simpan ke file system
            
            // Jika ada foto lama, hapus
            if ($userData->foto_profile && file_exists(ROOTPATH . 'public/images/img/' . $userData->foto_profile)) {
                unlink(ROOTPATH . 'public/images/img/' . $userData->foto_profile);
            }
            
            // Update database dengan nama file baru
            $userDataUpdate = ['foto_profile' => $newFileName];
            $model->edit('tb_user', $userDataUpdate, ['id_user' => $userId]);
        }
    }

    return redirect()->to(base_url('Home/profile'))->with('status', 'Foto berhasil diperbarui');
}



    public function aksi_e_profile()
    {
        if (session()->get('id_level') > 0) {
            $model = new Gudang();
            $this->log_activity('Mengedit Profile');
            $cek = $this->request->getPost('username');
            $cek1 = $this->request->getPost('email');
            $id = $this->request->getPost('id');

            $where = array('id_user' => $id); // Jika id_user adalah kunci utama untuk menentukan record


            $isi = array(
                'username' => $cek,
                'email' => $cek1,
            );

            $model->edit('tb_user', $isi, $where);
            return redirect()->to('Home/profile');
            // print_r($yoga);
            // print_r($id);
        } else {
            return redirect()->to('Home/login');
        }
    }
            public function error404()
    {
        if(session()->get('id_level')> '1'){
            $model=new Gudang;
                      $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
            $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);

        $this->log_activity('User mencoba Ke Halaman data user');
    
        echo view('header',$data);
        echo view('error404');
        
    }else{
        return redirect()->to('Home/error404');
    }
    }
        public function changepassword()
    {
        if (session()->get('id_level') > 0) {

            $model = new Gudang();
            $this->log_activity('Mengubah Password');
            $where = array('id_setting' => 1);
            $data['setting'] = $model->getWhere('tb_setting',$where);
            $where = array('id_user' => session()->get('id_user'));
            $data['dennis'] = $model->getwhere('tb_user', $where);
            helper('permission'); // Pastikan helper dimuat

            echo view('header', $data);
            echo view('changepassword', $data);
           
        } else {
            return redirect()->to('Home/login');
        }
    }
    public function aksi_changepass()
    {
        $model = new Gudang();
        $oldPassword = $this->request->getPost('old');
        $newPassword = $this->request->getPost('new');
        $userId = session()->get('id_level');

        // Dapatkan password lama dari database
        $currentPassword = $model->getPassword($userId);

        // Verifikasi apakah password lama cocok
        if (md5($oldPassword) !== $currentPassword) {
            // Set pesan error jika password lama salah
            session()->setFlashdata('error', 'Password lama tidak valid.');
            return redirect()->back()->withInput();
        }

        // Update password baru
        $data = [
            'password' => md5($newPassword),
            'update_by' => $userId,
            'update_at' => date('Y-m-d H:i:s')
        ];
        $where = ['id_user' => $userId];

        $model->edit('tb_user', $data, $where);
session()->destroy();
        // Set pesan sukses
        session()->setFlashdata('success', 'Password berhasil diperbarui.');
        return redirect()->to('Home/login');
    }
    public function register()
    {
        $model = new Gudang;
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
       
        echo view ('header',$data);
        echo view ('register');
        
    }

    public function aksi_register()
    {
        $model = new Gudang();
        
        $a= $this->request->getPost('username');
        $b= $this->request->getPost('password');
        $c= $this->request->getPost('email');


        

        // $uploadedFile = $this->request->getFile('foto');
        // $foto = $uploadedFile->getName();

        $isi = array(
            
            'username' => $a,
            'password' => md5($b),
            'email' => $c,
            'create_at' => date('Y-m-d H:i:s'),  // Set current datetime for create_at
            'id_level' => 5
                );

        $model->tambah('tb_user', $isi);
        

        return redirect()->to('Home/login');
        
    }
public function kamar()
{
    if (session()->get('id_level') > 0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where);
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting', $where);
        
        $this->log_activity('User membuka daftar kamar');
        echo view('header', $data);
        echo view('menu', $data);
        echo view('kamar', $data); // Kirim data ke view
        echo view('footer');
    } else {
        return redirect()->to('Home/login');
    }
}
         public function t_kamar()
    {
       if(session()->get('id_level') == '1'){
        $model = new Gudang();
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka Form Penambahan Kamar');
       
        echo view ('header',$data);
        echo view('menu',$data);
        echo view('t_kamar');
        echo view('footer');
    }else{
        return redirect()->to('Home/error404');
    }
    }
public function aksi_t_kamar()
{
    $model = new Gudang();
    $this->log_activity('User melakukan Penambahan Data Kamar');

    // Ambil data dari form dan hapus "RP" serta titik pemisah ribuan
    $a = $this->request->getPost('lantai');
    $b = $this->request->getPost('kamar');
    $c = str_replace(['RP', '.'], '', $this->request->getPost('hb')); // Menghapus RP dan titik
    $d = str_replace(['RP', '.'], '', $this->request->getPost('ht')); // Menghapus RP dan titik
    $e = $this->request->getPost('deskripsi_kamar');
    $f = $this->request->getPost('status_kamar');
    
    // Proses upload file
    $file = $this->request->getFile('foto_kamar');
    $logoName = $file->getRandomName();
    $file->move('images/img', $logoName); // Folder tempat menyimpan file
    
    $isi = array(
        'lantai' => $a,
        'no_kamar' => $b,
        'harga_per_bulan' => $c,
        'harga_per_tahun' => $d,
        'deskripsi_kamar' => $e,
        'status_kamar' => $f,
        'foto_kamar' => $logoName // Simpan nama file ke database
    );
    
    $model->tambah('tb_kamar', $isi);
    return redirect()->to('Home/kamar');
}

public function aksi_e_kamar()
{
    $model = new GUdang(); // Pastikan model ini sesuai dengan model Anda
    $this->log_activity('User melakukan Pengeditan Data Kamar');

    $id_kamar = $this->request->getPost('id_kamar');
    $lantai = $this->request->getPost('lantai');
    $no_kamar = $this->request->getPost('no_kamar');
    $harga_per_bulan = $this->request->getPost('harga_per_bulan');
    $harga_per_tahun = $this->request->getPost('harga_per_tahun');
    $deskripsi_kamar = $this->request->getPost('deskripsi_kamar');
    $status_kamar = $this->request->getPost('status_kamar');

    $file = $this->request->getFile('foto_kamar');
    $foto_kamar_name = '';

    if ($file->isValid() && !$file->hasMoved()) {
        $foto_kamar_name = $file->getRandomName();
        $file->move('images/img', $foto_kamar_name); // Folder tempat menyimpan file
    }

    $data = [
        'lantai' => $lantai,
        'no_kamar' => $no_kamar,
        'harga_per_bulan' => $harga_per_bulan,
        'harga_per_tahun' => $harga_per_tahun,
        'deskripsi_kamar' => $deskripsi_kamar,
        
        'status_kamar' => $status_kamar
    ];
 
    if ($foto_kamar_name) {
        $data['foto_kamar'] = $foto_kamar_name; // Simpan nama file jika ada
    }

    $where = ['id_kamar' => $id_kamar];
    $model->edit('tb_kamar', $data, $where);

    return redirect()->to('Home/kamar');
}
public function hapus_kamar($id){
    $model = new Gudang();
    $this->log_activity('User melakukan Penghapusan Data Kamar');
    $where = array('id_kamar'=>$id);
    $model->hapus('tb_kamar',$where);
    
    return redirect()->to('Home/kamar');
}
public function penghuni()
{
    if (session()->get('id_level') > 0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where);
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting', $where);
        $data['penghuni'] = $model->tampil('tb_penghuni');
        $this->log_activity('User membuka daftar penghuni');
        echo view('header', $data);
        echo view('menu', $data);
        echo view('penghuni', $data); // Kirim data ke view
        echo view('footer');
    } else {
        return redirect()->to('Home/login');
    }
}
    public function aksi_e_penghuni()
    {
        $model = new Gudang();
        $this->log_activity('User melakukan Pengeditan Data Penghuni');
        $no_kamar = $this->request->getPost('no_kamar');
        $nama = $this->request->getPost('nama');
        $no_ktp = $this->request->getPost('no_ktp');
        $asal = $this->request->getPost('asal');
        $no_hp = $this->request->getPost('no_hp');
        $tgl_msk = $this->request->getPost('tgl_msk');
        $tgl_klr = $this->request->getPost('tgl_klr');
        $total_bayar = $this->request->getPost('total_bayar');
        $total_sudah_bayar = $this->request->getPost('total_sudah_bayar');
        $piutang = $this->request->getPost('piutang');
        $id_penghuni = $this->request->getPost('id_penghuni');
        
        $where = array('id_penghuni'=>$id_penghuni);

        $isi = array(

            'no_kamar' => $no_kamar,
            'nama' => $nama,
            'no_ktp' => $no_ktp,
            'asal' => $asal,
            'no_hp' => $no_hp,
            'tgl_msk' => $tgl_msk,
            'tgl_klr' => $tgl_klr,
            'total_bayar' => $total_bayar,
            'total_sudah_bayar' => $total_sudah_bayar,
            'piutang' => $piutang
        );

        // Update data di database
        $model->edit('tb_penghuni', $isi, $where);
        //  print_r($isi);
        return redirect()->to('Home/penghuni');

    }
public function hapus_penghuni($id)
{
    $model = new Gudang();
    $this->log_activity('User melakukan Penghapusan Data penghuni');
    
    // Ambil data penghuni untuk mendapatkan no_kamar
    $penghuni = $model->getWhere('tb_penghuni', ['id_penghuni' => $id]);
    
    // Pastikan data ditemukan
    if ($penghuni) {
        // Ambil no_kamar
        $no_kamar = $penghuni->no_kamar;

        // Hapus data dari tb_penghuni
        $where = array('id_penghuni' => $id);
        $model->hapus('tb_penghuni', $where);

        // Update status_kamar di tb_kamar menjadi 'Belum Berpenghuni'
        $dataUpdate = array(
            'status_kamar' => 'Belum Berpenghuni'
        );

        $whereUpdate = array(
            'no_kamar' => $no_kamar
        );

        // Menggunakan metode updateRecord untuk mengupdate status_kamar
        $model->updateRecord('tb_kamar', $dataUpdate, $whereUpdate);
    }
    
    return redirect()->to('Home/penghuni');
}

        public function t_penghuni($id)
    {
        if (session()->get('id_level')>0) {
        $model = new Gudang();
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 

        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);

        $this->log_activity('User membuka Form Sewa Kamar');

         $where = array('id_kamar' => $id);
        $data['kamar'] = $model->getWhere('tb_kamar',$where);
        
        echo view ('header',$data);
        echo view('menu',$data);
        echo view('t_penghuni');
        echo view('footer');
    }else{
        return redirect()->to('Home/login');
    }
    }

public function aksi_t_penghuni()
{
    $model = new Gudang();
    $this->log_activity('User melakukan pengisian form sewa kamar');
    
    // Ambil data dari form
    $kamar = $this->request->getPost('nokamar');
    $a = $this->request->getPost('nl');
    $b = $this->request->getPost('ktp');
    $c = $this->request->getPost('aa');
    $d = $this->request->getPost('no');
    // Set tgl_msk otomatis menjadi hari ini
    $e = date('Y-m-d'); // Format YYYY-MM-DD
    $f = $this->request->getPost('tgla');
    $g = $this->request->getPost('hidden_bayar');
     $h = $this->request->getPost('tsb');
      $i = $this->request->getPost('pu');
    $isi = array(
        'no_kamar' => $kamar,
        'nama' => $a,
        'no_ktp' => $b,
        'asal' => $c,
        'no_hp' => $d,
        'tgl_msk' => $e, // Menggunakan tanggal hari ini
        'tgl_klr' => $f,
        'total_bayar' => $g,
        'total_sudah_bayar' => $h,
        'piutang' => $i 
    );
    
    // Simpan data penyewa ke tb_penghuni
    $model->tambah('tb_penghuni', $isi);
    
    // Update status_kamar di tb_kamar
    $dataUpdate = array(
        'status_kamar' => 'Sudah Berpenghuni'
    );
    
    $whereUpdate = array(
        'no_kamar' => $kamar
    );

    $model->updateKamar($dataUpdate, $whereUpdate);

    return redirect()->to('Home/penghuni');
}
 public function pembayaran()
    {
        // if (session()->get('id_level')>0) {
            if(session()->get('id_level') == '1'){
        $model = new Gudang();
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka view User');
       
        $where=array('id_user'=>session()->get('id_user'));
        $data['pembayaran']=$model->tampil('tb_pembayaran');
        echo view('header',$data);
        echo view('menu',$data);
        echo view('pembayaran',$data);
        echo view('footer');
    
        }else{
            return redirect()->to('Home/error404');
        }
    }
public function aksi_e_pembayaran()
{
    $model = new Gudang(); // Model yang digunakan untuk mengakses database
    $this->log_activity('User melakukan Pengeditan Data Pembayaran');

    // Ambil data dari form (POST request)
    $id_pembayaran = $this->request->getPost('id_pembayaran');

    $no_kamar = $this->request->getPost('no_kamar');
    $nama = $this->request->getPost('nama');
    $tanggal_transaksi = $this->request->getPost('tanggal_transaksi');
    $jumlah_bayar = $this->request->getPost('jumlah_bayar');
    $total_bayar = $this->request->getPost('total_bayar');
    $keterangan = $this->request->getPost('keterangan');

    // Tentukan kondisi untuk mencari data berdasarkan id_pembayaran
    $where = array('id_pembayaran' => $id_pembayaran);

    // Siapkan data yang akan diupdate
    $isi = array(

        'no_kamar' => $no_kamar,
        'nama' => $nama,
        'tanggal_transaksi' => $tanggal_transaksi,
        
        'total_bayar' => $total_bayar,
        'jumlah_bayar' => $jumlah_bayar,
        'keterangan' => $keterangan,
    );

    // Update data pembayaran di tabel tb_pembayaran
    $model->edit('tb_pembayaran', $isi, $where);

    // Redirect kembali ke halaman pembayaran setelah edit
    return redirect()->to('Home/pembayaran');
}
        public function t_pembayaran($id)
    {
        if (session()->get('id_level')>0) {
        $model = new Gudang();
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 

        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);

        $this->log_activity('User membuka Form Pembayaran');

         $where = array('id_penghuni' => $id);
        $data['join'] = $model->getWhere('tb_penghuni',$where);
        
        echo view ('header',$data);
        echo view('menu',$data);
        echo view('t_pembayaran');
        echo view('footer');
    }else{
        return redirect()->to('Home/login');
    }
    }
    public function aksi_t_pembayaran()
{
    $model = new Gudang();
    $this->log_activity('User melakukan pembayaran sewa kamar');
    
    // Ambil data dari form
    $kamar = $this->request->getPost('nokamar');
    $nama = $this->request->getPost('nl');
    // $ktp = $this->request->getPost('nktp');
    $a = $this->request->getPost('total_bayar');
    $b = str_replace(['RP', '.'], '', $this->request->getPost('nb')); // Menghapus RP dan titik
    $c = date('Y-m-d'); // Format YYYY-MM-DD
    $d = $this->request->getPost('kt');

    $isi = array(
        'no_kamar' => $kamar,
        'nama' => $nama,
        // 'no_ktp' => $ktp,
        'total_bayar' => $a,
        'jumlah_bayar' => $b,
        'tanggal_transaksi' => $c, // Menggunakan tanggal hari ini
        'keterangan' => $d
    );
    
    // Simpan data penyewa ke tb_penghuni
    $model->tambah('tb_pembayaran', $isi);
    return redirect()->to('Home/pembayaran');
}
public function hapus_pembayaran($id){
    $model = new Gudang();
    $this->log_activity('User melakukan Penghapusan Data pembayaran');
    $where = array('id_pembayaran'=>$id);
    $model->hapus('tb_pembayaran',$where);
    
    return redirect()->to('Home/pembayaran');
}

    public function dokumen()
    {
        if (session()->get('id_level')>0) {
        $model=new Gudang;
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka halaman dokumen');
         $data['dokumen']=$model->tampil('tb_dokumen');
        echo view('header',$data);
        echo view('menu',$data);
        echo view('dokumen',$data);
        echo view('footer');
        // print_r($data);
    }else{
        return redirect()->to('Home/login');
    }
    }
    public function aksi_edit_dokumen()
{
    $model = new Gudang();
    $this->log_activity('User melakukan Pengeditan Data Dokumen');
    
    $id_dokumen = $this->request->getPost('id_dokumen');
    $judul_dokumen = $this->request->getPost('judul_dokumen');
    $kategori_dokumen = $this->request->getPost('kategori_dokumen');
    $tanggal_dokumen = $this->request->getPost('tanggal_dokumen');
    $deskripsi = $this->request->getPost('deskripsi');
    $status_dokumen = $this->request->getPost('status_dokumen');

    $where = array('id_dokumen' => $id_dokumen);
    $data = array(
        'judul_dokumen' => $judul_dokumen,
        'kategori_dokumen' => $kategori_dokumen,
        'tanggal_dokumen' => $tanggal_dokumen,
        'deskripsi' => $deskripsi,
        'status_dokumen' => $status_dokumen
    );

    $model->edit('tb_dokumen', $data, $where);
    return redirect()->to('Home/dokumen');
}
        public function t_dokumen()
    {
        if (session()->get('id_level')>0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka form tambah dokumen');
        
        echo view ('header',$data);
        echo view('menu',$data);
        echo view('t_dokumen');
        echo view('footer');
    }else{
        return redirect()->to('Home/login');
    }
    }

public function aksi_t_dokumen()
{
    $model = new Gudang();
    $this->log_activity('User melakukan penambahan dokumen');
    
    // Ambil data dari form
    
    $a = $this->request->getPost('jd');
    $b = $this->request->getPost('kd');
    $c = date('Y-m-d'); // Format YYYY-MM-DD
    $d = $this->request->getPost('st');
    $e = $this->request->getPost('deskripsi');

    $isi = array(
       
        'judul_dokumen' => $a,
        'kategori_dokumen' => $b,
        'tanggal_dokumen' => $c,
        'status_dokumen' => $d,
        'deskripsi' => $e

    );
    
    // Simpan data penyewa ke tb_penghuni
    $model->tambah('tb_dokumen', $isi);
    return redirect()->to('Home/dokumen');
}
public function hapus_dokumen($id){
    $model = new Gudang();
    $this->log_activity('User melakukan Penghapusan Data Dokumen');
    $where = array('id_dokumen'=>$id);
    $model->hapus('tb_dokumen',$where);
    
    return redirect()->to('Home/dokumen');
}
    public function buku()
    {
        if (session()->get('id_level')>0) {
        $model=new Gudang;
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka halaman buku');
        $data['kategori'] = $model->tampil('tb_kategoribuku');
         $data['buku'] = $model->join('tb_buku', 'tb_kategoribuku',
            'tb_buku.id_kategori = tb_kategoribuku.id_kategori',$where);
        echo view('header',$data);
        echo view('menu',$data);
        echo view('buku',$data);
        echo view('footer');
        // print_r($data);
    }else{
        return redirect()->to('Home/login');
    }
    }
        public function aksi_e_buku()
{
    $model = new Gudang();
    $this->log_activity('User melakukan Pengeditan Data Buku');
    
    $a = $this->request->getPost('id_buku');
    $kategori = $this->request->getPost('kategori');
    $b = $this->request->getPost('judul');
    $c = $this->request->getPost('penulis');
    $d = $this->request->getPost('penerbit');
    $e = $this->request->getPost('tahunterbit');
    

    $where = array('id_buku' => $a);
    $data = array(
        'id_kategori' => $kategori,
        'judul' => $b,
        'penulis' => $c,
        'penerbit' => $d,
        'tahunterbit' => $e
        
    );

    $model->edit('tb_buku', $data, $where);
    return redirect()->to('Home/buku');
}
public function t_buku()
{
    if (session()->get('id_level') > 0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where);
        
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting', $where);
        
        // Ambil semua data kategori buku
        $data['kategori'] = $model->tampil('tb_kategoribuku'); // Mengambil data kategori

        $this->log_activity('User membuka form tambah buku');
        
        echo view('header', $data);
        echo view('menu', $data);
        echo view('t_buku', $data);  // Pastikan $data['kategori'] diteruskan ke view
        echo view('footer');
    } else {
        return redirect()->to('Home/login');
    }
}

public function aksi_t_buku()
{
    $model = new Gudang(); // Sesuaikan dengan model yang digunakan
    $this->log_activity('User melakukan penambahan buku');
    
    // Ambil data dari form
    $kategori = $this->request->getPost('kategori');
    $judul = $this->request->getPost('judul');
    $penulis = $this->request->getPost('penulis');
    $penerbit = $this->request->getPost('penerbit');
    $tahun_terbit = $this->request->getPost('tahun_terbit');
    

    $data = array(
        'id_kategori' => $kategori,
        'judul' => $judul,
        'penulis' => $penulis,
        'penerbit' => $penerbit,
        'tahunterbit' => $tahun_terbit
        
    );
    
    // Simpan data buku ke tabel tb_buku
    $model->tambah('tb_buku', $data);
    return redirect()->to('Home/buku');
}
public function hapus_buku($id){
    $model = new Gudang();
    $this->log_activity('User melakukan Penghapusan Data Buku');
    $where = array('id_buku'=>$id);
    $model->hapus('tb_buku',$where);
    
    return redirect()->to('Home/buku');
}
    public function kategori()
    {
        if (session()->get('id_level')>0) {
        $model=new Gudang;
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka halaman kategori');
         $data['kategori']=$model->tampil('tb_kategoribuku');
        echo view('header',$data);
        echo view('menu',$data);
        echo view('kategori',$data);
        echo view('footer');
        // print_r($data);
    }else{
        return redirect()->to('Home/login');
    }
    }
    public function aksi_e_kategori()
{
    $model = new Gudang();
    $this->log_activity('User melakukan Pengeditan Kategori');
    
    $a = $this->request->getPost('id_kategori');
    $b = $this->request->getPost('nama_kategori');


    $where = array('id_kategori' => $a);
    $data = array(
        'nama_kategori' => $b

        
    );

    $model->edit('tb_kategoribuku', $data, $where);
    return redirect()->to('Home/kategori');
}
        public function t_kategori()
    {
        if (session()->get('id_level')>0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka form tambah kategori');
        
        echo view ('header',$data);
        echo view('menu',$data);
        echo view('t_kategori');
        echo view('footer');
    }else{
        return redirect()->to('Home/login');
    }
    }
public function aksi_t_kategori()
{
    $model = new Gudang(); // Sesuaikan dengan model yang digunakan
    $this->log_activity('User Melakukan Penambahan Kategori');
    
    // Ambil data dari form
    $a = $this->request->getPost('nk');

    

    $data = array(
        'nama_kategori' => $a
        
    );
    
    // Simpan data buku ke tabel tb_buku
    $model->tambah('tb_kategoribuku', $data);
    return redirect()->to('Home/kategori');
}
public function hapus_kategori($id){
    $model = new Gudang();
    $this->log_activity('User melakukan Penghapusan Data Kategori');
    $where = array('id_kategori'=>$id);
    $model->hapus('tb_kategoribuku',$where);
    
    return redirect()->to('Home/kategori');
}
    public function ulasan()
    {
        if (session()->get('id_level')>0) {
        $model=new Gudang;
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka Halaman Ulasan');
        $data['ulasan'] = $model->joinThreeTables('tb_ulasanbuku', 'tb_buku', 'tb_user', 
        'tb_ulasanbuku.id_buku = tb_buku.id_buku', 'tb_ulasanbuku.id_user = tb_user.id_user',$where);
        $data['buku'] = $model->tampil('tb_buku');
        echo view('header',$data);
        echo view('menu',$data);
        echo view('ulasan',$data);
        echo view('footer');
        // print_r($data);
    }else{
        return redirect()->to('Home/login');
    }
    }
public function aksi_e_ulasan()
{
    $model = new Gudang();  // Gantilah dengan model yang sesuai dengan nama model ulasan Anda
    $this->log_activity('User melakukan Pengeditan Ulasan Buku');
    
    $id_ulasan = $this->request->getPost('id_ulasan');
    $judul = $this->request->getPost('judul');  // Mendapatkan id ulasan yang diposting
    $ulasan = $this->request->getPost('ulasan');  // Mendapatkan teks ulasan yang diposting
    $rating = $this->request->getPost('rating');  // Mendapatkan rating yang dipilih dari dropdown

    $where = array('id_ulasan' => $id_ulasan);  // Menentukan kondisi untuk mencari ulasan yang akan diedit
    $data = array(
        'id_buku' => $judul,
        'ulasan' => $ulasan,  // Menyimpan data ulasan yang baru
        'rating' => $rating   // Menyimpan data rating yang baru
    );

    // Mengedit data di tabel ulasan
    $model->edit('tb_ulasanbuku', $data, $where);  // Gantilah dengan nama tabel ulasan yang sesuai

    // Mengarahkan pengguna kembali ke halaman ulasan setelah berhasil
    return redirect()->to('Home/ulasan');  // Sesuaikan dengan rute yang benar
}
        public function t_ulasan()
    {
        if (session()->get('id_level')>0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka form tambah ulasan');
         $data['buku'] = $model->tampil('tb_buku');
        
        echo view ('header',$data);
        echo view('menu',$data);
        echo view('t_ulasan');
        echo view('footer');
    }else{
        return redirect()->to('Home/login');
    }
    }
public function aksi_t_ulasan()
{
    $model = new Gudang(); // Sesuaikan dengan model yang digunakan
    $this->log_activity('User Melakukan Penambahan ulasan');
    
    // Ambil data dari form
    $user = $this->request->getPost('id_user');
    $buku = $this->request->getPost('judul_buku');
    $a = $this->request->getPost('ulasan');
    $b = $this->request->getPost('rating');


    

    $data = array(
        'id_user' => $user,
        'id_buku' => $buku,
        'ulasan' => $a,
        'rating' => $b
        
    );
    
    // Simpan data buku ke tabel tb_buku
    $model->tambah('tb_ulasanbuku', $data);
    return redirect()->to('Home/ulasan');
}
public function hapus_ulasan($id){
    $model = new Gudang();
    $this->log_activity('User melakukan Penghapusan Data Buku');
    $where = array('id_ulasan'=>$id);
    $model->hapus('tb_ulasanbuku',$where);
    
    return redirect()->to('Home/ulasan');
}
    public function peminjaman()
    {
        if (session()->get('id_level')>0) {
        $model=new Gudang;
                  $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka halaman peminjaman buku');
        $data['peminjaman'] = $model->joinThreeTables('tb_peminjaman', 'tb_buku', 'tb_user', 
        'tb_peminjaman.id_buku = tb_buku.id_buku', 'tb_peminjaman.id_user = tb_user.id_user',$where);
        $data['buku'] = $model->tampil('tb_buku');
        $data['users'] = $model->tampil('tb_user');
        echo view('header',$data);
        echo view('menu',$data);
        echo view('peminjaman',$data);
        echo view('footer');
        // print_r($data);
    }else{
        return redirect()->to('Home/login');
    }
    }
    public function aksi_e_peminjaman()
{
    $model = new Gudang();  // Sesuaikan dengan model yang benar untuk tabel peminjaman
    $this->log_activity('User melakukan Pengeditan Peminjaman Buku');

    $id_peminjaman = $this->request->getPost('id_peminjaman');
      // Mendapatkan ID pengguna yang diposting
    $id_buku = $this->request->getPost('id_buku');  // Mendapatkan ID buku yang diposting
    $tanggalpeminjaman = $this->request->getPost('tanggalpeminjaman');  // Mendapatkan tanggal peminjaman
    $tanggalpengembalian = $this->request->getPost('tanggalpengembalian');  // Mendapatkan tanggal pengembalian
    $statuspeminjaman = $this->request->getPost('statuspeminjaman');  // Mendapatkan status peminjaman

    $where = array('id_peminjaman' => $id_peminjaman);  // Menentukan kondisi untuk mencari peminjaman yang akan diedit
    $data = array(
        
        'id_buku' => $id_buku,
        'tanggalpeminjaman' => $tanggalpeminjaman,
        'tanggalpengembalian' => $tanggalpengembalian,
        'statuspeminjaman' => $statuspeminjaman
    );

    // Mengedit data di tabel peminjaman
    $model->edit('tb_peminjaman', $data, $where);  // Sesuaikan dengan nama tabel yang benar

    // Mengarahkan pengguna kembali ke halaman peminjaman setelah berhasil
    return redirect()->to('Home/peminjaman');  // Sesuaikan dengan rute yang benar
}
        public function t_peminjaman()
    {
        if (session()->get('id_level')>0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka form peminjaman buku');
        $data['buku'] = $model->tampil('tb_buku');
        

        echo view ('header',$data);
        echo view('menu',$data);
        echo view('t_peminjaman');
        echo view('footer');
    }else{
        return redirect()->to('Home/login');
    }
    }
public function aksi_t_peminjaman()
{
    $model = new Gudang(); // Gantilah dengan model yang sesuai
    $this->log_activity('User Melakukan Penambahan Peminjaman Buku');

    // Ambil data dari form
    $id_user = $this->request->getPost('id_user');
    $id_buku = $this->request->getPost('id_buku');
    $tanggal_peminjaman = $this->request->getPost('tanggalpeminjaman');
    $tanggal_pengembalian = $this->request->getPost('tanggalpengembalian');
    $status_peminjaman = $this->request->getPost('statuspeminjaman');

    $data = array(
        'id_user' => $id_user,
        'id_buku' => $id_buku,
        'tanggalpeminjaman' => $tanggal_peminjaman,
        'tanggalpengembalian' => $tanggal_pengembalian,
        'statuspeminjaman' => $status_peminjaman
    );

    // Simpan data peminjaman ke tabel tb_peminjaman
    $model->tambah('tb_peminjaman', $data);
    
    // Redirect ke halaman daftar peminjaman
    return redirect()->to('Home/peminjaman');
}
public function hapus_peminjaman($id){
    $model = new Gudang();
    $this->log_activity('User melakukan Penghapusan Data peminjaman');
    $where = array('id_peminjaman'=>$id);
    $model->hapus('tb_peminjaman',$where);
    
    return redirect()->to('Home/peminjaman');
}
    public function koleksi()
    {
        if (session()->get('id_level')>0) {
        $model=new Gudang;
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka halaman koleksi');
        $data['koleksi']=$model->tampil('tb_koleksipribadi');

        echo view('header',$data);
        echo view('menu',$data);
        echo view('koleksi',$data);
        echo view('footer');
        // print_r($data);
    }else{
        return redirect()->to('Home/login');
    }
    }
 public function laporan()
    {
        // if (session()->get('id_level')>0) {
            if(session()->get('id_level') == '1'){
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka view laporan');
        $data['history']=$model->tampil('tb_history');
        echo view('header',$data);
        echo view('menu',$data);
        echo view('laporan',$data);
        echo view('footer');
    
        }else{
            return redirect()->to('Home/error404');
        }
    }
                public function t_koleksi($id)
    {
        if (session()->get('id_level')>0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User melakukan penambahan koleksi');

                 $where = array('id_kategori' => $id);
        $data['kategori'] = $model->getWhere('tb_kategoribuku',$where);

         $whereBuku = array('id_kategori' => $id);  // Filter berdasarkan id_kategori yang sama
        $data['buku'] = $model->getWhere('tb_buku', $whereBuku);  // Ambil
        

        echo view ('header',$data);
        echo view('menu',$data);
        echo view('t_koleksi');
        echo view('footer');
    }else{
        return redirect()->to('Home/login');
    }
    }
    public function aksi_t_koleksi()
{
    $model = new Gudang(); // Sesuaikan dengan model yang digunakan
    $this->log_activity('User Melakukan Penambahan koleksi');
    
    // Ambil data dari form
    $id_kategori = $this->request->getPost('nk');
    $b = $this->request->getPost('jd');
    $c = $this->request->getPost('pn');
    $d = $this->request->getPost('pt');
    $e = $this->request->getPost('ter');
    

    

    $data = array(
        
        'id_kategori' => $id_kategori,
        'judul' => $b,
        'penulis' => $c,
        'penerbit' => $d,
        'tahunterbit' => $e
        
        
    );
    
    // Simpan data buku ke tabel tb_buku
    $model->tambah('tb_koleksipribadi', $data);
    return redirect()->to('Home/koleksi');
}
    public function hapus_koleksi($id){
    $model = new Gudang();
    $this->log_activity('User melakukan Penghapusan Data koleksi');
    $where = array('id_koleksi'=>$id);
    $model->hapus('tb_koleksipribadi',$where);
    
    return redirect()->to('Home/koleksi');
}

public function siswa()
{
    if (session()->get('id_level') > 0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where);
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting', $where);
        
        $this->log_activity('User membuka daftar siswa');
        echo view('header', $data);
        echo view('menu', $data);
        echo view('siswa', $data); // Kirim data ke view
        echo view('footer');
    } else {
        return redirect()->to('Home/login');
    }
}

public function kirim_wa()
{
    $tujuan = $this->request->getPost('tujuan');
    $model = new Gudang();
    
    // Filter user berdasarkan tujuan
    $where = ($tujuan === 'all') ? [] : ['tujuan' => $tujuan];
    $pengumuman = $model->tampil('tb_pengumuman', $where);
    
    foreach ($pengumuman as $p) {
        // Dapatkan user berdasarkan id_user dan id_level 5 (Siswa)
        $user = $model->getWhere('tb_user', ['id_user' => $p->id_user, 'id_level' => 5]); 
        
        // Pastikan ada nomor WhatsApp
        if ($user && $user->no_wa) {
            $this->sendWhatsApp($user->no_wa, $p->isi);
        }
    }
    
    return $this->response->setJSON(['message' => 'Pesan WhatsApp berhasil dikirim']);
}
    

private function sendWhatsApp($phone, $message)
{
    // Gunakan API WhatsApp (contoh: Twilio atau API lain)
    $api_url = "https://api.whatsapp.com/send";
    $params = [
        'phone' => $phone,
        'text' => $message,
    ];
    $url = $api_url . '?' . http_build_query($params);
    return redirect()->to($url);
}

public function kirim_email()
{
    $tujuan = $this->request->getPost('tujuan');
    $model = new Gudang();
    
    // Filter user berdasarkan tujuan
    $where = ($tujuan === 'all') ? [] : ['tujuan' => $tujuan];
    $pengumuman = $model->tampil('tb_pengumuman', $where);
    
    foreach ($pengumuman as $p) {
        // Dapatkan user berdasarkan id_user
        $user = $model->getWhere('tb_user', ['id_user' => $p->id_user, 'id_level' => 5]); // Pastikan id_level = 5 (Siswa)
        
        // Pastikan ada email
        if ($user && $user->email) {
            $this->sendEmail($user->email, $p->judul, $p->isi);
        }
    }
    
    return $this->response->setJSON(['message' => 'Email berhasil dikirim']);
}


private function sendEmail($to, $subject, $message)
{
    $email = \Config\Services::email();
    $email->setFrom('admin@yourapp.com', 'Admin');
    $email->setTo($to);
    $email->setSubject($subject);
    $email->setMessage($message);
    return $email->send();
}



 public function pengumuman()
    {
        // if (session()->get('id_level')>0) {
           if (session()->get('id_level')>0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $data['pengumuman'] = $model->join('tb_pengumuman', 'tb_user',
            'tb_pengumuman.id_user = tb_user.id_user',$where);
        $this->log_activity('User membuka view pengumuman');
        echo view('header',$data);
        echo view('menu',$data);
        echo view('pengumuman',$data);
        echo view('footer');
    
        }else{
            return redirect()->to('Home/login');
        }
    }
    public function aksi_e_pengumuman()
{
    $model = new Gudang();
    $this->log_activity('User melakukan Pengeditan Data Pengumuman');
    
    $id_pengumuman = $this->request->getPost('id_pengumuman');
    $judul = $this->request->getPost('judul');
    $isi = $this->request->getPost('isi');
    $tujuan = $this->request->getPost('tujuan');
    

    $where = array('id_pengumuman' => $id_pengumuman);
    $data = array(
        'judul' => $judul,
        'isi' => $isi,
        'tujuan' => $tujuan
       
       
    );

    $model->edit('tb_pengumuman', $data, $where);
    return redirect()->to('Home/pengumuman');
}
        public function t_pengumuman()
    {
        if (session()->get('id_level')>0) {
        $model = new Gudang();
                  $where = array('id_user' => session()->get('id_user'));
         $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka Form Penambahan Data pengumuman');
       
        echo view ('header',$data);
        echo view('menu',$data);
        echo view('t_pengumuman');
        echo view('footer');
    }else{
        return redirect()->to('Home/login');
    }
    }
    public function aksi_t_pengumuman()
{
    $model = new Gudang(); // Sesuaikan dengan model yang digunakan
    $this->log_activity('User Melakukan Penambahan Pengumuman');
    
    // Ambil data dari form
    $id_user = $this->request->getPost('id_user');
    $judul = $this->request->getPost('judul');
    $isi = $this->request->getPost('isi');
    $tujuan = $this->request->getPost('tujuan');

    $data = array(
        'id_user' => $id_user,
        'judul' => $judul,
        'isi' => $isi,
        'tujuan' => $tujuan,
        'created_at' => date('Y-m-d H:i:s')
    );
    
    // Simpan data ke tabel tb_pengumuman
    $model->tambah('tb_pengumuman', $data);
    return redirect()->to('Home/pengumuman');
}
public function hapus_pengumuman($id){
    $model = new Gudang();
    $this->log_activity('User melakukan Penghapusan Data Pengumuman');
    $where = array('id_pengumuman'=>$id);
    $model->hapus('tb_pengumuman',$where);
    
    return redirect()->to('Home/pengumuman');
}

            public function kelas()
    {
        if (session()->get('id_level')>0) {
        $model=new Gudang;
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka halaman kelas');
       $data['kelas']=$model->tampil('tb_kelas');

        echo view('header',$data);
        echo view('menu',$data);
        echo view('kelas',$data);
        echo view('footer');
        // print_r($data);
    }else{
        return redirect()->to('Home/login');
    }
    }
    public function aksi_edit_kelas()
{
    $model = new Gudang(); // Pastikan nama model sesuai dengan nama file model Anda.
    $this->log_activity('User melakukan Pengeditan Data Kelas');

    // Mengambil data dari form input
    $id_kelas = $this->request->getPost('id_kelas');
    $nama_kelas = $this->request->getPost('nama_kelas');
   

    // Menentukan kondisi untuk pembaruan data
    $where = array('id_kelas' => $id_kelas);

    // Membuat array data untuk diperbarui
    $data = array(
        'nama_kelas' => $nama_kelas
        
         // Tambahkan waktu update jika perlu
    );

    // Memanggil fungsi edit untuk mengupdate data pada tabel tb_kelas
    $model->edit('tb_kelas', $data, $where);

    // Redirect kembali ke halaman view kelas setelah pengeditan
    return redirect()->to('Home/kelas');
}
    public function t_kelas()
    {
        if (session()->get('id_level')>0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka form tambah kelas');
        
        echo view ('header',$data);
        echo view('menu',$data);
        echo view('t_kelas');
        echo view('footer');
    }else{
        return redirect()->to('Home/login');
    }
    }
        public function aksi_t_kelas()
{
    // Load model
   $model = new Gudang();
    $this->log_activity('User melakukan Penambahan Data kelas');
    
    // Get form data
    $nama_kelas = $this->request->getPost('nk');
    

    // Prepare data to insert
    
    $isi = array(
        'nama_kelas' => $nama_kelas
       
       
    );
    
    // Insert data into 'tb_acara' table
    $model->tambah('tb_kelas', $isi);

    // Redirect to acara list page after success
    return redirect()->to('Home/kelas');
}
    public function hapus_kelas($id){
    $model = new Gudang();
    $this->log_activity('User melakukan Penghapusan Data Kelas');
    $where = array('id_kelas'=>$id);
    $model->hapus('tb_kelas',$where);
    
    return redirect()->to('Home/kelas');
}
public function restore_edit_acara()
{
    if (session()->get('id_level') > 0) {
        $model = new Gudang();
        
        // Ambil data pengguna
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getWhere('tb_user', $where); 
        
        // Ambil pengaturan
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting', $where);
        
        // Ambil data acara
        $acara = $model->tampil('tb_acara');
        
        // Periksa apakah ada acara yang statusnya perlu diubah ke Selesai
        foreach ($acara as $event) {
            // Jika tanggal acara sudah lewat dan statusnya masih "Aktif"
            if (strtotime($event->tanggal_acara) <= time() && $event->status !== 'Selesai') {
                // Update status acara menjadi 'Selesai'
                $model->edit('tb_acara', ['status' => 'Selesai'], ['id_acara' => $event->id_acara]);
            }
        }

        // Pindahkan data yang statusnya selesai ke tb_history
        foreach ($acara as $event) {
            if ($event->status === 'Selesai') {
                // Persiapkan data untuk tb_history
                $dataHistory = [
                    'nama_acara'    => $event->nama_acara,
                    'tanggal_acara' => $event->tanggal_acara,
                    'create_at'    => $event->create_at,
                    'update_at'    => $event->update_at,
                    'status'        => $event->status
                ];

                // Pindahkan ke tb_history
                $model->tambah('tb_history', $dataHistory);

                // Hapus dari tb_acara
                $model->hapus('tb_acara', ['id_acara' => $event->id_acara]);
            }
        }
        
        // Ambil ulang data acara yang aktif
        $data['acara'] = $model->tampil('tb_acara');

        $this->log_activity('User membuka view restore edit acara');
        echo view('header', $data);
        echo view('menu', $data);
        echo view('restore_edit_acara', $data);
        echo view('footer');
    } else {
        return redirect()->to('Home/login');
    }
}
    public function aksi_edit_acara()
{
    $model = new Gudang();
    $this->log_activity('User melakukan Pengeditan Data Acara');
    
    $id_acara = $this->request->getPost('id_acara');
    $nama_acara = $this->request->getPost('nama_acara');
    $tanggal_acara = $this->request->getPost('tanggal_acara');
    $status = $this->request->getPost('status');


    $where = array('id_acara' => $id_acara);
    $data = array(
        'nama_acara' => $nama_acara,
        'tanggal_acara' => $tanggal_acara,
        'status' => $status,
        'update_at' => date('Y-m-d H:i:s')
    );

    $model->edit('tb_acara', $data, $where);
    return redirect()->to('Home/acara');
}
        public function t_acara()
    {
        if (session()->get('id_level')>0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $this->log_activity('User membuka form tambah acara');
        
        echo view ('header',$data);
        echo view('menu',$data);
        echo view('t_acara');
        echo view('footer');
    }else{
        return redirect()->to('Home/login');
    }
    }
    public function aksi_t_acara()
{
    // Load model
   $model = new Gudang();
    $this->log_activity('User melakukan Penambahan Data Acara');
    
    // Get form data
    $nama_acara = $this->request->getPost('nama_acara');
    $tanggal_acara = $this->request->getPost('tanggal_acara');
    $tanggalhariini = $this->request->getPost('tanggal');
    $status = $this->request->getPost('status');
    // Prepare data to insert
    date_default_timezone_set('Asia/Jakarta');
    $isi = array(
        'nama_acara' => $nama_acara,
        'tanggalharini' => $tanggalhariini,
        'tanggal_acara' => $tanggal_acara,
        'status' => $status,
        'create_at' => date('Y-m-d H:i:s'),  // Set current datetime for create_at
        'update_at' => date('Y-m-d H:i:s')   // Set current datetime for update_at
    );
    
    // Insert data into 'tb_acara' table
    $model->tambah('tb_acara', $isi);

    // Redirect to acara list page after success
    return redirect()->to('Home/acara');
}
    public function hapus_acara($id){
    $model = new Gudang();
    
    $where = array('id_acara'=>$id);
    $model->hapus('tb_acara',$where);
    $this->log_activity('User melakukan Penghapusan data acara');
    
    return redirect()->to('Home/acara');
}
    public function hapus_history($id){
    $model = new Gudang();
    
    $where = array('id_history'=>$id);
    $model->hapus('tb_history',$where);
    $this->log_activity('User melakukan Penghapusan data history');
    
    return redirect()->to('Home/history');
}
public function dashboard()
{
    if (session()->get('id_level') > 0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where);
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting', $where);

        $this->log_activity('User membuka Dashboard');
        echo view('header', $data);
        echo view('menu', $data);
        echo view('dashboard', $data); // Kirim data ke view
        echo view('footer');

    } else {
        return redirect()->to('Home/login');
    }
}



 public function history()
    {
        // if (session()->get('id_level')>0) {
           if (session()->get('id_level')>0) {
        $model = new Gudang();
        $where = array('id_user' => session()->get('id_user'));
        $data['dennis'] = $model->getwhere('tb_user', $where); 
        $where = array('id_setting' => 1);
        $data['setting'] = $model->getWhere('tb_setting',$where);
        $data['history']=$model->tampil('tb_history');
        $this->log_activity('User membuka view history');
        echo view('header',$data);
        echo view('menu',$data);
        echo view('history',$data);
        echo view('footer');
    
        }else{
            return redirect()->to('Home/login');
        }
    }
        public function aksi_edit_history()
{
    $model = new Gudang();
    $this->log_activity('User melakukan Pengeditan Data history');
    
    $id_history = $this->request->getPost('id_history');
    $nama_acara = $this->request->getPost('nama_acara');
    $tanggal_acara = $this->request->getPost('tanggal_acara');
    $status = $this->request->getPost('status');

    $where = array('id_history' => $id_history);
    $data = array(
        'nama_acara' => $nama_acara,
        'tanggal_acara' => $tanggal_acara,
        'status' => $status,
        'update_at' => date('Y-m-d H:i:s')
    );

    $model->edit('tb_history', $data, $where);
    return redirect()->to('Home/history');
}
}
