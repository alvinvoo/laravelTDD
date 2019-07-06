<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Project;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update', $this->project());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'title'=>'sometimes | required',
                'description'=>'sometimes | required',
                'notes' => 'nullable'
        ];
    }

    protected function project(){
        // $this->route('project')
        // return the Project object, IF it's passed via auto Route model binding
        // OR just the param being passed in if there's no auto Route model binding
        // iter 3.
        // so by using below, we r sure this will return a Project object even if auto Route model binding is not injected
        return Project::findOrFail($this->route('project'));
    }

    public function update(){

        // if we just do $this->project()->update(..); this returns a boolean value, what we need is to return the project instance
        // using higherOrderTap, we could cache the instance _first_ by parameterizing it, it would later return this cache instance after the execution of the subsequent method (or via callback - just tap)

        return tap($this->project())->update($this->validated());
    }
}
