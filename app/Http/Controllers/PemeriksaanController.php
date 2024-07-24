<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class PemeriksaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pemeriksaan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function diagnosa($id)
    {
        $pasien = DB::table('kunjungan as k')
            ->leftjoin('pasien as p', 'k.id_pasien', '=', 'p.id')
            ->leftjoin('poli as po', 'k.id_poli', '=', 'po.id')
            ->leftjoin('pasien_tp as tipe', 'k.id_pasien_tp', '=', 'tipe.id')
            ->leftjoin('gender as g', 'p.id_gender', '=', 'g.id')
            ->leftjoin('pekerjaan as job', 'p.id_pekerjaan', '=', 'job.id')
            ->leftjoin('pendidikan as edu', 'p.id_pendidikan', '=', 'edu.id')
            ->select(
                'k.id as id_kunjungan',
                'p.id as id_pasien',
                'k.tgl_daftar',
                'p.no_rm as pasien_no_rm',
                'p.nama as pasien_nm',
                'g.detail_gender as jk',
                'p.tgl_lahir as tgl_lahir',
                'p.usia',
                'p.alamat',
                'p.no_telp',
                'job.nama as job'
            )
            ->where('k.id', $id)->first();
        return view('pemeriksaan.diagnosa', compact('pasien'));
        //dd($pasien);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function tblPemeriksaan()
    {
        //list daftar
        $model = DB::table('kunjungan')
            ->join('pasien', 'kunjungan.id_pasien', '=', 'pasien.id')
            ->join('poli', 'kunjungan.id_poli', '=', 'poli.id')
            ->join('pasien_tp', 'kunjungan.id_pasien_tp', '=', 'pasien_tp.id')
            ->join('status_proses', 'kunjungan.id_status', '=', 'status_proses.id')
            ->select(
                'kunjungan.id',
                'kunjungan.tgl_daftar',
                'pasien.nama as nama',
                'pasien.no_rm',
                'poli.nama as poli',
                'pasien_tp.nama as tipe',
                'status_proses.nama as status'
            )
            ->orderby('kunjungan.tgl_daftar', 'DESC')
            ->orderby('kunjungan.created_at', 'DESC');

        return DataTables::of($model)
            ->addColumn('action', function ($model) {
                return view('pemeriksaan.action', [
                    'model' => $model,
                    'url_periksa' => route('diagnosa.show', $model->id),
                    'url_edit' => route('diagnosa.edit', $model->id),
                    'url_destroy' => route('diagnosa.destroy', $model->id)
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
}
