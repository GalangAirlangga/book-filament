<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Services\HelperServices;
use DB;
use Filament\Widgets\PieChartWidget;

class PublisherOverview extends PieChartWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Publisher Overview';

    protected static ?string $maxHeight = '300px';

    private HelperServices $helperServices;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->helperServices = new HelperServices();
    }
    protected function getData(): array
    {
        $publishers = Book::join('publishers', 'publishers.id', '=', 'books.publisher_id')
            ->select(['publishers.name', DB::raw('count(*) as total_books')])
            ->groupBy('publishers.name')
            ->get();

        $labels = $publishers->pluck('name');
        $data = $publishers->pluck('total_books');
        return [
            'datasets' => [
                [
                    'label' => 'Publisher Overview',
                    'data' => $data,
                    'backgroundColor'=> $this->randomColor(count($labels)),
                    'borderColor'=>'#fff',
                    'hoverOffset'=>4
                ],
            ],
            'labels' =>$labels,
        ];
    }

    function randomColor($total): array
    {
        return $this->helperServices->randomColor($total);
    }
}
