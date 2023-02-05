<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Services\HelperServices;
use DB;
use Filament\Widgets\PieChartWidget;

class CategoryOverview extends PieChartWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Category Overview';

    protected static ?string $maxHeight = '300px';
    private HelperServices $helperServices;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->helperServices = new HelperServices();
    }

    protected function getData(): array
    {
        $categories = Book::select(['categories.name', DB::raw('count(*) as total_books')])
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->get();
        $labels = $categories->pluck('name');
        $data = $categories->pluck('total_books');
        return [
            'datasets' => [
                [
                    'label' => 'Category Overview',
                    'data' => $data,
                    'backgroundColor'=> $this->randomColor(count($labels)),
                    'borderColor'=>'#fff',
                    'hoverOffset'=>4
                ],
            ],
            'labels' => $labels,

        ];
    }
    function randomColor($total): array
    {
        return $this->helperServices->randomColor($total);
    }
}
