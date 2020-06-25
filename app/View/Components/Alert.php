<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $arrayClasses = [
        'alert',
    ];

    public $classes = '';

    public $content = null;

    public $dismissible = false;

    /**
     * Create a new component instance.
     *
     * @param null $content
     * @param string $type
     * @param bool $dismissible
     */
    public function __construct($content = null, $type = 'primary', $dismissible = false)
    {
        $this->content = $content;
        $this->dismissible = $dismissible;

        array_push($this->arrayClasses, "alert-{$type}");

        if ($dismissible) {
            array_push($this->arrayClasses, 'alert-dismissible fade show');
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $this->classes = implode(" ", $this->arrayClasses);

        return view('components.alert');
    }
}
