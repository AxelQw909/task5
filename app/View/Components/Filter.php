<?php

namespace App\View\Components;

use App\Models\Status;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Filter extends Component
{
    public $sort;
    public $status;
    public $statuses;

    /**
     * Create a new component instance.
     */
    public function __construct($sort = null, $status = null)
    {
        $this->sort = $sort;
        $this->status = $status;
        $this->statuses = Status::all(); // Получаем все статусы из базы данных
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.filter');
    }
}