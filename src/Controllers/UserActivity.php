<?php

namespace Dp0\UserActivity\Controllers;

use App\Models\User;
use Dp0\UserActivity\Models\UserActivity as UserActivityModel;

use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Validator;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Factory\RendererFactory;
use Livewire\WithPagination;

class UserActivity extends Component
{
    use WithPagination;
    public $table;
    public $event;
    public $userId;
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $tables;
    private $diffrence;
    public $startDate;
    public $endDate;
    public $viewActivity;

    public function rules()
    {
        return [
            'table' => [
                'nullable', 'string',
                function ($attribute, $value, $fail) {
                    if (!array_search($value, $this->tables->toArray()) && $value) {
                        $this->reset('table');
                        $fail('The selected ' . $attribute . ' is invalid.');
                    }
                }
            ],
            'userId' => ['nullable', 'exists:users,id'],
            'perPage' => ['in:all,10,20,50,100,250,500,1000'],
            'event' => ['nullable', 'in:all,login,create,update,delete,logout,lockout'],
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date', 'after_or_equal:startDate'],
            'sortField' => ['required','in:id,event,table,user_id,ip_address']
        ];
    }

    public function mount()
    {
        $this->startDate = now()->startOfDay()->format('Y-m-d H:i:s');
        $this->endDate = now()->endOfDay()->format('Y-m-d H:i:s');
        $tables_except = collect(config('user-activity.tables_except'));
        $this->tables = collect(Schema::getConnection()->select('show tables'))
            ->pluck('Tables_in_' . config('user-activity.db_name'))
            ->diff($tables_except);
    }

    public function updated($propertyName)
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if ($validator->errors()) {
                    $this->resetPage();
                }
            });
        })->validate();
        if ($propertyName === 'perPage' && $this->perPage == 'all') {
            $this->perPage = UserActivityModel::count();
        }
    }
    public function render()
    {
        $query = UserActivityModel::join('users', 'user_activities.user_id', '=', 'users.id')->select(['user_activities.*', 'name']);
        if ($this->table) {
            $query->where('user_activities.table', $this->table);
        }
        if ($this->event != 'all' && $this->event) {
            $query->where('user_activities.event', $this->event);
        }
        if ($this->userId) {
            $query->where('user_activities.user_id', $this->userId);
        }
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('user_activities.created_at', [$this->startDate, $this->endDate]);
        }
        $userActivities = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        $users = User::select('id', 'name')->get();
        return view('UserActivity::user-activity', [
            'userActivities' => $userActivities,
            'users' => $users,
            'diffrence' => $this->diffrence,
            'viewActivity' => $this->viewActivity
        ]);
    }
    public function sortBy($field)
    {
        if ($field === $this->sortField) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    public function getDialogContent($activityId)
    {
        $activity = UserActivityModel::join('users', 'user_activities.user_id', '=', 'users.id')
            ->select('user_activities.*', 'users.name')
            ->findOrFail($activityId);
        $this->viewActivity = $activity;
        $old_data = ($activity->old_data != "null") ? json_decode($activity->old_data) : [];
        $new_data = ($activity->new_data != "null") ? json_decode($activity->new_data) : [];
        $jsonResult = DiffHelper::calculate($old_data, $new_data, 'Json');
        $htmlRenderer = RendererFactory::make(config('user-activity.jfcherng_php_diff.rendererName'), config('user-activity.jfcherng_php_diff.rendererOptions'), config('user-activity.jfcherng_php_diff.differOptions'));
        $result = $htmlRenderer->renderArray(json_decode($jsonResult, true));
        $this->diffrence = new HtmlString($result);
    }
}
