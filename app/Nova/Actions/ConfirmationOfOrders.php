<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\DestructiveAction;
use Laravel\Nova\Fields\ActionFields;


class ConfirmationOfOrders extends DestructiveAction
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = '确认订单';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $ip = config('paas.ip');
        $port = config('paas.port');
        $streamClient = stream_socket_client("tcp://{$ip}:{$port}");
        $data = array(
            'auth_name'=>config('paas.auth_name'),
            'key' => config('paas.key'),
        );

        foreach ($models as $model) {
            $model->status = 1;
            $model->save();

            $data['action'] =config('paas.type.'.$fields->type);
            fwrite($streamClient, json_encode($data));
        }

        fclose($streamClient);
        return Action::message('重启' . $models->count() . '个设备');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
