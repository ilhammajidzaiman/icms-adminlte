<?php

namespace App\View\Components\Private\Form;

use Illuminate\View\Component;

class InputTextarea extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $rows;
    public $name;
    public $label;
    public $class;
    public $value;

    public function __construct($rows, $name, $label, $class, $value)
    {
        $this->rows = $rows;
        $this->name = $name;
        $this->label = $label;
        $this->class = $class;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.private.form.input-textarea');
    }
}
