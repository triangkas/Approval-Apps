<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Request as RequestModel;
use App\Models\RequestFile;
use App\Models\ApprovalHistory;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->pathFile = "/uploads/files/";
        $tempDir = $this->pathFile;
        $pathDir = public_path($tempDir);
        if(!file_exists($pathDir)){
            mkdir($pathDir, 0755, true);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('request.index');
    }

    /**
     * Display a JSON data for the resource.
     */
    public function dataJson(Request $request)
    {
        $query = RequestModel::query();

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('status', function ($row) { 
                if($row->status == 'waiting'){
                    if($row->approval_level == '0'){
                        return '<span class="badge badge-warning">Menunggu Persetujuan</span>';
                    } else {
                        return '<span class="badge badge-info">Disetujui oleh ' . $row->level->user->name . '</span>';
                    }
                } elseif($row->status == 'approved'){
                    return '<span class="badge badge-success">Disetujui oleh semua pihak</span>';
                } elseif($row->status == 'rejected'){
                    return '<span class="badge badge-danger">Ditolak</span>';
                } else {
                    return '<span class="badge badge-secondary">Draft</span>';
                }
            })
            ->editColumn('budget', fn($row) => number_format($row->budget, 0, ',', '.'))
            ->editColumn('sent_at', fn($row) => $row->sent_at ? date('d/m/Y H:i', strtotime($row->sent_at)) : '-')
            ->rawColumns(['status'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('request.edit', [
            '_action' => 'Tambah',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'budget' => ['required'],
            'description' => ['required'],
            'files' => ['required', 'array', 'min:3'],
        ], [], [
            'title' => 'judul',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'budget' => 'budget',
            'description' => 'keterangan',
            'files' => 'dokumen',
        ]);   

        $statusInfo = $request->action == 'send' ? 'dikirim' : 'disimpan sebagai draft';

        try {
            $data = new RequestModel();
            $data->title = $request->title;
            $data->latitude = $request->latitude;
            $data->longitude = $request->longitude;
            $data->budget = str_replace(['.', ','], ['', '.'], $request->budget);
            $data->description = $request->description;
            $data->status = $request->action == 'send' ? 'waiting' : 'draft';
            $data->sent_at = $request->action == 'send' ? now() : null;
            $data->user_id = auth()->id();
            $data->save();

            if($request->hasFile('files')){
                foreach($request->file('files') as $file){
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path($this->pathFile), $fileName);

                    $dataFile = new RequestFile();
                    $dataFile->request_id = $data->id;
                    $dataFile->file_path = $fileName;
                    $dataFile->save();
                }
            }
            
            Alert::success('Data berhasil ' . $statusInfo);
            return redirect()->route('request.index');
        } catch (\Exception $e) {
            Alert::error('Data gagal ' . $statusInfo, $e->getMessage());
            return redirect()->back()->withInput();
        }  
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $detail = RequestModel::findOrFail($id);
        $files = RequestFile::where('request_id', $id)->get();
        return response()->json(view('request.show', [
            'urlFile' => env('APP_URL').$this->pathFile,
            'detail' => $detail,
            'files' => $files,
            'histories' => ApprovalHistory::where('request_id', $id)->orderBy('created_at', 'desc')->get(),
        ])->render());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $detail = RequestModel::where('approval_level', 0)->findOrFail($id);
        $files = RequestFile::where('request_id', $id)->get();
        return view('request.edit', [
            '_action' => 'Edit',
            'dataForm' => $detail,
            'files' => $files,
            'pathFile' => $this->pathFile,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'budget' => ['required'],
            'description' => ['required'],
            'files' => ['array'],
            'stand_files' => ['array'],
        ], [
            'files.array' => 'Total dokumen minimal harus 3',
            'stand_files.array' => 'Total dokumen minimal harus 3',
        ],[
            'title' => 'judul',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'budget' => 'budget',
            'description' => 'keterangan',
            'files' => 'dokumen',
        ]);

        $totalFiles = (count($request->file('files') ?? []) + count($request->stand_files ?? []));
        if($totalFiles < 3) {
            return back()->withErrors(['files' => 'Total dokumen minimal harus 3'])->withInput();
        } 

        $statusInfo = $request->action == 'send' ? 'dikirim' : 'disimpan sebagai draft';

        try {
            $data = RequestModel::findOrFail($id);
            $data->title = $request->title;
            $data->latitude = $request->latitude;
            $data->longitude = $request->longitude;
            $data->budget = str_replace(['.', ','], ['', '.'], $request->budget);
            $data->description = $request->description;
            $data->status = $request->action == 'send' ? 'waiting' : 'draft';
            $data->sent_at = $request->action == 'send' ? now() : null;
            $data->user_id = auth()->id();
            $data->save();

            // handle delete file
            $existingFiles = RequestFile::where('request_id', $id)->pluck('id')->toArray();
            $standFiles = $request->stand_files ?? [];
            $filesToDelete = array_diff($existingFiles, $standFiles);
            if(!empty($filesToDelete)){
                RequestFile::whereIn('id', $filesToDelete)->delete();
            } else {
                if(!empty($request->stand_files)){
                    RequestFile::whereNotIn('id', $request->stand_files)->delete();
                }
            }

            // handle new file
            if($request->hasFile('files')){
                foreach($request->file('files') as $file){
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path($this->pathFile), $fileName);  

                    $dataFile = new RequestFile();
                    $dataFile->request_id = $data->id;
                    $dataFile->file_path = $fileName;
                    $dataFile->save();
                }
            }

            Alert::success('Data berhasil ' . $statusInfo);
            return redirect()->route('request.index');
        } catch (\Exception $e) {
            Alert::error('Data gagal ' . $statusInfo, $e->getMessage());
            return redirect()->back()->withInput();
        }  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = RequestModel::findOrFail($id);
            $data->delete();

            Alert::success('Data berhasil dihapus');
            return redirect()->route('request.index');
        } catch (\Exception $e) {
            Alert::error('Data gagal dihapus', $e->getMessage());
            return redirect()->back()->withInput();
        }    
    }
}
