<?php
class BaseModel extends Eloquent {
    protected $errors;

    public function passes($data = null)
    {
        $input = $data ?: Input::all();
        $validation = Validator::make($input, static::$rules);

        if($validation->passes()) return true;

        $this->errors = $validation->messages();

        return false;
    }
    public function errors()
    {
        return $this->errors;
    }
}
