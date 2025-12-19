<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Battle;
use App\Models\zone;
use App\Models\Badge;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Testimonial;
use Intervention\Image\Facades\Image;
use ColorThief\ColorThief;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Packages;

class DashboardController extends Controller
{
    //---------------------------------  dashboard index code start -------------------------------
    public function index() {
        $setting = GeneralSetting::first();
        $user = User::all();
        $userGrowthInfo = $this->calculateUserGrowthRate();
        $userGrowthInfo = $this->calculateUserGrowthRate();
        $quiz = Quiz::all();
        $subjective = Quiz::where('type','0');
        $objective = Quiz::where('type','1');
        $activequiz = Quiz::where('status','1');
        $category = Category::all();
        $categoryGrowthInfo = $this->calculateCategoryGrowthRate();
        $blog = Blog::all();
        $battle = Battle::all();
        $battleGrowthInfo = $this->calculateBattleGrowthRate();
        $badge = Badge::all();
        $totalOrder = Order::all();
        $successOrder = Order::where('status','success');
        $failedOrder = Order::where('status','failed');
        $pendingOrder = Order::where('status','pending');
        $coupon = Coupon::all();
        $testimonial = Testimonial::all();
        $recentOrders = Order::latest()->take(4)->get();
        // Fetch the top 3 users based on their rank
        $rankers = $user->where('rank', '>', 0) // Exclude users with rank 0
        ->sortBy('rank')          // Sort by rank in ascending order
        ->take(3)                 // Take the top 3 users
        ->map(function ($user) {
            $imagePath = public_path('images/users/'.$user->image);
            $bannerColor = $this->getColorFromImage($imagePath);
            $user->bannerColor = $bannerColor;
            return $user;
        });

        $userDataWeekly = $this->getUserData('weekly');
        $userDataMonthly = $this->getUserData('monthly');
        $userDataYearly = $this->getUserData('yearly');

        $orderDataWeekly = $this->getOrderData('weekly');
        $orderDataMonthly = $this->getOrderData('monthly');
        $orderDataYearly = $this->getOrderData('yearly');

        $quizDataWeekly = $this->getQuizData('weekly');
        $quizDataMonthly = $this->getQuizData('monthly');
        $quizDataYearly = $this->getQuizData('yearly');

        $latest_quiz = Quiz::latest()->take(5)->get();
        return view('admin.dashboard.admin', compact('setting','user','userGrowthInfo' ,'quiz', 'objective' ,'subjective', 'activequiz' , 'category','categoryGrowthInfo','blog','battle','battleGrowthInfo','badge','totalOrder','successOrder','failedOrder','pendingOrder','coupon','testimonial','recentOrders','rankers','userDataWeekly', 'userDataMonthly', 'userDataYearly','latest_quiz','orderDataWeekly', 'orderDataMonthly', 'orderDataYearly','quizDataWeekly','quizDataMonthly','quizDataYearly'));
    }
    //---------------------------------  dashboard index code end -------------------------------

    public function calculateUserGrowthRate()
    {
        return $this->calculateGrowthRate(User::class);
    }

    public function calculateCategoryGrowthRate()
    {
        return $this->calculateGrowthRate(Category::class);
    }

    public function calculateBattleGrowthRate()
    {
        return $this->calculateGrowthRate(Battle::class);
    }
    private function calculateGrowthRate($model)
    {
        $now = Carbon::now();
        $thirtyDaysAgo = $now->copy()->subDays(30);

        $currentCount = $model::count();
        $oldCount = $model::where('created_at', '<', $thirtyDaysAgo)->count();
        $newCount = $currentCount - $oldCount;

        if ($oldCount > 0) {
            $growthRate = ($newCount / $oldCount) * 100;
        } else {
            $growthRate = 0;
        }

        return [
            'rate' => number_format($growthRate, 1),
            'oldCount' => $oldCount,
            'newCount' => $newCount,
            'totalCount' => $currentCount,
            'startDate' => $thirtyDaysAgo->toDateString()
        ];
    }

