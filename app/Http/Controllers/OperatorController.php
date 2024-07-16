<?php

namespace App\Http\Controllers;

use App\Models\DosenWali;
use App\Models\Mahasiswa;
use App\Models\OperatorProdi;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;


class OperatorController extends Controller
{
    public function getAuthenticatedOperator()
    {
        $user = Auth::id();
        $operator = OperatorProdi::where('user_id', $user)->first();

        if (!$operator) {
            return response()->json([
                'message' => 'Operator tidak ditemukan',
            ], 404);
        }
        return response()->json([
            'operator' => $operator,
        ]);
    }
    public function tambahMahasiswa(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas,nim',
            'angkatan' => 'required',
            'role' => 'required',
            'status' => 'required|in:Aktif,Cuti,DO,Lulus',
            'jalurMasuk' => 'required|in:SNBP,SNBT,Mandiri,SBUB',
            'password' => 'required',
            'dosenwali_nip' => 'required|exists:dosenwalis,nip',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Menggunakan transaksi database
        DB::beginTransaction();

        try {
            // Membuat user baru
            $user = User::create([
                'username' => $request->nim,
                'password' => Hash::make($request->password), // Mengenkripsi password
                'role' => 'Mahasiswa', // Menetapkan role sebagai mahasiswa
            ]);

            // Membuat mahasiswa baru
            $mahasiswa = Mahasiswa::create([
                'nim' => $request->nim, // Menggunakan username sebagai NIM
                'user_id' => $user->id,
                'nama' => $request->nama,
                'angkatan' => $request->angkatan,
                'status' => $request->status,
                'jalurMasuk' => $request->jalurMasuk,
                'dosenwali_nip' => $request->dosenwali_nip,
            ]);

            // Commit transaksi
            DB::commit();

            // Mengirim respons sukses
            return response()->json([
                'message' => 'Mahasiswa berhasil ditambahkan',
                'user' => $user,
                'mahasiswa' => $mahasiswa,
            ], 201);

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            return response()->json(['error' => 'Terjadi kesalahan saat menambahkan mahasiswa'], 500);
        }
    }

    public function import(Request $request)
    {
        Excel::import(new UserImport(), $request->file('input_excel'));

        return redirect()->route('register.user')->with('success', 'Akun Mahasiswa Berhasil Ditambahkan.');
    }

    public function count()
    {
        //status
        $userActiveCount = Mahasiswa::query()
            ->where('status', '=', 'Aktif')
            ->count();
        $userLulusCount = Mahasiswa::query()
            ->where('status', '=', 'Lulus')
            ->count();
        $userDropoutCount = Mahasiswa::query()
            ->where('status', '=', 'DO')
            ->count();
        $userCuticount = Mahasiswa::query()
            ->where('status', '=', 'Cuti')
            ->count();

        //Role
        $operatorCount = User::query()
            ->where('role', '=', 'Operator Prodi')
            ->count();
        $dosenCount = User::query()
            ->where('Role', '=', 'Dosen Wali')
            ->count();
        $mahasiswaCount = User::query()
            ->where('Role', '=', 'Mahasiswa')
            ->count();
        $departmentCount = User::query()
            ->where('Role', '=', 'Departemen')
            ->count();
        $userCount = User::query()
            ->count();

        return response()->json([
            'jumlahMhsAktif' => $userActiveCount,
            'jumlahMhsLulus' => $userLulusCount,
            'jumlahMhsDropout' => $userDropoutCount,
            'jumlahMhsCuti' => $userCuticount,
            'jumlahOperatorProdi' => $operatorCount,
            'jumlahDosenWali' => $dosenCount,
            'jumlahMahasiswa' => $mahasiswaCount,
            'jumlahDepartemen' => $departmentCount,
            'jumlahUser' => $userCount,
        ]);
    }

    // public function dataMHS(Request $request)
    // {
    //     if ($request->has('search')) {
    //         $mahasiswa = DB::table('mahasiswas')
    //             ->where(function ($query) use ($request) {
    //                 $query->where('nama', 'LIKE', '%' . $request->search . '%')
    //                     ->orWhere('nim', 'LIKE', '%' . $request->search . '%');
    //             })
    //             ->paginate(10);
    //     } else {
    //         $mahasiswa = DB::table('mahasiswas')
    //             ->paginate(10);
    //     }
    //     return view('operator.dataMHSoperator', compact('mahasiswa'));
    // }
}