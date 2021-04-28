<?php

class Textarea extends ComponentBase
{

    function __construct($label, $rexValueId, $path2Value, $slice)
    {
        parent::__construct($label, $rexValueId, $path2Value, $slice);
    }

    public function getHTML()
    {
        $htmlOutput = '';
        $rex_value_1 = $this->getCurrentValue($this->rexValue, $this->path2Value);
        $htmlOutput .=
            '<label style="width: 100%;" for="c-' . join("-", $this->path2Value) . '">' .
            $this->label .
            ':</label>' .
            '<textarea rows="10" type="text" data-rex-item-id="' . join(",", $this->path2Value) . '" 
                    name="REX_INPUT_VALUE[' . $this->rexValueId . '][' . join("][", $this->path2Value) . ']" 
                    class="form-control"
                    id="c-' . join("-", $this->path2Value) . '" />' .
            $rex_value_1 .
            '</textarea>';
        return $htmlOutput;
    }
}
