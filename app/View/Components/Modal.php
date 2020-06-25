<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $id;
    public $message;
    public $title;
    public $type;
    public $method = 'POST';
    public $action = '#';
    public $classes = '';

    /**
     * Create a new component instance.
     *
     * @param        $id
     * @param null   $message
     * @param null   $title
     * @param null   $type
     * @param string $method
     * @param string $action
     * @param string $classes
     */
    public function __construct($id, $message = null, $title = null, $type = null, $method = 'POST', $action = '#', $classes = '')
    {
        $this->id = $id;
        $this->message = $message;
        $this->title = $title;
        $this->type = $type;
        $this->method = $method;
        $this->action = $action;
        $this->classes = $classes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
