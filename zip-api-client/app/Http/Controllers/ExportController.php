<?php

namespace App\Http\Controllers;

use App\Services\ZipApiService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    protected ZipApiService $zipApi;

    public function __construct(ZipApiService $zipApi)
    {
        $this->zipApi = $zipApi;
    }

    /**
     * Export counties to CSV
     */
    public function countiesCSV()
    {
        try {
            $counties = $this->zipApi->getCounties();

            $filename = 'counties-' . date('Y-m-d-His') . '.csv';

            $headers = [
                "Content-type" => "text/csv; charset=UTF-8",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];

            $callback = function () use ($counties) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Name']);

                foreach ($counties as $county) {
                    fputcsv($file, [$county['id'], $county['name']]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Export counties to PDF
     */
    public function countiesPDF()
    {
        try {
            $counties = $this->zipApi->getCounties();

            $pdf = Pdf::loadView('exports.counties-pdf', [
                'counties' => $counties,
                'title' => 'Counties List',
                'date' => date('Y-m-d H:i:s')
            ]);

            return $pdf->download('counties-' . date('Y-m-d-His') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Export cities in a county to CSV
     */
    public function citiesCSV(int $countyId)
    {
        try {
            $counties = $this->zipApi->getCounties();
            $county = collect($counties)->firstWhere('id', $countyId);

            if (!$county) {
                return redirect()->back()->withErrors(['error' => 'County not found']);
            }

            $cities = $this->zipApi->getCities($countyId);

            $filename = 'cities-' . $county['name'] . '-' . date('Y-m-d-His') . '.csv';

            $headers = [
                "Content-type" => "text/csv; charset=UTF-8",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];

            $callback = function () use ($cities) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Name', 'Zip Code', 'County']);

                foreach ($cities as $city) {
                    fputcsv($file, [
                        $city['id'],
                        $city['name'],
                        $city['zip'],
                        $city['county']
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Export cities in a county to PDF
     */
    public function citiesPDF(int $countyId)
    {
        try {
            $counties = $this->zipApi->getCounties();
            $county = collect($counties)->firstWhere('id', $countyId);

            if (!$county) {
                return redirect()->back()->withErrors(['error' => 'County not found']);
            }

            $cities = $this->zipApi->getCities($countyId);

            $pdf = Pdf::loadView('exports.cities-pdf', [
                'county' => $county,
                'cities' => $cities,
                'title' => 'Cities in ' . $county['name'],
                'date' => date('Y-m-d H:i:s')
            ]);

            return $pdf->download('cities-' . $county['name'] . '-' . date('Y-m-d-His') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
