<?php

namespace App\Http\Controllers;

use App\Exports\ReportUsedExport;
use App\Http\Requests\ReportWithDateRequest;
use App\Services\ReportService;
use Vtiful\Kernel\Excel;
use function view;

class ReportController extends Controller
{
    
    protected $service;
    
    public function __construct(ReportService $service)
    {
        $this->service = $service;
        
    }
    
    public function index()
    {
        $info = $this->service->index();
        return view("report.index", ["info"=>$info]);
        
    }
    
    public function report()
    {
        $chart = $this->service->reportChart();
        $mostProduced = $this->service->mostProduced();
        $mostUsedFragrance = $this->service->mostUsedFragrance();
        $chart_used = $this->service->mostUsedFragranceChart();
        return view("report.report", [
            "chart"=>$chart, 
            "mostProduced"=>$mostProduced,
            "mostUsedFragrance"=>$mostUsedFragrance,
            "chart_used"=>$chart_used,
            "date" => ["start"=>'', "end"=>'']
        ]);
        
    }
    
    public function reportWithDate(ReportWithDateRequest $request)
    {
        
        $chart = $this->service->reportChart($request->all());
        $mostUsedFragranceChart = $this->service->mostUsedFragranceChart($request->all());
        $mostProduced = $this->service->mostProduced($request->all());
        $mostUsedFragrance = $this->service->mostUsedFragrance($request->all());
        return view("report.report", [
            "chart"=>$chart, 
            "mostProduced"=>$mostProduced,
            "mostUsedFragrance"=>$mostUsedFragrance,
            "mostUsedFragranceChart"=>$mostUsedFragranceChart,
            "date" =>$request->all()
        ]);
        
    }
    
    public function exportMostUsedFragrances()
    {
        return Excel::download(new ReportUsedExport(), 'fragrancias_mais_usadas.xlsx');   
    }
}
