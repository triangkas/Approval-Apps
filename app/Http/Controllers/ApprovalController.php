<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Request as RequestModel;
use App\Models\RequestFile;
use App\Models\ApprovalStep;
use App\Models\ApprovalHistory;

class ApprovalController extends Controller
{
    public function __construct()
    {
        $this->pathFile = "/uploads/files/";
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('approval.index');
    }

    /**
     * Display a JSON data for the resource.
     */
    public function dataJson(Request $request)
    {
        $query = RequestModel::where('status', '!=', 'draft');

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $detail = RequestModel::findOrFail($id);
        
        // cek untuk proses approval
        $actApproval = 'passed';
        if($detail->status == 'waiting'){
            $actApproval = 'not_yet';
            if(auth()->user()->level[0]->level == (int) $detail->approval_level + 1) {
                $actApproval = 'already';
            }elseif(auth()->user()->level[0]->level <= (int) $detail->approval_level) {
                $actApproval = 'passed';
            }
        }
        
        return view('approval.show', [
            '_action' => 'Detail Pengajuan',
            'detail' => $detail,
            'files' => RequestFile::where('request_id', $id)->get(),
            'urlFile' => env('APP_URL').$this->pathFile,
            'histories' => ApprovalHistory::where('request_id', $id)->orderBy('created_at', 'desc')->get(),
            'actApproval' => $actApproval,
        ]);
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
        //
    }

    /**
     * Update status the specified resource in storage.
     */
    public function status(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required',
            'comment' => 'required_if:status,rejected|string|nullable',
        ],[],[
            'status' => 'status',
            'comment' => 'catatan',
        ]);

        try {
            $data = new ApprovalHistory();
            $data->request_id = $id;
            $data->user_id = auth()->id();
            $data->status = $request->status;
            $data->comment = $request->comment;
            $data->save();

            $requestModel = RequestModel::findOrFail($id);
            $requestModel->approval_level = auth()->user()->level[0]->level;
            if($request->status == 'approved') {
                // cek level tertinggi
                $maxLevel = ApprovalStep::max('level');
                if($requestModel->approval_level >= $maxLevel) {
                    $requestModel->status = 'approved';
                } else {
                    $requestModel->status = 'waiting';
                }
            } elseif($request->status == 'rejected') {
                $requestModel->status = 'rejected';
            }
            $requestModel->save();

            Alert::success('Data berhasil disimpan');
            return redirect()->route('approval.index');
        } catch (\Exception $e) {
            Alert::error('Data gagal disimpan', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
