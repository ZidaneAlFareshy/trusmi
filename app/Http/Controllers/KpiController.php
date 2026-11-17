<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class KpiController extends Controller
{
    public function index()
    {
        $kpiKaryawan = DB::select("
            SELECT 
                karyawan AS nama,
                2 AS target_sales,
                SUM(CASE WHEN kpi = 'Sales' THEN 1 ELSE 0 END) AS actual_sales,
                ROUND((SUM(CASE WHEN kpi = 'Sales' THEN 1 ELSE 0 END) / 2) * 100) AS pencapaian_sales,
                ROUND(((SUM(CASE WHEN kpi = 'Sales' THEN 1 ELSE 0 END) / 2) * 50)) AS bobot_sales,
                CASE WHEN SUM(CASE WHEN kpi = 'Sales' AND aktual > deadline THEN 1 ELSE 0 END) > 0 THEN -7 ELSE 0 END AS late_sales,
                ROUND(((SUM(CASE WHEN kpi = 'Sales' THEN 1 ELSE 0 END) / 2) * 50)) + 
                    (CASE WHEN SUM(CASE WHEN kpi = 'Sales' AND aktual > deadline THEN 1 ELSE 0 END) > 0 THEN -7 ELSE 0 END) AS total_bobot_sales,

                2 AS target_report,
                SUM(CASE WHEN kpi = 'Report' THEN 1 ELSE 0 END) AS actual_report,
                ROUND((SUM(CASE WHEN kpi = 'Report' THEN 1 ELSE 0 END) / 2) * 100) AS pencapaian_report,
                ROUND(((SUM(CASE WHEN kpi = 'Report' THEN 1 ELSE 0 END) / 2) * 50)) AS actual_bobot_report,
                CASE WHEN SUM(CASE WHEN kpi = 'Report' AND aktual > deadline THEN 1 ELSE 0 END) > 0 THEN -5 ELSE 0 END AS late_report,
                ROUND(((SUM(CASE WHEN kpi = 'Report' THEN 1 ELSE 0 END) / 2) * 50)) + 
                    (CASE WHEN SUM(CASE WHEN kpi = 'Report' AND aktual > deadline THEN 1 ELSE 0 END) > 0 THEN -5 ELSE 0 END) AS total_bobot_report,

                ROUND(((SUM(CASE WHEN kpi = 'Sales' THEN 1 ELSE 0 END) / 2) * 50)) + 
                    (CASE WHEN SUM(CASE WHEN kpi = 'Sales' AND aktual > deadline THEN 1 ELSE 0 END) > 0 THEN -7 ELSE 0 END) +
                    ROUND(((SUM(CASE WHEN kpi = 'Report' THEN 1 ELSE 0 END) / 2) * 50)) + 
                    (CASE WHEN SUM(CASE WHEN kpi = 'Report' AND aktual > deadline THEN 1 ELSE 0 END) > 0 THEN -5 ELSE 0 END) AS kpi_akhir
            FROM table_kpi_marketing
            GROUP BY karyawan
            ORDER BY MIN(id)
        ");
        
        $statusLeadtime = DB::select("
            SELECT 
                CASE WHEN aktual <= deadline THEN 'Ontime' ELSE 'Late' END AS status,
                COUNT(*) AS jumlah,
                ROUND((COUNT(*) / (SELECT COUNT(*) FROM table_kpi_marketing)) * 100, 2) AS persentase
            FROM table_kpi_marketing
            GROUP BY status
        ");

        return view('dashboard', compact('kpiKaryawan', 'statusLeadtime'));
    }
}