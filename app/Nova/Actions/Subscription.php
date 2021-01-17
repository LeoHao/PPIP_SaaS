<?php

namespace App\Nova\Actions;

use App\Order;
use App\Duration;
use App\Plugin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Select;

class Subscription extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = '功能订阅';

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection    $models
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $order = new Order;
            $order->type = $fields->type;
            $order->duration_id = $fields->tid;
            $order->group_id = $fields->gid;
            $order->device_id = $model->id;
            $order->status = 0;
            $order->save();
            unset($order);
        }

        return Action::message('申请成功,等待管理员审核');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make(__('dedicated.type'),'type')->options(function () {
                $nodeInfo = Plugin::get()->toArray();
                $nodeInfo = array_column($nodeInfo, null, 'id');
                return $nodeInfo;
            })->displayUsingLabels(),

            Select::make(__('dedicated.chooseNode'), 'id')->options(function () {
                $nodeInfo = \App\Dedicated::get()->toArray();
                $nodeInfo = array_column($nodeInfo, null, 'id');
                return $nodeInfo;
            })->displayUsingLabels(),

            Select::make(__('dedicated.chooseTime'), 'tid')->options(function () {
                $durationInfo = Duration::get()->toArray();
                $durationInfo = array_column($durationInfo, null, 'id');
                return $durationInfo;
            })->displayUsingLabels(),

            Hidden::make('gid')->default(Auth::user()->group_id)
        ];
    }
}
