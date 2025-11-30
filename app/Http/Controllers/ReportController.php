<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort');
        if ($sort != 'asc' && $sort != 'desc') {
            $sort = 'desc';
        }

        $status = $request->input('status');
        $validate = $request->validate([
            'status' => "exists:statuses,id"
        ]);
        
        // Для администраторов показываем все заявления, для пользователей - только свои
        if (Auth::user()->is_admin) {
            if ($validate && $status) {
                $reports = Report::with(['user', 'status'])
                    ->where('status_id', $status)
                    ->orderBy('created_at', $sort)
                    ->paginate(10);
            } else {
                $reports = Report::with(['user', 'status'])
                    ->orderBy('created_at', $sort)
                    ->paginate(10);
            }
        } else {
            if ($validate && $status) {
                $reports = Report::with('status')
                    ->where('status_id', $status)
                    ->where('user_id', Auth::user()->id)
                    ->orderBy('created_at', $sort)
                    ->paginate(5);
            } else {
                $reports = Report::with('status')
                    ->where('user_id', Auth::user()->id)
                    ->orderBy('created_at', $sort)
                    ->paginate(5);
            }
        }

        $statuses = Status::all();
        return view('reports.index', compact('reports', 'statuses', 'sort', 'status'));
    }

    public function destroy(Report $report)
    {
        if (Auth::user()->id === $report->user_id) {
            $report->delete();
            return redirect()->route('reports.index')->with('success', 'Заявление успешно удалено.');
        } else {
            abort(403, 'У вас нет прав на удаление этой записи.');
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'number' => 'required|string|max:20',
            'description' => 'required|string|min:10|max:1000',
        ]);

        $data['user_id'] = Auth::user()->id;
        $data['status_id'] = 1;

        Report::create($data);
        return redirect()->route('reports.index')->with('success', 'Заявление успешно создано.');
    }

    public function edit(Report $report)
    {
        if (Auth::user()->id === $report->user_id) {
            return view('reports.edit', compact('report'));
        } else {
            abort(403, 'У вас нет прав на редактирование этой записи.');
        }
    }

    public function update(Request $request, Report $report)
    {
        if (Auth::user()->id === $report->user_id) {
            $data = $request->validate([
                'number' => 'required|string|max:20',
                'description' => 'required|string|min:10|max:1000',
            ]);

            $report->update($data);
            return redirect()->route('reports.index')->with('success', 'Заявление успешно обновлено.');
        } else {
            abort(403, 'У вас нет прав на редактирование этой записи.');
        }
    }

    public function show(Report $report)
    {
        // Админы могут просматривать все заявления, пользователи - только свои
        if (Auth::user()->is_admin || Auth::user()->id === $report->user_id) {
            $statuses = Status::all();
            return view('reports.show', compact('report', 'statuses'));
        } else {
            abort(403, 'У вас нет прав на просмотр этой записи.');
        }
    }

    public function statusUpdate(Request $request, Report $report)
    {
        // Только администраторы могут менять статусы
        if (!Auth::user()->is_admin) {
            return redirect()->route('reports.index')->with('error', 'У вас нет прав на изменение статуса заявления.'); 
        }

        $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);
        
        $report->update($request->only(['status_id']));
        return redirect()->back()->with('success', 'Статус заявления успешно обновлен.');
    }
}