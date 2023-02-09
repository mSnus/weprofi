<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('phone');

        $this->crud->addColumn(
            [
                'name'  => 'usertype',
                'label' => 'Тип',
                'type'  => 'model_function',
                'function_name' => 'getUserRoleStringAttribute',
             ],
        );

        $this->crud->addColumn(
            [
                'name'  => 'own_views',
                'label' => 'Заходов к себе',
                'type'  => 'model_function',
                'function_name' => 'getUserOwnProfileViews',
             ],
        );

        $this->crud->addColumn(
            [
                'name'  => 'views',
                'label' => 'Просмотров',
                'type'  => 'model_function',
                'function_name' => 'getUserViews',
             ],
        );
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserRequest::class);

        CRUD::field('name');
        CRUD::field('phone');
        CRUD::field('password')->type('password');

        CRUD::field('phone2');
        CRUD::field('language');
        CRUD::field('tagline');
        CRUD::field('content');
        CRUD::field('rating')->type('number');
        CRUD::field('pricelist');
        CRUD::field('timetable');
        CRUD::field('location');
        CRUD::field('region');

        $myip = '80.244.28.131';

        $this->crud->addField([
         
                'label' => "Статус",
                'type' => 'select_from_array',
                'name' => 'status',
                'default'     => 'active',
                'allows_null' => false,
                'options' => ['active' => 'active', 'disabled' => 'disabled']
         
        ]);

        if (getenv('REMOTE_ADDR') != $myip) {
            CRUD::field('spec_id')->type('number');
        } else {
            $this->crud->addField([
                'name' => 'spec_id',
                'label' => 'Специализация',
                'type' => "select",

                'model' => "App\Models\Spec",
                'attribute' => 'title',

                'allows_null' => false,
                'allows_multiple' => false,
            ]);
        }

        CRUD::field('subspec_id');

        CRUD::field('invite_token')->default(strtolower(Str::random(10)));

        // CRUD::field('avatar')->type('number');
        $this->crud->addField([
         
            'label' => "Тип",
            'type' => 'select_from_array',
            'name' => 'usertype',
            'default'     => User::typeMaster,
            'allows_null' => false,
            'options' => [User::typeClient => 'пользователь', User::typeMaster => 'профи']
     
    ]);
       

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function update()
    {
        $user = $this->crud->getCurrentEntry();
        $request = (object) $this->crud->getRequest()->request->all();

        if ($user->usertype == User::typeMaster) {
                DB::table('user_spec')->where('user_id', '=', $user->id)->delete();

                $subspec_list = explode(',', $request->subspec_id);

                if (count($subspec_list) > 0 && !in_array(0, $subspec_list)) {
                    foreach ($subspec_list as $subspec) {
                        $spec_data[] = [
                            'user_id' => $user->id,
                            'spec_id' => $request->spec_id,
                            'subspec_id' => $subspec
                        ];
                    }
                } else {      
                    $spec_data = [
                        'user_id' => $user->id,
                        'spec_id' => $request->spec_id,
                        'subspec_id' => 0
                    ];
                }
                DB::table('user_spec')->insert($spec_data);
        }

        $response = $this->traitUpdate();
        
        return $response;
    }
}
