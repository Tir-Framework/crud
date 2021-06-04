<?php

namespace Tir\Crud\Support\Scaffold\Fields;


abstract Class BaseField
{

    protected string $type;
    protected string $name;
    protected string $visible;
    protected string $display;
    protected string $placeholder;
    protected bool $disable;
    protected string $defaultValue;
    protected bool $showOnIndex = true;
    protected bool $showOnDetail = true;
    protected bool $showOnCreating = true;
    protected bool $showOnEditing = true;
    protected bool $sortable;
    protected mixed $roles = '';

    /**
     * Add name attribute to input
     * For label remove underline and capital of first character of each word
     *
     * @param string $name It will be name of input field
     * @return $this
     */
    public static function make(string $name): static
    {
        $obj = new static;
        $obj->name = $name;
        $obj->display($name);
        return $obj;
    }


    /**
     * Add display attribute to input
     *
     * @param string $value It will be display attribute of input
     * @return $this
     */
    public function display(string $value): static
    {
        $this->display = ucwords(str_replace('_',' ', $value));
        return $this;
    }

    /**
     * Add display class to input
     *
     * @param string $name
     * @return $this
     */
    public function class(string $name): static
    {
        $this->class = $name;
        return $this;
    }

    /**
     * Add display id to input
     *
     * @param string $name
     * @return $this
     */
    public function id(string $name): static
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
    public function placeholder(string $text): static
    {
        $this->placeholder = $text;
        return $this;
    }

    /**
     * Add disable attribute to input
     *
     * @param bool $option
     * @return $this
     */
    public function disable(bool $option): static
    {
        $this->disable = $option;
        return $this;
    }


    /**
     * Add value attribute to input
     *
     * @param string $value
     * @return $this
     */
    public function default(string $value): static
    {
        $this->defaultValue = $value;
        return $this;
    }


    /**
     * @return $this
     */
    public function showOnIndex(bool $callback = true): static
    {
        $this->showOnIndex = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : $callback;
        return $this;
    }


    public function showOnCreating(bool $callback = true): static
    {
        $this->showOnCreating = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : $callback;
        return $this;
    }


    public function showOnEditing(bool $callback = true): static
    {
        $this->showOnEditing = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : $callback;
        return $this;
    }


    public function showOnDetail(bool $callback = true): static
    {
        $this->showOnEditing = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : $callback;
        return $this;
    }


    /**
     * @param bool $callback
     * @return $this
     */
    public function hideFromIndex(bool $callback = true): static
    {
        $this->showOnIndex = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : !$callback;
        return $this;
    }


    /**
     * @param bool $callback
     * @return $this
     */
    public function hideWhenCreating(bool $callback = true): static
    {
        $this->showOnCreating = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : !$callback;
        return $this;
    }


    /**
     * @param bool $callback
     * @return $this
     */
    public function hideWhenEditing(bool $callback = true): static
    {
        $this->showOnEditing = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : !$callback;
        return $this;
    }


    /**
     * @param bool $callback
     * @return $this
     */
    public function hideFromDetail(bool $callback = true): static
    {
        $this->showOnDetail = is_callable($callback) ? !call_user_func_array($callback, func_get_args())
            : !$callback;
        return $this;
    }

    public function hideFromAll(bool|callable $callback = true): static
    {

        $this->showOnCreating =
        $this->showOnEditing =
        $this->showOnIndex =
        $this->showOnDetail =
            is_callable($callback) ? !call_user_func_array($callback, func_get_args())
                : !$callback;
        return $this;
    }

    public function onlyOnIndex(): static
    {
        $this->showOnCreating = $this->showOnEditing = $this->showOnDetail = false;
        $this->showOnIndex = true;
        return $this;
    }

    public function onlyOnCreating(): static
    {
        $this->showOnIndex = $this->showOnEditing = $this->showOnDetail = false;
        $this->showOnCreating = true;
        return $this;
    }

    public function onlyOnEditing(): static
    {
        $this->showOnCreating = $this->showOnEditing = $this->showOnDetail = false;
        $this->showOnEditing = true;
        return $this;
    }

    public function onlyOnDetail(): static
    {
        $this->showOnCreating = $this->showOnEditing = $this->showOnIndex = false;
        $this->showOnDetail = true;
        return $this;
    }

    /**
     * @param bool $check
     * @return $this
     */
    public function sortable(bool $check = true): static
    {
        $this->sortable = $check;
        return $this;
    }


    public function rules(mixed ...$role): static
    {
        $this->roles = $role;
        return $this;
    }

    public function creationRules(mixed ...$role): static
    {
        $this->roles = $role;
        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return get_object_vars($this);
    }

}