<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Request as RequestModel;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chart = $this->chart();
        return view('dashboard.index', compact('chart'));
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

    function chart()
    {
        $labels = ['Menunggu Persetujuan', 'Disetujui', 'Ditolak'];
        $datasets = [
            RequestModel::where('status', 'waiting')->count(),
            RequestModel::where('status', 'approved')->count(),
            RequestModel::where('status', 'rejected')->count()
        ];
        
        return [
            'labels' => $labels,
            'datasets' => $datasets
        ];     
    }
}
