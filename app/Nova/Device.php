<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Device extends Resource
{
    public static $group = 'device';

    public static $priority = 2;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Device::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->mac;
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('device.label');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'mac',
        'status',
    ];


    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {

        $where = [];
        if($request->user()->group_id){
            $where = [
                'group_id' => $request->user()->group_id
            ];
        }
        return $query->where($where);
    }


    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('device.name'), 'label'),
            Text::make(__('device.group'), 'group')->showOnIndex(),
            Text::make(__('device.mac'), 'mac')->sortable()->rules('required','min:17','max:17'),
            Text::make(__('device.sn'), 'sn')->sortable(),

            Hidden::make('status')->default(-1),
            Hidden::make('group_id')->default($request->user()->group_id),
        ];
    }

    /**
     * 创建前验证
     * @param NovaRequest                      $request
     * @param \Illuminate\Validation\Validator $validator
     */
    protected static function afterCreationValidation(NovaRequest $request, $validator)
    {
        $device_is_online = DB::table('paas.devices')->select(['mac'])->where('mac',$request->mac)->get()->isEmpty();
        $device_is_exists = DB::table('saas.devices')->select(['mac'])->where('mac',$request->mac)->get()->isNotEmpty();

        if ($device_is_online || $device_is_exists){
            $validator->errors()->add('field', 'Something is wrong with this field!');
        }
    }


    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [
//            (new Actions\Restart)->showOnTableRow()->canRun(function () use ($request){
//                return $request->user()->group_id > 0;
//            }),
            (new Actions\Subscription)->showOnTableRow(),
//            (new Actions\SiteSpeedUp())->showOnTableRow(),
        ];
    }
}
