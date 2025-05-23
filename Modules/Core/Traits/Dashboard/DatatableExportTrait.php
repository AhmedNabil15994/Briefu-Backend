<?php
namespace Modules\Core\Traits\Dashboard;

use Illuminate\Http\Request;
use Modules\Core\Traits\DataTable;
use PDF;
use Modules\Core\Exports\ExportExcel;
use Maatwebsite\Excel\Facades\Excel;

trait DatatableExportTrait
{
    use ControllerSetterAndGetter;
    //repository methods

    private $QueryActionsCols;
    protected $exportFileName = 'file';
    /**
     * @param array $data
     */
    public function setQueryActionsCols(array $data = ['id' => 'id'])
    {
        $this->QueryActionsCols = $data;
    }

    /**
     * @return mixed
     */
    public function getQueryActionsCols()
    {
        return $this->QueryActionsCols;
    }

    // Generate PDF
    public function createPDF($request,$data, $type = 'pdf')
    {
        $cols = $this->getQueryActionsCols();
        $title = $request->title;
        $search_title = '';

        if($request->req && count($request->req)){
            $counter = count($request->req);
            foreach($request->req as $key => $value){
                if($value){
                    $key = __("report::dashboard.reports.datatable.{$key}");
                    $search_title .= "<strong>{$key}:</strong> {$value} ";
                    $search_title .= $counter > 1 ? ',' : '';
                }
            }
        }

        $date_rangers = isset($request['req']['from']) && $request['req']['from'] ? $request['req']['from'] : '';
        $date_rangers .= isset($request['req']['to']) && isset($request['req']['from']) && $request['req']['from'] && $request['req']['to'] ? ' - ' : '';
        $date_rangers .= isset($request['req']['to']) && $request['req']['from'] ? $request['req']['to'] : '';
        
        $pdf = PDF::loadView('core::dashboard.query-action.print', compact('cols', 'data','title','request','date_rangers','search_title'), [], [
            'default_font' => 'cairo',
            'title' => $title,
            'format' => 'A4-L',
            'margin_footer' => 5,
            'watermark' => $title,
            'orientation' => 'L'
        ]);

        // download PDF file with download method

        switch ($type) {
            case 'print':
                return $pdf->stream($title. '.pdf');
                break;
            default:
                return $pdf->download($title. '.pdf');
        }
    }

    // Generate Excel
    public function exportExcel($request,$data, $resource)
    {
        $title = $request->title;
        $cols = $this->getQueryActionsCols();

        return Excel::download(new ExportExcel($data,$cols,$resource),$title .'.xlsx');
    }

    // controller methods



    private function getData(Request $request, $type = "data_table")
    {
        if ($type == 'data_table') {
            $datatable = DataTable::drawTable($request, $this->repository->QueryTable($request));
            $resource = $this->model_resource;
        } elseif ($type == 'export') {
            $datatable = DataTable::drawPrint($request, $this->repository->QueryTable($request));
            $resource = $this->export_resource;
        }


        $datatable['data'] = $resource::collection($datatable['data']);

        return Response()->json($datatable);
    }


    public function datatable(Request $request)
    {
        return $this->getData($request);
    }

    public function export(Request $request, $type)
    {
        $data = json_decode($request->data);
        $req = $data->req;
        $request->merge(['req' => (array)$req]);
        
        switch ($type) {
            case 'pdf':
            case 'print':
                $data = $this->getData($request, 'export');
                return $this->repository->createPDF($request,$data->getData()->data, $type);
                break;
            case 'excel':
                return $this->repository->exportExcel($request,$this->repository->QueryTable($request) , $this->export_resource);
                break;
            default:
                return back();
        }
    }
}
