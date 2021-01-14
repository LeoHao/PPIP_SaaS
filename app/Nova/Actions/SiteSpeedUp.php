<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class SiteSpeedUp extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = '站点加速';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $dedicatedInfo = \App\Site::find($fields->id)->toArray();

        $ip           = config('paas.ip');
        $port         = config('paas.port');
        $streamClient = stream_socket_client("tcp://{$ip}:{$port}");
        $data         = [
            'clientType' => config('paas.auth_name'),
            'key'        => config('paas.key'),
            'action'     => 'plugins_network_special_open',
        ];

        foreach ($models as $model) {
            $model->status = 0;
            $model->save();
            $data['mac']       = $model->mac;
            $data['actionExt'] = $dedicatedInfo;
            fwrite($streamClient, json_encode($data));
        }

        fclose($streamClient);
        return Action::message('配置推送' . $models->count() . '个设备');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make(__('dedicated.choose'), 'id')->options(function () {
                $nodeInfo = \App\Site::all()->toArray();
                $nodeInfo = array_column($nodeInfo, null, 'id');
                return $nodeInfo;
            })->displayUsingLabels(),
        ];
    }
}