    //---------------------------------  get user data code start -------------------------------
    private function getUserData($interval)
    {
        $endDate = Carbon::now();
        $startDate = $endDate->copy();

        switch ($interval) {
            case 'weekly':
                $startDate = $endDate->copy()->startOfMonth();
                $groupBy = 'YEARWEEK(created_at, 1)'; // Using YEARWEEK for better week grouping
                break;
            case 'monthly':
                $startDate = $endDate->copy()->startOfYear();
                $groupBy = 'MONTH(created_at)';
                break;
            case 'yearly':
                $startDate = $endDate->copy()->subYears(4)->startOfYear();
                $groupBy = 'YEAR(created_at)';
                break;
        }

        $userData = User::select(DB::raw("COUNT(*) as count, {$groupBy} as date"))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $formattedData = [];
        $current = $startDate->copy();

        while ($current <= $endDate) {
            $dateValue = $this->getDateValue($current, $interval);
            $dateLabel = $this->getDateLabel($current, $interval);
            $count = $userData->get($dateValue)->count ?? 0;
            $formattedData[] = [
                'date' => $dateLabel,
                'count' => $count
            ];

            $current = $this->incrementDate($current, $interval);
        }

        return $formattedData;
    }
    //---------------------------------  get user data code end -------------------------------

    //---------------------------------  get date label code start -------------------------------
    private function getDateLabel($date, $interval)
    {
        switch ($interval) {
            case 'weekly':
                return 'Week ' . $date->weekOfMonth; // Week label within the month
            case 'monthly':
                return $date->format('F'); // Full month name
            case 'yearly':
                return $date->format('Y'); // Full year
        }
    }
    //---------------------------------  get date label code end -------------------------------

    //---------------------------------  get date value code start -------------------------------
    private function getDateValue($date, $interval)
    {
        switch ($interval) {
            case 'weekly':
                return $date->format('oW'); // ISO week number of year
            case 'monthly':
                return $date->month;
            case 'yearly':
                return $date->year;
        }
    }
    //---------------------------------  get date value code end -------------------------------

    //---------------------------------  increment date code start -------------------------------
    private function incrementDate($date, $interval)
    {
        switch ($interval) {
            case 'weekly':
                return $date->addWeek();
            case 'monthly':
                return $date->addMonth();
            case 'yearly':
                return $date->addYear();
        }
    }
    //---------------------------------  increment date code end -------------------------------

    //---------------------------------  get order data code start -------------------------------
    private function getOrderData($interval)
    {
        $endDate = Carbon::now();
        $startDate = $endDate->copy();

        switch ($interval) {
            case 'weekly':
                $startDate = $endDate->copy()->startOfMonth();
                $groupBy = 'YEARWEEK(created_at, 1)';
                break;
            case 'monthly':
                $startDate = $endDate->copy()->startOfYear();
                $groupBy = 'MONTH(created_at)';
                break;
            case 'yearly':
                $startDate = $endDate->copy()->subYears(4)->startOfYear();
                $groupBy = 'YEAR(created_at)';
                break;
        }

        $orderData = Order::select(DB::raw("COUNT(*) as count, {$groupBy} as date"))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $formattedData = [];
        $current = $startDate->copy();

        while ($current <= $endDate) {
            $dateValue = $this->getDateValue($current, $interval);
            $dateLabel = $this->getDateLabel($current, $interval);
            $count = $orderData->get($dateValue)->count ?? 0;
            $formattedData[] = [
                'date' => $dateLabel,
                'count' => $count
            ];

            $current = $this->incrementDate($current, $interval);
        }

        return $formattedData;
    }
    //---------------------------------  get order data code end -------------------------------

    //---------------------------------  get quiz data code start -------------------------------
    private function getQuizData($interval)
    {
        $endDate = Carbon::now();
        $startDate = $endDate->copy();

        switch ($interval) {
            case 'weekly':
                $startDate = $endDate->copy()->startOfMonth();
                $groupBy = 'YEARWEEK(created_at, 1)';
                break;
            case 'monthly':
                $startDate = $endDate->copy()->startOfYear();
                $groupBy = 'MONTH(created_at)';
                break;
            case 'yearly':
                $startDate = $endDate->copy()->subYears(4)->startOfYear();
                $groupBy = 'YEAR(created_at)';
                break;
        }

        $quizData = Quiz::select(DB::raw("COUNT(CASE WHEN type = 1 THEN 1 END) as objective_count, COUNT(CASE WHEN type = 0 THEN 1 END) as subjective_count, {$groupBy} as date"))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $formattedData = [];
        $current = $startDate->copy();

        while ($current <= $endDate) {
            $dateValue = $this->getDateValue($current, $interval);
            $dateLabel = $this->getDateLabel($current, $interval);
            $objectiveCount = $quizData->get($dateValue)->objective_count ?? 0;
            $subjectiveCount = $quizData->get($dateValue)->subjective_count ?? 0;
            $formattedData[] = [
                'date' => $dateLabel,
                'objective_count' => $objectiveCount,
                'subjective_count' => $subjectiveCount
            ];

            $current = $this->incrementDate($current, $interval);
        }

        return $formattedData;
    }
    //---------------------------------  get quiz data code end -------------------------------

