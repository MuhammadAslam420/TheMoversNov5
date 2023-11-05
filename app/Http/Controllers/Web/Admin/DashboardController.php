<?php

namespace App\Http\Controllers\Web\Admin;

use App\Base\Constants\Setting\Settings;
use App\Http\Controllers\Web\BaseController;
use App\Models\Admin\Driver;
use App\Models\Request\Request;
use App\Models\Request\RequestBill;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends BaseController
{

    public function dashboard()
    {

        if (!Session::get('applocale')) {
            Session::put('applocale', 'en');
        }

        // Session::put('applocale', 'en');

        $ownerId = null;
        if (auth()->user()->hasRole('owner')) {
            $ownerId = auth()->user()->owner->id;
        }

        $page = trans('pages_names.dashboard');
        $main_menu = 'dashboard';
        $sub_menu = null;

        $today = date('Y-m-d');

        $total_drivers = Driver::selectRaw('
                                        IFNULL(SUM(CASE WHEN approve=1 THEN 1 ELSE 0 END),0) AS approved,
                                        IFNULL((SUM(CASE WHEN approve=1 THEN 1 ELSE 0 END) / count(*)),0) * 100 AS approve_percentage,
                                        IFNULL((SUM(CASE WHEN approve=0 THEN 1 ELSE 0 END) / count(*)),0) * 100 AS decline_percentage,
                                        IFNULL(SUM(CASE WHEN approve=0 THEN 1 ELSE 0 END),0) AS declined,
                                        count(*) AS total
                                    ')
            ->whereHas('user', function ($query) {
                $query->companyKey();
            });

        if ($ownerId != null) {
            $total_drivers = $total_drivers->whereOwnerId($ownerId);
        } elseif (Auth::user()->hasRole('admin') === true) {
            $total_drivers = $total_drivers->where('zone_id', Auth::user()->admin->zone_id);
        }

        $total_drivers = $total_drivers->get();

        $total_users = User::belongsToRole('user')->companyKey()->count();

//trips
        if ($ownerId != null) {
            $trips = Request::companyKey()->selectRaw('
                    IFNULL(SUM(CASE WHEN is_completed=1 THEN 1 ELSE 0 END),0) AS today_completed,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 THEN 1 ELSE 0 END),0) AS today_cancelled,
                    IFNULL(SUM(CASE WHEN is_completed=0 AND is_cancelled=0 THEN 1 ELSE 0 END),0) AS today_scheduled,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) AS auto_cancelled,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) AS user_cancelled,
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0) AS driver_cancelled,
                    (IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) +
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) +
                    IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0)) AS total_cancelled
                ')
                ->whereDate('trip_start_time', $today)
                ->where('requests.owner_id', $ownerId)
                ->get();
        } elseif (auth()->user()->admin->user_id != 1) {
            $zoneDetailId = auth()->user()->admin->zoneDetail->id;
            $driverIds = Driver::where('zone_id', $zoneDetailId)->pluck('id');
            $trips = Request::companyKey()->selectRaw('
                IFNULL(SUM(CASE WHEN is_completed=1 THEN 1 ELSE 0 END),0) AS today_completed,
                IFNULL(SUM(CASE WHEN is_cancelled=1 THEN 1 ELSE 0 END),0) AS today_cancelled,
                IFNULL(SUM(CASE WHEN is_completed=0 AND is_cancelled=0 THEN 1 ELSE 0 END),0) AS today_scheduled,
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) AS auto_cancelled,
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) AS user_cancelled,
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0) AS driver_cancelled,
                (IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) +
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) +
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0)) AS total_cancelled
            ')->whereIn('driver_id', $driverIds)
                ->whereDate('trip_start_time', $today)
                ->get();
        } else {
            $trips = Request::companyKey()->selectRaw('
                IFNULL(SUM(CASE WHEN is_completed=1 THEN 1 ELSE 0 END),0) AS today_completed,
                IFNULL(SUM(CASE WHEN is_cancelled=1 THEN 1 ELSE 0 END),0) AS today_cancelled,
                IFNULL(SUM(CASE WHEN is_completed=0 AND is_cancelled=0 THEN 1 ELSE 0 END),0) AS today_scheduled,
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) AS auto_cancelled,
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) AS user_cancelled,
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0) AS driver_cancelled,
                (IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=0 THEN 1 ELSE 0 END),0) +
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=1 THEN 1 ELSE 0 END),0) +
                IFNULL(SUM(CASE WHEN is_cancelled=1 AND cancel_method=2 THEN 1 ELSE 0 END),0)) AS total_cancelled
            ')
                ->whereDate('trip_start_time', $today)
                ->get();
        }
        $cardEarningsQuery = "IFNULL(SUM(IF(requests.payment_opt=0,request_bills.total_amount,0)),0)";
        $cashEarningsQuery = "IFNULL(SUM(IF(requests.payment_opt=1,request_bills.total_amount,0)),0)";
        $walletEarningsQuery = "IFNULL(SUM(IF(requests.payment_opt=2,request_bills.total_amount,0)),0)";
        $adminCommissionQuery = "IFNULL(SUM(request_bills.admin_commision_with_tax),0)";
        $driverCommissionQuery = "IFNULL(SUM(request_bills.driver_commision),0)";
        $totalEarningsQuery = "$cardEarningsQuery + $cashEarningsQuery + $walletEarningsQuery";

        // Today earnings
        if ($ownerId != null) {
            $todayEarnings = Request::leftJoin('request_bills', 'requests.id', 'request_bills.request_id')
                ->selectRaw("
                                        {$cardEarningsQuery} AS card,
                                        {$cashEarningsQuery} AS cash,
                                        {$walletEarningsQuery} AS wallet,
                                        {$totalEarningsQuery} AS total,
                                        {$adminCommissionQuery} as admin_commision,
                                        {$driverCommissionQuery} as driver_commision,
                                        IFNULL(({$cardEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS card_percentage,
                                        IFNULL(({$cashEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS cash_percentage,
                                        IFNULL(({$walletEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS wallet_percentage
                                    ")
                ->companyKey()
                ->where('requests.is_completed', true)
                ->where('requests.owner_id', $ownerId)
                ->whereDate('requests.trip_start_time', date('Y-m-d'))
                ->get();
        } elseif (auth()->user()->admin->user_id != 1) {
            $zoneDetailId = auth()->user()->admin->zoneDetail->id;
            $driverIds = Driver::where('zone_id', $zoneDetailId)->pluck('id');
            $todayEarnings = Request::leftJoin('request_bills', 'requests.id', 'request_bills.request_id')
                ->selectRaw("
                                    {$cardEarningsQuery} AS card,
                                    {$cashEarningsQuery} AS cash,
                                    {$walletEarningsQuery} AS wallet,
                                    {$totalEarningsQuery} AS total,
                                    {$adminCommissionQuery} as admin_commision,
                                    {$driverCommissionQuery} as driver_commision,
                                    IFNULL(({$cardEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS card_percentage,
                                    IFNULL(({$cashEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS cash_percentage,
                                    IFNULL(({$walletEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS wallet_percentage
                                ")
                ->companyKey()->whereIn('driver_id', $driverIds)
                ->where('requests.is_completed', true)
                ->whereDate('requests.trip_start_time', date('Y-m-d'))
                ->get();
        } else {
            $todayEarnings = Request::leftJoin('request_bills', 'requests.id', 'request_bills.request_id')
                ->selectRaw("
                                        {$cardEarningsQuery} AS card,
                                        {$cashEarningsQuery} AS cash,
                                        {$walletEarningsQuery} AS wallet,
                                        {$totalEarningsQuery} AS total,
                                        {$adminCommissionQuery} as admin_commision,
                                        {$driverCommissionQuery} as driver_commision,
                                        IFNULL(({$cardEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS card_percentage,
                                        IFNULL(({$cashEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS cash_percentage,
                                        IFNULL(({$walletEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS wallet_percentage
                                    ")
                ->companyKey()
                ->where('requests.is_completed', true)
                ->whereDate('requests.trip_start_time', date('Y-m-d'))
                ->get();
        }
        //Overall Earnings
        if (auth()->user()->admin->user_id == 1) {
            $overallEarnings = Request::leftJoin('request_bills', 'requests.id', 'request_bills.request_id')
                ->selectRaw("
            {$cardEarningsQuery} AS card,
            {$cashEarningsQuery} AS cash,
            {$walletEarningsQuery} AS wallet,
            {$totalEarningsQuery} AS total,
            {$adminCommissionQuery} as admin_commision,
            {$driverCommissionQuery} as driver_commision,
            IFNULL(({$cardEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS card_percentage,
            IFNULL(({$cashEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS cash_percentage,
            IFNULL(({$walletEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS wallet_percentage
        ")
                ->companyKey()
                ->where('requests.is_completed', true)
                ->get();
        } else {
            $zoneDetailId = auth()->user()->admin->zoneDetail->id;
            $driverIds = Driver::where('zone_id', $zoneDetailId)->pluck('id');
            $overallEarnings = Request::leftJoin('request_bills', 'requests.id', 'request_bills.request_id')
                ->selectRaw("
                {$cardEarningsQuery} AS card,
                {$cashEarningsQuery} AS cash,
                {$walletEarningsQuery} AS wallet,
                {$totalEarningsQuery} AS total,
                {$adminCommissionQuery} as admin_commision,
                {$driverCommissionQuery} as driver_commision,
                IFNULL(({$cardEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS card_percentage,
                IFNULL(({$cashEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS cash_percentage,
                IFNULL(({$walletEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS wallet_percentage
            ")
                ->companyKey()->whereIn('driver_id', $driverIds)
                ->where('requests.is_completed', true)
                ->get();
        }
        if ($ownerId != null) {
            $overallEarnings = Request::leftJoin('request_bills', 'requests.id', 'request_bills.request_id')
                ->selectRaw("
                                    {$cardEarningsQuery} AS card,
                                    {$cashEarningsQuery} AS cash,
                                    {$walletEarningsQuery} AS wallet,
                                    {$totalEarningsQuery} AS total,
                                    {$adminCommissionQuery} as admin_commision,
                                    {$driverCommissionQuery} as driver_commision,
                                    IFNULL(({$cardEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS card_percentage,
                                    IFNULL(({$cashEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS cash_percentage,
                                    IFNULL(({$walletEarningsQuery} / {$totalEarningsQuery}),0) * 100 AS wallet_percentage
                                ")
                ->companyKey()
                ->where('requests.is_completed', true)
                ->where('requests.owner_id', $ownerId)
                ->get();
        }
        //cancellation chart
        $startDate = Carbon::now()->startOfMonth()->subMonths(6);
        $endDate = Carbon::now();
        $data = [];
        if ($ownerId != null) {
            while ($startDate->lte($endDate)) {

                $from = Carbon::parse($startDate)->startOfMonth();
                $to = Carbon::parse($startDate)->endOfMonth();
                $shortName = $startDate->shortEnglishMonth;
                $monthName = $startDate->monthName;
                $data['cancel'][] = [
                    'y' => $shortName,
                    'a' => Request::companyKey()->whereBetween('created_at', [$from, $to])->where('cancel_method', '0')->whereIsCancelled(true)->whereOwnerId($ownerId)->count(),
                    'u' => Request::companyKey()->whereBetween('created_at', [$from, $to])->where('cancel_method', '1')->whereIsCancelled(true)->whereOwnerId($ownerId)->count(),
                    'd' => Request::companyKey()->whereBetween('created_at', [$from, $to])->where('cancel_method', '2')->whereIsCancelled(true)->whereOwnerId($ownerId)->count(),
                ];
                $data['earnings']['months'][] = $monthName;
                $data['earnings']['values'][] = RequestBill::whereHas('requestDetail', function ($query) use ($from, $to, $ownerId) {
                    $query->companyKey()->whereBetween('trip_start_time', [$from, $to])->whereIsCompleted(true)->where('owner_id', $ownerId);
                })->sum('total_amount');

                $startDate->addMonth();
            }

        } else {
            while ($startDate->lte($endDate)) {

                $from = Carbon::parse($startDate)->startOfMonth();
                $to = Carbon::parse($startDate)->endOfMonth();
                $shortName = $startDate->shortEnglishMonth;
                $monthName = $startDate->monthName;
                $data['cancel'][] = [
                    'y' => $shortName,
                    'a' => Request::companyKey()->whereBetween('created_at', [$from, $to])->where('cancel_method', '0')->whereIsCancelled(true)->count(),
                    'u' => Request::companyKey()->whereBetween('created_at', [$from, $to])->where('cancel_method', '1')->whereIsCancelled(true)->count(),
                    'd' => Request::companyKey()->whereBetween('created_at', [$from, $to])->where('cancel_method', '2')->whereIsCancelled(true)->count(),
                ];
                $data['earnings']['months'][] = $monthName;
                $data['earnings']['values'][] = RequestBill::whereHas('requestDetail', function ($query) use ($from, $to) {
                    $query->companyKey()->whereBetween('trip_start_time', [$from, $to])->whereIsCompleted(true);
                })->sum('total_amount');

                $startDate->addMonth();
            }
        }

        if (auth()->user()->countryDetail) {
            $currency = auth()->user()->countryDetail->currency_symbol;
        } else {
            $currency = get_settings(Settings::CURRENCY);
        }
        // $currency = auth()->user()->countryDetail->currency_code ?: env('SYSTEM_DEFAULT_CURRENCY');
        $currency = get_settings('currency_code');

        return view('admin.dashboard', compact('page', 'main_menu', 'currency', 'sub_menu', 'total_drivers', 'total_users', 'trips', 'todayEarnings', 'overallEarnings', 'data'));
    }
}
