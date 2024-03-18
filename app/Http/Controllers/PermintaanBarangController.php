<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Department;
use App\Models\RequestItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PermintaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(RequestItem::all())
                ->make(true);
        }
        $department = Department::all();
        $barang = Barang::where('stok', '>', 0)->get();
        return view('admin.pages.permintaan.index', compact('department', 'barang'));
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
    public function store(Request $request)
    {
        $input = $request->all();

        $data = Validator::make($input, [
            'nik' => ['required'],
            'name' => ['required'],
            'department' => ['required'],
            'date_request' => ['required'],
            'details.*.id_barang' => ['required'],
            'details.*.qty' => ['required'],
            'details.*.satuan' => ['required'],
            'details.*.stok' => ['required'],
            'details.*.lokasi' => ['required'],
            'details.*.barang' => ['required'],
        ])->validate();

        try {
            DB::beginTransaction();
            $request_item = RequestItem::create($data);
            foreach ($data['details'] as $detail) {
                $barang = Barang::find($detail['id_barang']);
                $barang->update(['stok' => $barang->stok - $detail['qty']]);
                $request_item->requestItemDetails()->create($detail);
            }
            DB::commit();
            return $this->sendResponse($request_item, 201, 'Data Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendResponse(null, 400, $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = RequestItem::with('requestItemDetails')->find($id);
        return view('admin.pages.permintaan.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = RequestItem::find($id);
        $data->requestItemDetails()->delete();
        $data->delete();
        return redirect()->route('permintaan.index')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
