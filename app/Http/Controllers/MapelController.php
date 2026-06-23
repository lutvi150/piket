<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreMapelRequest;
use App\Http\Requests\UpdateMapelRequest;
use App\Models\Mapel;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Mata Pelajaran";
        $mapel = Mapel::all();
        return view('mapel.index', compact("mapel", "title"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMapelRequest $request)
    {
        $data  = $request->validated();
        $mapel = Mapel::create($data);
        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil disimpan.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mapel $mapel)
    {
        $data = Mapel::find($mapel->id);
        if ($data) {
            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil ditemukan.',
                'data'    => $data,
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan.',
                'data'    => null,
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mapel $mapel)
    {
        $data = Mapel::find($mapel->id);
        if ($data) {
            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil ditemukan.',
                'data'    => $data,
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan.',
                'data'    => null,
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMapelRequest $request, Mapel $mapel)
    {
        $data = $request->validated();
        $mapel->update($data);
        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil diperbarui.',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mapel $mapelModel)
    {
        try {
            if (! $mapelModel->delete()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data gagal dihapus.',
                    'data'=>$mapelModel
                ], 400);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Data mata pelajaran berhasil dihapus.',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menghapus data mata pelajaran.',
                'error'   => $th->getMessage(),
            ], 500);
        }
    }
}
