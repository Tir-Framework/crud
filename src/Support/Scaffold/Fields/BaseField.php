<?php

namespace Tir\Crud\Support\Scaffold\Fields;

use Illuminate\Support\Arr;

abstract class BaseField
{

    protected string $type;
    protected string $name;
    protected string $valueType = 'string';
    protected $value;
    protected string $visible;
    protected string $display;
    protected string $placeholder = '';
    protected string $id = '';
    protected string $class = '';
    protected string $group = 'all';
    protected int $col = 24;
    protected bool $disable =false;
    protected bool $readonly = false;
    protected string $defaultValue;
    protected bool $showOnIndex = true;
    protected bool $showOnDetail = true;
    protected bool $showOnCreating = true;
    protected bool $showOnEditing = true;
    protected bool $sortable = true;
    protected bool $searchable = false;
    protected $rules = '';
    protected $creationRules = '';
    protected $updateRules = '';
    protected array $options = [];
    protected array $filter = [];
    protected bool $filterable = false;
    protected bool $multiple = false;
    protected array $comment = [];


    /**
     * Add name attribute to input
     * For label remove underline and capital of first character of each word
     *
     * @param string $name It will be name of input field
     * @return $this
     */
    public static function make(string $name): BaseField
    {
        $obj = new static;
        $obj->name = $obj->id = $obj->class = $name;
        $obj->display($name);
        return $obj;
    }


    /**
     * Add display attribute to input
     *
     * @param string $value It will be display attribute of input
     * @return $this
     */
    public function display(string $value): BaseField
    {
        $this->display = ucwords(str_replace('_', ' ', $value));
        return $this;
    }

    /**
     * Add display class to input
     *
     * @param string $name
     * @return $this
     */
    public function class(string $name): BaseField
    {
        $this->class = $this->class . ' ' . $name;
        return $this;
    }

    /**
     * Add display group to input
     *
     * @param string $name
     * @return $this
     */
    public function group(string $name): BaseField
    {
        $this->group = $name;
        return $this;
    }

    /**
     * Add display id to input
     *
     * @param string $name
     * @return $this
     */
    public function id(string $name): BaseField
    {
        $this->id = $name;
        return $this;
    }

    /**
     * Add placeholder attribute to input
     *
     * @param string $text
     * @return $this
     */
    public function placeholder(string $text): BaseField
    {
        $this->placeholder = $text;
        return $this;
    }

    /**
     * Add comment for help
     *
     * @param string $text
     * @return $this
     */
    public function comment(string $content, string $title = ''): BaseField
    {
        $this->comment = [
            'title' => $title,
            'content' => $content,
        ];
        return $this;
    }

    /**
     * Add disable attribute to input
     *
     * @param bool $option
     * @return $this
     */
    public function disable(bool $option = true): BaseField
    {
        $this->disable = $option;
        return $this;
    }

    public function readonly(bool $option = true): BaseField
    {
        $this->readonly = $option;
        return $this;
    }

    public function options($options = [])
    {
        $this->options = $options;
    }


    /**
     * Add value attribute to input
     *
     * @param string $value
     * @return $this
     */
    public function default(string $value): BaseField
    {
        $this->defaultValue = $value;
        return $this;
    }

    /**
     * @return $this
     */
    public function showOnIndex($callback = true): BaseField
    {
        $this->showOnIndex = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : $callback;
        return $this;
    }


    public function showOnCreating($callback = true): BaseField
    {
        $this->showOnCreating = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : $callback;
        return $this;
    }


    public function showOnEditing(bool $callback = true): BaseField
    {
        $this->showOnEditing = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : $callback;
        return $this;
    }


    public function showOnDetail(bool $callback = true): BaseField
    {
        $this->showOnEditing = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : $callback;
        return $this;
    }


    /**
     * @param bool $callback
     * @return $this
     */
    public function hideFromIndex(bool $callback = true): BaseField
    {
        $this->showOnIndex = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : !$callback;
        return $this;
    }


    /**
     * @param bool $callback
     * @return $this
     */
    public function hideWhenCreating(bool $callback = true): BaseField
    {
        $this->showOnCreating = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : !$callback;
        return $this;
    }


    /**
     * @param bool|callable $callback
     * @return $this
     */
    public function hideWhenEditing($callback = true): BaseField
    {
        $this->showOnEditing = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : !$callback;
        return $this;
    }


    /**
     * @param bool $callback
     * @return $this
     */
    public function hideFromDetail($callback = true): BaseField
    {
        $this->showOnDetail = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : !$callback;
        return $this;
    }

    public function hideFromAll($callback = true): BaseField
    {
        $this->showOnCreating =
        $this->showOnEditing =
        $this->showOnIndex =
        $this->showOnDetail =
            is_callable($callback) ? !call_user_func_array($callback, func_get_args())
                : !$callback;
        return $this;
    }

    public function onlyOnIndex(): BaseField
    {
        $this->showOnCreating = $this->showOnEditing = $this->showOnDetail = false;
        $this->showOnIndex = true;
        return $this;
    }

    public function onlyOnCreating(): BaseField
    {
        $this->showOnIndex = $this->showOnEditing = $this->showOnDetail = false;
        $this->showOnCreating = true;
        return $this;
    }

    public function onlyOnEditing(): BaseField
    {
        $this->showOnCreating = $this->showOnIndex = $this->showOnDetail = false;
        $this->showOnEditing = true;
        return $this;
    }

    public function onlyOnDetail(): BaseField
    {
        $this->showOnCreating = $this->showOnEditing = $this->showOnIndex = false;
        $this->showOnDetail = true;
        return $this;
    }

    /**
     * @param bool $check
     * @return $this
     */
    public function sortable(bool $check = true): BaseField
    {
        $this->sortable = $check;
        return $this;
    }

    /**
     * @param bool $check
     * @return $this
     */
    public function searchable(bool $check = true): BaseField
    {
        $this->searchable = $check;
        return $this;
    }


    public function rules(...$rules): BaseField
    {
        $this->rules = $rules;
        return $this;
    }

    public function creationRules(...$rules): BaseField
    {
        $this->creationRules = $rules;
        return $this;
    }

    public function updateRules(...$rules): BaseField
    {
        $this->updateRules = $rules;
        return $this;
    }

    public function filter($items = []): BaseField
    {
        $this->filterable = true;
        $this->filter = $items;
        return $this;
    }

    public function get($dataModel): array
    {
        if(isset($dataModel)){
            $this->setValue($dataModel);
        }
        return get_object_vars($this);
    }


    protected function setValue($model)
    {

        $this->value = Arr::get($model, $this->name);

    }
}
