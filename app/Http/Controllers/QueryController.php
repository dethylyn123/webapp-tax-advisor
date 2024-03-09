<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    public function statistics()
    {
        $results1 = DB::select("SELECT
        SUM(CASE WHEN land_classification_name = 'Residential' THEN 1 ELSE 0 END) AS Residential,
        SUM(CASE WHEN land_classification_name = 'Agricultural' THEN 1 ELSE 0 END) AS Agricultural,
        SUM(CASE WHEN land_classification_name = 'Commercial' THEN 1 ELSE 0 END) AS Commercial,
        SUM(CASE WHEN land_classification_name = 'Industrial' THEN 1 ELSE 0 END) AS Industrial,
        SUM(CASE WHEN land_classification_name = 'Mineral' THEN 1 ELSE 0 END) AS Mineral,
        SUM(CASE WHEN land_classification_name = 'Timberland' THEN 1 ELSE 0 END) AS Timberland
        FROM land_classification;");

        return response()->json([$results1]);
    }

    public function statisticsOwners()
    {
        $results1 = DB::select("SELECT
        COUNT(property_owner_name) AS total_property_owner,
        COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN property_owner_name END) AS property_owner_today,
        COUNT(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) THEN property_owner_name END) AS property_owner_this_month,
        COUNT(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) THEN property_owner_name END) AS property_owner_this_year,
        (
            COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN property_owner_name END) -
            COUNT(CASE WHEN DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) THEN property_owner_name END)
        ) AS daily_change,
        (
            (COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN property_owner_name END) -
            COUNT(CASE WHEN DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) THEN property_owner_name END)) /
            COUNT(CASE WHEN DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) THEN property_owner_name END) * 100
        ) AS daily_change_percentage,
        (
            COUNT(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) THEN property_owner_name END) -
            COUNT(CASE WHEN YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(created_at) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN property_owner_name END)
        ) AS monthly_change,
        (
            (COUNT(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) THEN property_owner_name END) -
            COUNT(CASE WHEN YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(created_at) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN property_owner_name END)) /
            COUNT(CASE WHEN YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND MONTH(created_at) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN property_owner_name END) * 100
        ) AS monthly_change_percentage,
        (
            COUNT(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) THEN property_owner_name END) -
            COUNT(CASE WHEN YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) THEN property_owner_name END)
        ) AS yearly_change,
        (
            (COUNT(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) THEN property_owner_name END) -
            COUNT(CASE WHEN YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) THEN property_owner_name END)) /
            COUNT(CASE WHEN YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) THEN property_owner_name END) * 100
        ) AS yearly_change_percentage
    FROM property_owners;
    ");
    
        // SELECT
        // COUNT(property_owner_name) AS total_property_owner,
        // COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN property_owner_name END) AS property_owner_today,
        // COUNT(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) THEN property_owner_name END) AS property_owner_this_month,
        // COUNT(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) THEN property_owner_name END) AS property_owner_this_year,
        // (
        //     COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN property_owner_name END) -
        //     COUNT(CASE WHEN DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) THEN property_owner_name END)
        // ) AS daily_change,
        // (
        //     (COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN property_owner_name END) -
        //     COUNT(CASE WHEN DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) THEN property_owner_name END)) /
        //     COUNT(CASE WHEN DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) THEN property_owner_name END) * 100
        // ) AS daily_change_percentage
        // FROM property_owners;

        return response()->json([$results1]);
    }
}