    //---------------------------------  get color from image code start -------------------------------
    private function getColorFromImage(string $imagePath): string
    {
        if (!file_exists($imagePath)) {
            \Log::warning("Image file does not exist: $imagePath");
            return 'rgba(105, 73, 255, 0.05);';
        }

        if (!is_readable($imagePath)) {
            \Log::warning("Image file is not readable: $imagePath");
            return 'rgba(105, 73, 255, 0.05);';
        }

        try {
            $image = Image::make($imagePath);
        } catch (\Exception $e) {
            \Log::error("Failed to create image: " . $e->getMessage());
            return 'rgba(105, 73, 255, 0.05);';
        }

        try {
            $colorThief = new ColorThief();
            $dominantColor = $colorThief->getColor($image->getCore());
            return sprintf("#%02x%02x%02x", $dominantColor[0], $dominantColor[1], $dominantColor[2]);
        } catch (\Exception $e) {
            \Log::error("Failed to get color: " . $e->getMessage());
            return 'rgba(105, 73, 255, 0.05);';
        }
    }
    //---------------------------------  get color from image code end -------------------------------

    //---------------------------------  marketing dashboard start -------------------------------
    public function marketing()
    {
        $currentYear = date('Y');
        $availableYears = range($currentYear - 5, $currentYear);
        $selectedYear = request('year', $currentYear);

        $revenueData = $this->getRevenueData($selectedYear);
        $packageSales = $this->getPackageSalesData($selectedYear);
        $topPackages = $this->getTopPackagesRevenue();
        $totalRevenue = Order::whereYear('created_at', $selectedYear)->sum('total_amount');

        return view('admin.dashboard.admin-marketing', compact('revenueData', 'selectedYear', 'availableYears', 'packageSales', 'topPackages', 'totalRevenue'));
    }
    //---------------------------------  marketing dashboard end -------------------------------

    //---------------------------------  revenue data start -------------------------------
    private function getRevenueData($year)
    {
        $revenueByMonth = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_amount) as revenue')
        )
        ->whereYear('created_at', $year)
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->pluck('revenue', 'month')
        ->all();

        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];

        $revenueData = [];
        foreach ($months as $monthNum => $monthName) {
            $revenueData[$monthName] = $revenueByMonth[$monthNum] ?? 0;
        }

        return $revenueData;
    }
    public function getYearlyRevenueData(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $revenueData = $this->getRevenueData($year);
        return response()->json($revenueData);
    }
    //---------------------------------  revenue data end -------------------------------

    //---------------------------------  get package sales data start -------------------------------
    private function getPackageSalesData($year)
    {
        $allPackages = Packages::pluck('pname', 'id');
        $salesData = Order::select('package_id', DB::raw('COUNT(*) as sales_count'))
            ->whereYear('created_at', $year)
            ->groupBy('package_id')
            ->pluck('sales_count', 'package_id')
            ->toArray();

        $formattedData = $allPackages->map(function ($name, $id) use ($salesData) {
            return [
                'name' => $name,
                'sales' => $salesData[$id] ?? 0
            ];
        })->values();

        $formattedData = $formattedData->sortByDesc('sales')->values();

        return $formattedData;
    }

    public function getYearlyPackageSalesData(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $packageSalesData = $this->getPackageSalesData($year);
        return response()->json($packageSalesData);
    }
    //---------------------------------  get package sales data end -------------------------------

    //---------------------------------  get toppackages revenue data start -------------------------------
    protected function getTopPackagesRevenue()
    {
        return Order::select('package_id', DB::raw('SUM(total_amount) as total_revenue'))
            ->groupBy('package_id')
            ->orderBy('total_revenue', 'desc')
            ->with('package')
            ->limit(3)
            ->get();
    }
    //---------------------------------  get toppackages revenue data start -------------------------------

}
