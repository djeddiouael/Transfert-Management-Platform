<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Chart extends Component
{
    public $lineChartData;
    public $barChartData;
    public $pieChartData;
    public $doughnutChartData;
    public $radarChartData;
    public $polarAreaChartData;
    public $bubbleChartData;
    public $scatterChartData;

    public function mount()
    {
        $this->lineChartData = [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'data' => [65, 59, 80, 81, 56, 55, 40],
                    'fill' => false,
                ],
            ],
        ];

        $this->barChartData = $this->lineChartData;

        $this->pieChartData = [
            'labels' => ['Red', 'Blue', 'Yellow'],
            'datasets' => [
                [
                    'data' => [300, 50, 100],
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56'],
                ],
            ],
        ];

        $this->doughnutChartData = $this->pieChartData;

        $this->radarChartData = [
            'labels' => ['Eating', 'Drinking', 'Sleeping', 'Designing', 'Coding', 'Cycling', 'Running'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'data' => [65, 59, 90, 81, 56, 55, 40],
                ],
            ],
        ];

        $this->polarAreaChartData = [
            'labels' => ['Red', 'Green', 'Yellow', 'Grey', 'Blue'],
            'datasets' => [
                [
                    'data' => [11, 16, 7, 3, 14],
                    'backgroundColor' => ['#FF6384', '#4BC0C0', '#FFCE56', '#E7E9ED', '#36A2EB'],
                ],
            ],
        ];

        $this->bubbleChartData = [
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'data' => [
                        ['x' => 20, 'y' => 30, 'r' => 15],
                        ['x' => 40, 'y' => 10, 'r' => 10],
                    ],
                ],
            ],
        ];

        $this->scatterChartData = [
            'datasets' => [
                [
                    'label' => 'Scatter Dataset',
                    'data' => [
                        ['x' => -10, 'y' => 0],
                        ['x' => 0, 'y' => 10],
                        ['x' => 10, 'y' => 5],
                    ],
                ],
            ],
        ];
    }
    public function render()
    {
        return view('livewire.chart');
    }
}
